@extends('_layouts.app')

@section('title')
    Price Alert - {{ $price_levels->count() }}
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Price</th>
                                    <th>TimeFrame</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                    <th>Active</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($price_levels as $price_level)
                                    <tr>
                                        <td>{{ $price_level->price }}</td>
                                        <td>{{ $price_level->time_frame }}</td>
                                        <td>{{ $price_level->message }}</td>
                                        <td>{{ $price_level->created_at->format('j M Y - H:i:s') }}</td>
                                        <td>{{ $price_level->active }}</td>
                                        <td>
                                            @if (!$edit_price_level || $edit_price_level->id != $price_level->id)
                                                <a href="{{ url('alert/'.$price_level->id) }}" class="btn btn-success">
                                                    <span class="fas fa-edit" />
                                                </a>
                                                <a href="{{ url("alert/delete/" . $price_level->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <span class="fas fa-trash" />
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="price-alert-form" method="POST" action="{{ url('alert') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $edit_price_level ? $edit_price_level->id : '' }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="price">Price</label>
                                    <input id="price" type="number" step="any" name="price" value="{{ old('price', $edit_price_level ? $edit_price_level->price : '') }}" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="time_frame">TimeFrame</label>
                                    <select id="time_frame" name="time_frame" class="form-control" required>
                                        @foreach (['15m', '1h', '4h', 'D'] as $frame)
                                            <option value="{{ $frame }}" {{ old('time_frame', $edit_price_level ? $edit_price_level->time_frame : '15m') == $frame ? 'selected' : '' }}>{{ $frame }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="price_message">Message</label>
                                    <input id="price_message" type="text" name="price_message" value="{{ old('price_message', $edit_price_level ? $edit_price_level->message : '') }}" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label>Active</label><br>
                                    <label><input type="radio" name="active" value="1" {{ !$edit_price_level || old('active', $edit_price_level->active ? '1' : '0') == '1' ? 'checked' : '' }}> Active</label>
                                    <label><input type="radio" name="active" value="0" {{ $edit_price_level && old('active', $edit_price_level->active ? '1' : '0') == '0' ? 'checked' : '' }}> Inactive</label>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary"><span class="fas fa-save"></span></button>
                                    @if ($edit_price_level)
                                        <a href="{{ url('alert') }}" class="btn btn-danger"><i class="fa fa-window-close" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                            </div>
                            @if ($errors->has('price') || $errors->has('time_frame') || $errors->has('price_message'))
                                <div class="text-danger">{{ $errors->first('price') ?: ($errors->first('time_frame') ?: $errors->first('price_message')) }}</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header"><h3 class="box-title">Time Alerts (เวลาประเทศไทย)</h3></div>
            <div class="box-body">
                <p>เตือนก่อนแท่ง 5m เปิดทุกนาที :04, :09, :14, ... ภายในช่วงเวลาที่กำหนด (เวลาไทย)</p>
                <form id="time-alert-form" method="POST" action="{{ url('alert/time') }}" class="form-inline">
                    @csrf
                    <div class="form-group">
                        <label for="start_time">ตั้งแต่</label>
                        <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}" class="form-control" required>
                    </div>
                    <div class="form-group" style="margin-left: 8px">
                        <label for="end_time">ถึง</label>
                        <input id="end_time" type="time" name="end_time" value="{{ old('end_time') }}" class="form-control" required>
                    </div>
                    <div class="form-group" style="margin-left: 8px">
                        <label for="time_message">ข้อความ</label>
                        <input id="time_message" type="text" name="time_message" value="{{ old('time_message') }}" class="form-control" placeholder="ตรวจสอบ key level">
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-left: 8px">เพิ่มเวลา</button>
                </form>
                @if ($errors->has('start_time') || $errors->has('end_time') || $errors->has('time_message'))
                    <div class="text-danger">{{ $errors->first('start_time') ?: ($errors->first('end_time') ?: $errors->first('time_message')) }}</div>
                @endif
                <table class="table table-bordered table-striped" style="margin-top: 15px">
                    <thead><tr><th>ช่วงเวลา</th><th>ข้อความ</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($time_alerts as $time_alert)
                            <tr>
                                <td>{{ $time_alert->alert_time }}–{{ $time_alert->end_time }}</td>
                                <td>{{ $time_alert->message }}</td>
                                <td><a href="{{ url('alert/time/delete/' . $time_alert->id) }}" class="btn btn-danger" onclick="return confirm('Delete this time alert?')"><span class="fas fa-trash"></span></a></td>
                            </tr>
                        @empty
                            <tr><td colspan="3">ยังไม่มี time alert</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
