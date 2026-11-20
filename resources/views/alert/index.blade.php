@extends('_layouts.app')

@section('title')
    WN Alert
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
                <p>เมื่อเปิดใช้งาน ระบบจะแจ้งเตือนเวลา :04:30, :09:30, :14:30, ... ซึ่งเป็น 30 วินาทีก่อนแท่ง 5m ปิด</p>
                <form id="time-alert-toggle-form" method="POST" action="{{ url('alert/time/toggle') }}">
                    @csrf
                    <input type="hidden" name="enabled" id="time-alert-enabled" value="{{ $time_alert_enabled ? 1 : 0 }}">
                    <label class="time-alert-toggle">
                        <input type="checkbox" id="time-alert-switch" role="switch" {{ $time_alert_enabled ? 'checked' : '' }} aria-label="เปิดหรือปิด Time Alert">
                        <span class="time-alert-slider"></span>
                    </label>
                    <strong id="time-alert-status">{{ $time_alert_enabled ? 'เปิดอยู่' : 'ปิดอยู่' }}</strong>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        .time-alert-toggle { display: inline-block; height: 28px; margin: 0 8px 0 0; position: relative; vertical-align: middle; width: 50px; }
        .time-alert-toggle input { height: 0; opacity: 0; width: 0; }
        .time-alert-slider { background: #aaa; border-radius: 28px; bottom: 0; cursor: pointer; left: 0; position: absolute; right: 0; top: 0; transition: .2s; }
        .time-alert-slider:before { background: #fff; border-radius: 50%; bottom: 4px; content: ''; height: 20px; left: 4px; position: absolute; transition: .2s; width: 20px; }
        .time-alert-toggle input:checked + .time-alert-slider { background: #28a745; }
        .time-alert-toggle input:checked + .time-alert-slider:before { transform: translateX(22px); }
    </style>
@endsection

@section('js')
    <script>
        document.getElementById('time-alert-switch').addEventListener('change', function () {
            document.getElementById('time-alert-enabled').value = this.checked ? '1' : '0';
            document.getElementById('time-alert-status').textContent = this.checked ? 'กำลังเปิด...' : 'กำลังปิด...';
            document.getElementById('time-alert-toggle-form').submit();
        });
    </script>
@endsection
