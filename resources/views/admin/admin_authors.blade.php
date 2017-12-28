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
            <div class="panel-heading">Authors</div>

            <div class="panel-body">

                <form class="form-horizontal" method="POST" action="admin_create_author">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                        <div class="col-md-6">
                            <input id="name" type="text" autocomplete="off" placeholder="New author name" class="form-control" name="name" value="{{ old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button class="btn btn-info" type="submit">Add author</button>
                        </div>
                    </div>
                </form>

                @if (count($authors) !== 0)
                    <table class="table" id="authors_table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Author <button class="glyphicon glyphicon-sort" onclick="sortTable('authors_table', 0)"></button></th>
                            <th scope="col">Books <button class="glyphicon glyphicon-sort" onclick="sortTable('authors_table', 1)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($authors as $val)
                            <tr>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->books_count }}</td>
                                <td>
                                    <form action="admin_del_author/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="admins_author_id" type="hidden" value="{{ $val->id }}">

                                        {{--<button class="btn btn-danger" type="button" id="delete_author_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_author_message }}')">Delete</button>--}}
                                        <button class="btn btn-danger" type="button" id="delete_author_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_author_message }}')" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> Nothing authors... </p>
                @endif

                <div class="row" align="center">
                    {{ $authors->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@endsection
