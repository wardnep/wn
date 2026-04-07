@extends('_layouts.journey')

@section('title')
    Trading Journey
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
                        {{-- @if ($select_journey->id == 3 || $select_journey->id == 4)
                            @include('journey.summary.snr9')
                        @endif
                        @if ($select_journey->id == 7)
                            @include('journey.summary.snr7')
                        @endif
                        @if ($select_journey->id == 9 || $select_journey->id == 10)
                            @include('journey.summary.snr9')
                        @endif --}}
                        {{-- @if ($select_journey->id == 10) --}}
                            @include('journey.summary.snr10')
                        {{-- @endif --}}
                    </div>
                    {{-- <form method="POST" action="{{ url('journey/note') }}">
                        @csrf
                        <input type="hidden" name="journey_id" value="{{ $select_journey->id }}" /> --}}
                        <div class="col-md-3">
                            <textarea class="form-control" name="note" rows="8">{{ $select_journey->note }}</textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">
                                <span class="fas fa-save" />
                            </button>
                        </div>
                    {{-- </form> --}}
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
                                    <th>Date</th>
                                    <th>Entry</th>
                                    <th>Exit</th>
                                    <th>Position</th>
                                    <th>Result</th>
                                    <th width="100px">Size</th>
                                    <th>R</th>
                                    <th>Strategy</th>
                                    <th>Grade</th>
                                    <th>Before</th>
                                    <th>After</th>
                                    <th></th>
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
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{{ $item->date }}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{!! $item->d_entry_session !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{!! $item->d_exit_session !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{!! $item->dposition !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{!! $item->dresult !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}" align="right">{!! $item->size !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}" align="center">{!! $item->dr !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{{ $item->strategy }}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}"><b>{!! $item->dgrade !!}</b></td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">
                                            @if ($item->image)
                                                <a href="{{ url('journey/image/'.$select_journey->id.'/'.$item->id) }}" target="_blank">
                                                    <img src="{{ $item->dimage }}" width="50px" title="{{ $item->note }}" />
                                                </a>
                                            @endif
                                        </td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">
                                            @if ($item->image2)
                                                <a href="{{ url('journey/image/'.$select_journey->id.'/'.$item->id) }}" target="_blank">
                                                    <img src="{{ $item->dimage2 }}" width="50px" title="{{ $item->note }}" />
                                                </a>
                                            @endif
                                        </td>
                                        <td width="10%">
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
                                    <td colspan="10" align="right">
                                        <div align="right">
                                            {{ $journey_items->appends([
                                                'select_journey_id' => $select_journey ? $select_journey->id : 0
                                            ])->links() }}
                                        </div>
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
                                        <td>
                                            <select class="form-control" name="entry_session">
                                                <option {{ $edit_journey_item && $edit_journey_item->entry_session == 'London' ? 'selected' : '' }}>London</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->entry_session == 'London + NY' ? 'selected' : '' }}>London + NY</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->entry_session == 'NY' ? 'selected' : '' }}>NY</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="exit_session">
                                                <option {{ $edit_journey_item && $edit_journey_item->exit_session == 'Asia' ? 'selected' : '' }}>Asia</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->exit_session == 'London' ? 'selected' : '' }}>London</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->exit_session == 'London + NY' ? 'selected' : '' }}>London + NY</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->exit_session == 'NY' ? 'selected' : '' }}>NY</option>
                                            </select>
                                        </td>
                                        <td width="100px">
                                            <select class="form-control" name="position">
                                                <option {{ $edit_journey_item && $edit_journey_item->position == 'BUY' ? 'selected' : '' }}>BUY</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->position == 'SELL' ? 'selected' : '' }}>SELL</option>
                                            </select>
                                        </td>
                                        <td width="100px">
                                            <select class="form-control" name="result">
                                                <option {{ $edit_journey_item && $edit_journey_item->result == 'WIN' ? 'selected' : '' }}>WIN</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->result == 'CLOSE' ? 'selected' : '' }}>CLOSE</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->result == 'LOSS' ? 'selected' : '' }}>LOSS</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" name="size" value="{{ $edit_journey_item ? $edit_journey_item->size : $default_size }}" />
                                        </td>
                                        <td>
                                            <select class="form-control" name="result_r1">
                                                <option value="2" {{ $edit_journey_item && $edit_journey_item->result_r1 == '2' ? 'selected' : "" }}>2</option>
                                                <option value="-1" {{ $edit_journey_item && $edit_journey_item->result_r1 == '-1' ? 'selected' : "" }}>-1</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="strategy">
                                                <option value="Reversal" {{ $edit_journey_item && $edit_journey_item->grade == "Reversal" ? "selected" : "" }}>Reversal</option>
                                                <option value="Breakout" {{ $edit_journey_item && $edit_journey_item->grade == "Breakout" ? "selected" : "" }}>Breakout</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control" name="grade">
                                                <option value="A+" {{ $edit_journey_item && $edit_journey_item->grade == "A+" ? "selected" : "" }}>A+</option>
                                                <option value="A" {{ $edit_journey_item && $edit_journey_item->grade == "A" ? "selected" : "" }}>A</option>
                                                <option value="B" {{ $edit_journey_item && $edit_journey_item->grade == "B" ? "selected" : "" }}>B</option>
                                                <option value="C" {{ $edit_journey_item && $edit_journey_item->grade == "C" ? "selected" : "" }}>C</option>
                                                <option value="D" {{ $edit_journey_item && $edit_journey_item->grade == "D" ? "selected" : "" }}>D</option>
                                                <option value="F" {{ $edit_journey_item && $edit_journey_item->grade == "F" ? "selected" : "" }}>F</option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" type="file" name="image" />
                                            <input class="form-control" type="file" name="image2" />
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
                                        <td></td>
                                        <td colspan="9">
                                            <input type="text" name="note" class="form-control" value="{{ $edit_journey_item ? $edit_journey_item->note : "" }}" />
                                        </td>
                                        <td></td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @if ($select_journey->id == 3 || $select_journey->id == 4)
                    @include('journey.summary.chart2')
                @endif --}}
            </div>
        </div>
    </section>
@endsection
