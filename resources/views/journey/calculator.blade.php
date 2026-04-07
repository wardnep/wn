@extends('_layouts.journey')

@section('title')
    Trading Journey
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <div id="calculator"></div>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </div>
        </div>
    <section>
    <script src="{{ asset('js/app.js?v='.time()) }}"></script>
@endsection
