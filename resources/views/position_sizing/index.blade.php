@extends('_layouts.app')

@section('title')
    Position Sizing
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                        <div id="position-sizing"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/app.js?v='.time()) }}"></script>
@endsection
