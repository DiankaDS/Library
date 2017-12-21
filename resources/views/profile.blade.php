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
                    @if ($user_info->photo)
                        <img src="../images/users/{{$user_info->photo}}" height="300" width="300">
                    @else
                        <img src="../images/default_user.jpg" height="300" width="300">
                    @endif

                    @if ($user_info['id'] == Auth::user()->id)
                        <form class="form-inline" action="/upload_photo" enctype="multipart/form-data" method="POST">
                            {{csrf_field()}}
                            <input id="photo" type="file" name="photo" required>

                            <button class="btn btn-info" type="submit">Upload photo</button>
                        </form>
                    @endif

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

                    @if ($user_info['id'] == Auth::user()->id)
                        <form class="form-inline" action="/update_user" method="get">
                            {{csrf_field()}}

                            <button class="btn btn-info" type="submit">Update profile</button>
                            <button class="btn btn-warning" type="submit" formaction="/set_password">Set new password</button>
                        </form>

                        <div class="text-right">
                            <form class="form-inline" action="delete_user" method="post" id="delete_user">
                                {{csrf_field()}}

                                <button class="btn btn-danger" type="button" id="delete_profile_button" onclick="myModal('delete_user', '{{ $confirm_delete_profile_message }}')">Delete profile</button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">Books <span class="label label-primary">{{ $user_books_count }}</span></div>
            <div class="panel-body">

                @if (count($user_books) !== 0)
                    <table class="table" id="user_books_table">
                        <thead>
                        <tr>
                            <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 0)"></button></th>
                            <th scope="col">Author <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 1)"></button></th>
                            <th scope="col">Year <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 2)"></button></th>
                            {{--<th scope="col">Description</th>--}}
                            <th scope="col">Genre <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 4)"></button></th>
                            <th scope="col">Formats <button class="glyphicon glyphicon-sort" onclick="sortTable('user_books_table', 5)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($user_books as $val)
                            <tr>
                                <td><a href="/book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></td>
                                <td>{{ $val->author }}</td>
                                <td>{{ $val->year }}</td>
{{--                                <td>{{ $val->description }}</td>--}}
                                <td>{{ $val->genre }}</td>
                                <td>
                                    @foreach (explode(",", $val->formats) as $val_1)
                                        <span class="label label-primary">{{ $val_1 }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($user_info['id'] == Auth::user()->id)
                                        <form action="/delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                            {{csrf_field()}}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="id" type="hidden" value="{{ $val->id }}">

                                            <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_book_message }}')">Delete</button>
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

@endsection
