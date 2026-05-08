@extends('_layouts.app')

@section('title')
    Position Sizing Caculator
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        Size ($): <input type="text" class="form-control" />
                        SL: <input type="text" class="form-control" />
                        Position Size: <br />
                        TP: <br />
                        Position Value: <br />
                        Margin:
                    </div>
                    <div class="col-md-5"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ mix('/js/app.js') }}"></script>
@endsection

