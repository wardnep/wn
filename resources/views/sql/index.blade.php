@extends('_layouts.app')

@section('title')
    SQL Query
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-11">
                        <select class="form-control" name="connection">
                            <option value="sqlite">wn</option>
                            <option value="sqlite2">wn-quent</option>
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <form method="POST" action="{{ url('execution') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-11">
                            <textarea class="form-control" name="sql">{{ isset($sql) ? $sql : '' }}</textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success">
                                <span class="fas fa-save" />
                            </button>
                        </div>
                    </div>
                </form>
                @if (isset($results) && $results)
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        @foreach ($headers as $header)
                                            <th>{{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $result)
                                        <tr>
                                            @foreach (array_values((array) $result) as $td)
                                                <td>{{ $td }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
