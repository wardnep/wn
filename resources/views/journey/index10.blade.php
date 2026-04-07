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
                        @include('journey.summary.snr10')
                    </div>
                    <form method="POST" action="{{ url('journey/note') }}">
                        @csrf
                        <input type="hidden" name="journey_id" value="{{ $select_journey->id }}" />
                        <div class="col-md-3">
                            <textarea class="form-control" name="note" rows="8">{{ $select_journey->note }}</textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success">
                                <span class="fa fa-floppy-o" />
                            </button>
                        </div>
                    </form>
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
                        <form id="excludeSession" method="GET" action="{{ url('journey') }}">
                            @csrf
                            <b>
                                <input type="hidden" name="select_journey_id" value="{{ $select_journey_id }}" />
                                Exclude
                                <input type="checkbox" name="exclude_asia" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_asia == 'Y' ? 'checked' : '' }} /> Asia
                                <input type="checkbox" name="exclude_london" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_london == 'Y' ? 'checked' : '' }} /> London
                                <input type="checkbox" name="exclude_london_ny" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_london_ny == 'Y' ? 'checked' : '' }} /> London & NY
                                <input type="checkbox" name="exclude_ny" value="Y" onchange="document.getElementById('excludeSession').submit()" {{ $exclude_ny == 'Y' ? 'checked' : '' }} /> NY<br />
                            </b>
                        </form>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Session</th>
                                    <th>Position</th>
                                    <th>Result</th>
                                    <th width="100px">SL</th>
                                    <th width="100px">TP</th>
                                    <th>R</th>
                                    <th></th>
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
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{!! $item->dsession !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{!! $item->dposition !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">{!! $item->dresult !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}" align="right">{!! $item->dsl1 !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}" align="right">{!! $item->dtp1 !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}" align="center">{!! $item->result_r1 ? number_format($item->result_r1, 2) : '' !!}</td>
                                        <td class="{{ $is_edit ? 'edit' : '' }}">
                                            @if ($item->image)
                                                <a href="{{ $item->dimage }}" target="_blank">
                                                    <img src="{{ $item->dimage }}" width="50px" />
                                                </a>
                                            @endif
                                        </td>
                                        <td width="10%">
                                            @if (!$is_edit)
                                                <a href="{{ url('journey/' . $select_journey->id . "/" . $item->id . '?page=' . $journey_items->currentPage()) }}" class="btn btn-success">
                                                    <span class="fa fa-pencil-square-o" />
                                                </a>
                                                <a href="{{ url("journey/delete/" . $select_journey->id . "/" . $item->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <span class="fa fa-trash" />
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="9" align="right">
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
                                            <input type="text" name="date" class="form-control datepicker" data-provide="datepicker" data-date-language="th-th" placeholder="วัน/เดือน/ปี" value="{{ $edit_journey_item ? $edit_journey_item->date : $default_date }}" readonly />
                                        </td>
                                        <td>
                                            <select class="form-control" name="session">
                                                <option {{ $edit_journey_item && $edit_journey_item->session == 'Asia' ? 'selected' : '' }}>Asia</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->session == 'London' ? 'selected' : '' }}>London</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->session == 'London + NY' ? 'selected' : '' }}>London + NY</option>
                                                <option {{ $edit_journey_item && $edit_journey_item->session == 'NY' ? 'selected' : '' }}>NY</option>
                                                <option>N/A</option>
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
                                                <option {{ $edit_journey_item && $edit_journey_item->result == 'LOSS' ? 'selected' : '' }}>LOSS</option>
                                            </select>
                                        </td>
                                        <td></td>
                                        <td>
                                            <input class="form-control" name="tp1" value="{{ $edit_journey_item ? $edit_journey_item->tp1 : '' }}" />
                                        </td>
                                        <td>
                                            <input class="form-control" name="tp2" value="{{ $edit_journey_item ? $edit_journey_item->tp2 : '' }}" />
                                        </td>
                                        {{-- <td colspan="2">
                                            <input type="radio" name="strategy" value="Reversal" {{ $edit_journey_item && $edit_journey_item->strategy == "" || $edit_journey_item && $edit_journey_item->strategy == 'Reversal' ? 'checked' : '' }} />Reversal<br />
                                            <input type="radio" name="strategy" value="Breakout" {{ $edit_journey_item && $edit_journey_item->strategy == 'Breakout' ? 'checked' : '' }} />Breakout
                                        </td> --}}
                                        <td>
                                            <input class="form-control" type="file" name="image" />
                                        </td>
                                        {{-- <td>
                                            <select class="form-control" name="grade">
                                                <option value="">Grade</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </td> --}}
                                        {{-- <td>
                                            <input class="form-control" size="50" name="note" value="{{ $edit_journey_item ? $edit_journey_item->note : '' }}" />
                                        </td> --}}
                                        <td>
                                            <button type="submit" class="btn btn-primary">
                                                <span class="fa fa-floppy-o" />
                                            </button>
                                            @if ($edit_journey_item)
                                                <a href="{{ url('journey/' . $select_journey->id . '?page=' . $journey_items->currentPage()) }}" class="btn btn-danger">
                                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
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
