@extends('layouts.app')

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
                <div class="panel-heading">Profile</div>
                <div class="panel-body" align="center">
                    <div class="col-md-3">
                        @if ($user_info->photo)
                            <img src="../images/users/{{$user_info->photo}}" height="150" width="150">
                        @else
                            <img src="../images/default_user.jpg" height="150" width="150">
                        @endif

                        @if ($user_info['id'] == Auth::user()->id)
                            <form class="form-horizontal" action="/upload_photo" enctype="multipart/form-data" method="POST" id="upload_photo">
                                {{csrf_field()}}

                                <button class="btn btn-info" type="button" onclick="uploadPhoto('upload_photo', 'photo')" data-toggle="tooltip" data-placement="top" title="Upload photo"><span class="glyphicon glyphicon-camera"></span></button>
                                <input id="photo" type="file" name="photo" style="display: none">
                            </form>
                        @endif
                    </div>

                    <div class="col-md-offset-3">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user_info['username'] }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user_info['name'] }}</td>
                            </tr>
                            <tr>
                                <th>Surname</th>
                                <td>{{ $user_info['surname'] }}</td>
                            </tr>

                            @if ($user_info['id'] == Auth::user()->id)
                                <tr>
                                    <th>E-mail</th>
                                    <td>{{ $user_info['email'] }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $user_info['phone'] }}</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>

                    @if ($user_info['id'] == Auth::user()->id)
                        {{--<div class="form-group">--}}

                        <form class="form-inline pull-right" action="delete_user" method="post" id="delete_user" style="margin-left: 4px">
                            {{csrf_field()}}

                            {{--<button class="btn btn-danger" type="button" id="delete_profile_button" onclick="myModal('delete_user', '{{ $confirm_delete_profile_message }}')">Delete profile</button>--}}
                            <button class="btn btn-danger" type="button" id="delete_profile_button" onclick="myModal('delete_user', '{{ $confirm_delete_profile_message }}')" data-toggle="tooltip" data-placement="top" title="Delete profile"><span class="glyphicon glyphicon-trash"></span></button>
                        </form>

                        <form class="form-inline pull-right" action="/update_user" method="get">
                            {{csrf_field()}}

                            {{--<button class="btn btn-info" type="submit">Update profile</button>--}}
                            <button class="btn btn-info" type="submit" id="delete_profile_button" data-toggle="tooltip" data-placement="top" title="Update profile"><span class="glyphicon glyphicon-edit"></span></button>

                            {{--<button class="btn btn-warning" type="submit" formaction="/set_password">Set new password</button>--}}
                            <button class="btn btn-warning" type="submit" formaction="/set_password" data-toggle="tooltip" data-placement="top" title="Set new password"><span class="glyphicon glyphicon-log-in"></span></button>
                        </form>

                        {{--<div class="text-right">--}}
                            {{--<form class="form-inline pull-right" action="delete_user" method="post" id="delete_user">--}}
                                {{--{{csrf_field()}}--}}

                                {{--<button class="btn btn-danger" type="button" id="delete_profile_button" onclick="myModal('delete_user', '{{ $confirm_delete_profile_message }}')">Delete profile</button>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    {{--<a data-toggle="collapse" href="#collapseOne">Users who have a book</a>--}}
                    <a data-toggle="collapse" href="#collapseOne">Recommended</a>
                    <span class="label label-primary">{{ $user_recom_count }}</span>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">

                @if (count($user_recom) != 0)
                    <table class="table" id="user_books_table">
                        <thead>
                        <tr>
                            <th scope="col">Photo </th>
                            <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 1)"></button></th>
                            <th scope="col">Author <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 2)"></button></th>
                            <th scope="col">Year <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 3)"></button></th>
                            <th scope="col">Genre <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 4)"></button></th>
                            <th scope="col">Formats <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 5)"></button></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($user_recom as $val)
                            <tr>
                                <td>
                                    <a href="/book_{{ $val->id }}" name="{{ $val->id }}">
                                        @if ($val->photo)
                                            <img src="{{$val->photo}}" height="42" width="42">
                                        @else
                                            <img src="../images/default_book.jpg" height="42" width="42">
                                        @endif
                                    </a>
                                </td>
                                <td><a href="/book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></td>
                                <td>{{ $val->author }}</td>
                                <td>{{ $val->year }}</td>
                                <td>{{ $val->genre }}</td>
                                <td>
                                    @foreach (explode(",", $val->formats) as $val_1)
                                        <span class="label label-primary">{{ $val_1 }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="row" align="center">
                        {{ $user_recom->links() }}
                    </div>

                @else
                    <p> Nothing books... </p>
                @endif
            </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseTwo">Paper books</a>
                    <span class="label label-primary">{{ $user_books_count }}</span>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in">
                <div class="panel-body">

                @if (count($user_books) != 0)
                    <table class="table" id="user_books_table">
                        <thead>
                        <tr>
                            <th scope="col">Photo </th>
                            <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 1)"></button></th>
                            <th scope="col">Author <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 2)"></button></th>
                            <th scope="col">Year <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 3)"></button></th>
                            {{--<th scope="col">Description</th>--}}
                            <th scope="col">Genre <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 4)"></button></th>
                            {{--<th scope="col">Formats <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 5)"></button></th>--}}
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($user_books as $val)
                            <tr>
                                <td>
                                    <a href="/book_{{ $val->id }}" name="{{ $val->id }}">
                                        @if ($val->photo)
                                            <img src="{{$val->photo}}" height="42" width="42">
                                        @else
                                            <img src="../images/default_book.jpg" height="42" width="42">
                                        @endif
                                    </a>
                                </td>
                                <td><a href="/book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></td>
                                <td>{{ $val->author }}</td>
                                <td>{{ $val->year }}</td>
{{--                                <td>{{ $val->description }}</td>--}}
                                <td>{{ $val->genre }}</td>
                                {{--<td>--}}
                                    {{--@foreach (explode(",", $val->formats) as $val_1)--}}
                                        {{--<span class="label label-primary">{{ $val_1 }}</span>--}}
                                    {{--@endforeach--}}
                                {{--</td>--}}
                                <td>
                                    @if ($user_info['id'] == Auth::user()->id)
                                        <form action="/delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                            {{csrf_field()}}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="id" type="hidden" value="{{ $val->id }}">

                                            <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_book_message }}')" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
                                        </form>
                                    @else
                                        <form action="/orders" id="{{ $val->id }}" method="post" name="id" class="form-inline">
                                            {{csrf_field()}}
                                            <input name="book_id" type="hidden" value="{{ $val->id }}">
                                            <input name="giving_id" type="hidden" value="{{ $user_info['id'] }}">

                                            <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                                                <label for="date_start">Date start:</label>

                                                <input class="form-control" id="datepicker" name="date_start" placeholder="YYYY-MM-DD" type="text">
                                                @if ($errors->has('date_start'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('date_start') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                                                <label for="date_end">Date end:</label>

                                                <input class="form-control" id="datepicker" name="date_end" placeholder="YYYY-MM-DD" type="text">
                                                @if ($errors->has('date_end'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('date_end') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <button class="btn btn-success" type="submit">Take</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="row" align="center">
                        {{ $user_books->links() }}
                    </div>

                @else
                    <p> Nothing books... </p>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
