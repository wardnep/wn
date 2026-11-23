@extends('_layouts.app')

@section('title', 'Backtest Analysis')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Backtest Analysis</h3>
            </div>
            <div class="box-body">
                <form method="GET" action="{{ url('journey-analysis') }}" id="analysis-filters">
                    <div class="form-group">
                        <label for="journey_id">Journey</label>
                        <select class="form-control" id="journey_id" name="journey_id" onchange="this.form.submit()" {{ $journeys->isEmpty() ? 'disabled' : '' }}>
                            @foreach ($journeys as $option)
                                <option value="{{ $option->id }}" {{ $journeyId == $option->id ? 'selected' : '' }}>
                                    ({{ $option->items_count }}) {{ $option->name }}{{ $option->trashed() ? ' (archived)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Entry sessions</strong>
                            <div class="row">
                                @forelse ($sessions as $session)
                                    <div class="col-xs-6">
                                        <label style="font-weight: normal;">
                                            <input type="checkbox" name="sessions[]" value="{{ $session }}" {{ in_array($session, $selectedSessions, true) ? 'checked' : '' }}>
                                            {{ $session }}
                                        </label>
                                    </div>
                                @empty
                                    <div class="col-xs-12 text-muted">No session data for this journey.</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <strong>Exit legs included</strong>
                            <div>
                                <label style="font-weight: normal; margin-right: 18px;">
                                    <input type="hidden" name="tp1_present" value="1">
                                    <input type="checkbox" name="tp1" value="1" {{ $includeTp1 ? 'checked' : '' }}>
                                    TP1 (ไม้แรก)
                                </label>
                                <label style="font-weight: normal;">
                                    <input type="hidden" name="tp2_present" value="1">
                                    <input type="checkbox" name="tp2" value="1" {{ $includeTp2 ? 'checked' : '' }}>
                                    TP2 (ไม้ถือยาว)
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (!$includeTp1 && !$includeTp2)
            <div class="callout callout-warning">เลือก TP1 หรือ TP2 อย่างน้อยหนึ่งรายการเพื่อคำนวณผล</div>
        @endif

        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <div class="small-box bg-aqua"><div class="inner"><h3>{{ $summary['count'] }}</h3><p>จำนวนออเดอร์</p></div></div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="small-box bg-green"><div class="inner"><h3>{{ number_format($summary['win_rate'], 1) }}%</h3><p>Win rate</p></div></div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="small-box bg-blue"><div class="inner"><h3>{{ number_format($summary['total_r'], 2) }}R</h3><p>ผลรวม R</p></div></div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="small-box bg-purple"><div class="inner"><h3>{{ number_format($summary['average_r'], 2) }}R</h3><p>เฉลี่ย R / ออเดอร์</p></div></div>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">ผลแยกตาม Entry Session</h3>
                <span class="text-muted">(คำนวณจาก {{ $includeTp1 ? 'TP1' : '' }}{{ $includeTp1 && $includeTp2 ? ' + ' : '' }}{{ $includeTp2 ? 'TP2' : '' }})</span>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Session</th>
                            <th>จำนวนออเดอร์</th>
                            <th>ชนะ</th>
                            <th>แพ้</th>
                            <th>Win rate</th>
                            <th>ผลรวม R</th>
                            <th>เฉลี่ย R / ออเดอร์</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessionSummaries as $session => $data)
                            <tr style="{{ $data['selected'] ? '' : 'opacity: .45;' }}">
                                <td>{{ $session }}</td>
                                <td>{{ $data['summary']['count'] }}</td>
                                <td>{{ $data['summary']['wins'] }}</td>
                                <td>{{ $data['summary']['losses'] }}</td>
                                <td>{{ number_format($data['summary']['win_rate'], 1) }}%</td>
                                <td>{{ number_format($data['summary']['total_r'], 2) }}R</td>
                                <td>{{ number_format($data['summary']['average_r'], 2) }}R</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">ยังไม่มีข้อมูลสำหรับ journey นี้</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <p class="text-muted">Win rate นับออเดอร์ที่ผลรวม R ของไม้ที่เลือกมากกว่า 0 เป็นชนะ และไม่นับผลรวม R เท่ากับ 0 เป็นทั้งชนะหรือแพ้</p>
            </div>
        </div>
    </section>
@stop
@section('js')
    <script>
        document.querySelectorAll('#analysis-filters input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                this.form.submit();
            });
        });
    </script>
@stop
