@extends('_layouts.app')

@section('title')
    Calendar
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
                events: '/calendar/{{ $journey_id }}/events'
            });
            calendar.render();
        });
    </script>
@endsection
