@extends('_layouts.app')

@section('title')
    Trading Journey - {{ $total }}
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <form method="GET" action="{{ url('journey') }}">
                            @csrf
                            <select class="form-control" name="select_journey_id" onchange="this.form.submit()">
                                @foreach ($journeys as $journey)
                                    <option value="{{ $journey->id }}" {{ $select_journey && $select_journey->id == $journey->id ? "selected" : "" }}>{{ $journey->name }}</option>
                                @endforeach
                            </select>
                        </form>
                        @if ($select_journey->id == 16 || $select_journey->id == 17)
                            {{-- RR 1:2 --}}
                            @include('journey.summary.snr16')
                        @else
                            {{-- RR 1:1.5 --}}
                            @include('journey.summary.snr14')
                        @endif
                    </div>

                    <div class="col-xs-12 col-md-4" style="margin-top: 15px;">
                        <form id="note_from" method="POST" action="{{ url('journey/note') }}">
                            @csrf
                            <input type="hidden" name="journey_id" value="{{ $select_journey->id }}" />
                            <textarea class="form-control" name="note" rows="8">{{ $select_journey->note }}</textarea>
                        </form>
                        <button type="button" class="btn btn-primary btn-block" style="margin-top: 8px;"
                            onClick="javascript: document.getElementById('note_from').submit();">
                            <span class="fas fa-save"></span> Save Note
                        </button>
                    </div>
                </div>

                <div class="row" style="margin-top: 15px;">
                    <div class="col-xs-12">
                        @php
                            if ($sort_direction == 'ASC') {
                                $sort_direction = 'DESC';
                            } else {
                                $sort_direction = 'ASC';
                            }

                            $select_journey_id = $select_journey ? $select_journey->id : 0;
                            $edit_journey_item_id = $edit_journey_item ? $edit_journey_item->id : 0;
                        @endphp

                        {{-- Add / Edit item form (kept inside table-responsive so its row scrolls too) --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="min-width: 700px;">
                                <tbody>
                                    <form method="POST" action="{{ url('journey') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="select_journey_id" value="{{ $select_journey ? $select_journey->id : 0 }}" />
                                        <input type="hidden" name="edit_journey_item_id" value="{{ $edit_journey_item ? $edit_journey_item->id : 0  }}" />
                                        <input type="hidden" name="page" value="{{ $journey_items->currentPage() }}" />
                                        <tr>
                                            <td style="min-width: 130px;">
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
                                            <td style="white-space: nowrap;">
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="fas fa-save"></span>
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
                                                <textarea class="form-control" name="note" rows="3">{{ $edit_journey_item ? $edit_journey_item->note : '' }}</textarea>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </form>

                                    <tr>
                                        <td width="150px"><b>Date</b></td>
                                        <td><b>Position</b></td>
                                        <td><b>Result</b></td>
                                        <td><b>Image</b></td>
                                        <td><b>Note</b></td>
                                        <td width="200px"></td>
                                    </tr>
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
                                            <td>{!! $item->note !!}</td>
                                            <td style="white-space: nowrap;">
                                                @if (!$is_edit)
                                                    <a href="{{ url('journey/' . $select_journey->id . "/" . $item->id . '?page=' . $journey_items->currentPage()) }}" class="btn btn-success">
                                                        <span class="fas fa-edit"></span>
                                                    </a>
                                                    <a href="{{ url("journey/delete/" . $select_journey->id . "/" . $item->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                        <span class="fas fa-trash"></span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center text-sm-right" style="overflow-x: auto;">
                            {{ $journey_items->appends([
                                'select_journey_id' => $select_journey ? $select_journey->id : 0
                            ])->links() }}
                        </div>
                        <br />
                        @if (isset($page) && $page < $last_page)
                            <div class="text-center text-sm-right">
                                <a href="https://wn.in.th/journey?select_journey_id={{ $select_journey->id }}&amp;page={{ $last_page }}" rel="next" class="btn btn-default">
                                    Last »
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
