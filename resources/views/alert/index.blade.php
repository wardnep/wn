@extends('_layouts.app')

@section('title')
    Price Alert - {{ $price_levels->count() }}
@endsection

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Price</th>
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
                                <form method="POST" action="{{ url('alert') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $edit_price_level ? $edit_price_level->id : '' }}">
                                    <tr>
                                        <td>
                                            <input type="text" name="price" value="{{ $edit_price_level ? $edit_price_level->price : '' }}" class="form-control">
                                        </td>
                                        <td colspan="2">
                                            <input type="text" name="message" value="{{ $edit_price_level ? $edit_price_level->message : '' }}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="radio" name="active" value="1" {{ !$edit_price_level || ($edit_price_level && $edit_price_level->active) ? 'checked' : '' }}> Active<br />
                                            <input type="radio" name="active" value="0" {{ $edit_price_level && !$edit_price_level->active ? 'checked' : '' }}> Inactive
                                        </td>
                                        <td width="200px">
                                            <button type="submit" class="btn btn-primary">
                                                <span class="fas fa-save" />
                                            </button>
                                            @if ($edit_price_level)
                                                <a href="{{ url('alert') }}" class="btn btn-danger">
                                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
