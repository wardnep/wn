@extends('_layouts.app')

@section('title')
    Position Sizing
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div id="position-sizing"></div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/app.js?v='.time()) }}"></script>
@endsection
