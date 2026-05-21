@extends('_layouts.app')

@section('title')
    Trading Journey - {{ $total }}
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <form method="GET" action="{{ url('journey') }}">
                            @csrf
                            <select class="form-control" name="select_journey_id" onchange="this.form.submit()">
                                @foreach ($journeys as $journey)
                                    <option value="{{ $journey->id }}" {{ $select_journey && $select_journey->id == $journey->id ? "selected" : "" }}>{{ $journey->name }}</option>
                                @endforeach
                            </select>
                        </form>
                        @include('journey.summary.snr14')
                    </div>
                    <div class="col-md-3">
                        <form id="note_from" method="POST" action="{{ url('journey/note') }}">
                            @csrf
                            <input type="hidden" name="journey_id" value="{{ $select_journey->id }}" />
                            <textarea class="form-control" name="note" rows="8">{{ $select_journey->note }}</textarea>
                        </form>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-primary" onClick="javascript: document.getElementById('note_from').submit();">
                            <span class="fas fa-save" />
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @php
                            if ($sort_direction == 'ASC') {
                                $sort_direction = 'DESC';
                            } else {
                                $sort_direction = 'ASC';
                            }

                            $select_journey_id = $select_journey ? $select_journey->id : 0;
                            $edit_journey_item_id = $edit_journey_item ? $edit_journey_item->id : 0;
                        @endphp
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="150px">Date</th>
                                    <th>Position</th>
                                    <th>Result</th>
                                    <th>Image</th>
                                    <th>Note</th>
                                    <th width="200px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($journey_items as $item)
                                    @if ($edit_journey_item && $edit_journey_item->id == $item->id)
                                    @php
                                        $is_edit = true;
                                    @endphp
                                    @else
                                    @php
                                        $is_edit = false;
                                    @endphp
                                    @endif
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{!! $item->dposition !!}</td>
                                        <td>{!! $item->dresult_r1 !!}</td>
                                        <td>
                                            @if ($item->image)
                                                <a href="{{ url('journey/image/'.$select_journey->id.'/'.$item->id) }}" target="_blank">
                                                    <img src="{{ $item->dimage }}" width="50px" title="{{ $item->note }}" />
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $item->note }}</td>
                                        <td width="20%">
                                            @if (!$is_edit)
                                                <a href="{{ url('journey/' . $select_journey->id . "/" . $item->id . '?page=' . $journey_items->currentPage()) }}" class="btn btn-success">
                                                    <span class="fas fa-edit" />
                                                </a>
                                                <a href="{{ url("journey/delete/" . $select_journey->id . "/" . $item->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <span class="fas fa-trash" />
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="12" align="right">
                                        <div align="right">
                                            {{ $journey_items->appends([
                                                'select_journey_id' => $select_journey ? $select_journey->id : 0
                                            ])->links() }}
                                        </div>
                                        <a href="https://wn.in.th/journey?select_journey_id={{ $select_journey->id }}&amp;page={{ $lastPage }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                            Last »
                                        </a>
                                    </td>
                                </tr>
                                <form method="POST" action="{{ url('journey') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="select_journey_id" value="{{ $select_journey ? $select_journey->id : 0 }}" />
                                    <input type="hidden" name="edit_journey_item_id" value="{{ $edit_journey_item ? $edit_journey_item->id : 0  }}" />
                                    <input type="hidden" name="page" value="{{ $journey_items->currentPage() }}" />
                                    <tr>
                                        <td>
                                            <input type="text" name="date" class="form-control" value="{{ $edit_journey_item ? $edit_journey_item->date : $default_date }}" />
                                        </td>
                                        <td width="100px">
                                            <select class="form-control" name="position">
                                                <option {{ $edit_journey_item && $edit_journey_item->position == 'BUY' ? 'selected' : '' }}>BUY</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->position == 'SELL' ? 'selected' : '' }}>SELL</option>
                                            </select>
                                        </td>
                                        <td width="100px">
                                            <select class="form-control" name="result_r1">
                                                <option {{ $edit_journey_item && $edit_journey_item->result_r1 == 'WIN' ? 'selected' : '' }}>WIN</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->result_r1 == 'LOSS' ? 'selected' : '' }}>LOSS</option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <input type="file" name="image" />
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">
                                                <span class="fas fa-save" />
                                            </button>
                                            @if ($edit_journey_item)
                                                <a href="{{ url('journey/' . $select_journey->id . '?page=' . $journey_items->currentPage()) }}" class="btn btn-danger">
                                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <input class="form-control" size="50" name="note" value="{{ $edit_journey_item ? $edit_journey_item->note : '' }}" />
                                        </td>
                                        <td></td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
