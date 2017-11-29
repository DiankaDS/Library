@extends('layouts.admin')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Genres</div>

            <div class="panel-body">
                @if (count($genres) !== 0)
                    <table class="table" id="genres_table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Genre <button class="glyphicon glyphicon-sort" onclick="sortTable('genres_table', 0)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($genres as $val)
                            <tr>
                                <td>{{ $val->name }}</td>
                                <td>
                                    <form action="admin_del_genre/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="admins_genre_id" type="hidden" value="{{ $val->id }}">

                                        <button class="btn btn-danger" type="button" id="delete_genre_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_genre_message }}')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> Nothing genres... </p>
                @endif

                <form class="form-horizontal" method="POST" action="admin_create_genre">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">

                        <div class="col-md-6">
                            <input id="genre" type="text" autocomplete="off" placeholder="New genre" class="form-control" name="genre" value="{{ old('genre') }}" required>

                            @if ($errors->has('genre'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('genre') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button class="btn btn-info" type="submit">Add genre</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
