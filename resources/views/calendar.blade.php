@extends('_layouts.app')

@section('title')
    Total - {{ $total}}R
@endsection

@section('css')
    <style>
        .win-trade {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .lose-trade {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }
        .win-big {
            background-color: #0d6e0d !important;
        }
        .lose-big {
            background-color: #8b0000 !important;
            border-color: #8b0000 !important;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '/calendar/{{ $journey_id }}/events',

                // ต้องอยู่ใน {} นี้
                datesSet: function(info) {
                    fetch(`/calendar/{{ $journey_id }}/month-summary?start=${info.startStr}&end=${info.endStr}`)
                        .then(res => res.json())
                        .then(data => {
                            var toolbar = document.querySelector('.fc-toolbar-title');
                            if (!toolbar) return;

                            var old = toolbar.querySelector('.month-total');
                            if (old) old.remove();

                            var badge = document.createElement('span');
                            badge.className = 'month-total';
                            badge.style.cssText = `
                                font-size: 0.6em;
                                margin-left: 12px;
                                padding: 2px 10px;
                                border-radius: 12px;
                                background: ${data.total >= 0 ? '#28a745' : '#dc3545'};
                                color: white;
                                vertical-align: middle;
                            `;
                            badge.textContent = (data.total >= 0 ? '+' : '') + data.total.toFixed(1) + 'R';
                            toolbar.appendChild(badge);
                        });
                }

            }); // ปิด Calendar options

            calendar.render();
        });
    </script>
@endsection
