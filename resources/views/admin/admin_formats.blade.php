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
            <div class="panel-heading">Formats</div>

            <div class="panel-body">

                <form class="form-horizontal" method="POST" action="admin_create_format">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                        <div class="col-md-6">
                            <input id="name" type="text" autocomplete="off" placeholder="New format name" class="form-control" name="name" value="{{ old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button class="btn btn-info" type="submit">Add format</button>
                        </div>
                    </div>
                </form>

                @if (count($formats) !== 0)
                    <table class="table" id="formats_table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Format <button class="glyphicon glyphicon-sort" onclick="sortTable('formats_table', 0)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($formats as $val)
                            <tr>
                                <td>{{ $val->name }}</td>
                                <td>
                                    <form action="admin_del_format/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="admins_format_id" type="hidden" value="{{ $val->id }}">

                                        {{--<button class="btn btn-danger" type="button" id="delete_format_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_format_message }}')">Delete</button>--}}
                                        <button class="btn btn-danger" type="button" id="delete_format_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_format_message }}')" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> Nothing formats... </p>
                @endif

                <div class="row" align="center">
                    {{ $formats->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@endsection
