@extends('_layouts.app')

@section('title')
    Wn Quant
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        Status <a href="{{ url('quant') }}">
                            @if (isset($data) && $data['running'])
                                <button type="button" class="btn btn-success">{{ $data['last_heartbeat'] }}</button>
                            @else
                                <button type="button" class="btn btn-danger"></button>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Note</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->note }}</td>
                                        <td width="200px">{{ $log->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
