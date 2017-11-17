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

                <div class="panel-body">
                    {{--@if (session('status'))--}}


                    @if ( $user_info->photo !== '1' )
                        <img src="../images/users/{{$user_info->photo}}">
                    @else
                        <img src="../images/default_user.jpg">
                    @endif

                    <form class="form-inline" action="/upload_photo" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        <input id="photo" type="file" name="photo" required>

                        <button class="btn btn-info" type="submit">Upload photo</button>
                    </form>

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
                            <tr>
                                <th>E-mail</th>
                                <td>{{ $user_info['email'] }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user_info['phone'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    {{--@endif--}}

                    <form class="form-inline" action="/update_user" method="get">
                        {{csrf_field()}}

                        <button class="btn btn-info" type="submit">Update profile</button>
                        <button class="btn btn-warning" type="submit" formaction="/set_password">Set new password</button>
                    </form>

                    <div class="text-right">
                        <form class="form-inline" action="/delete_user" method="get" id="delete_user">
                            {{csrf_field()}}

                            <button class="btn btn-danger" type="button" id="delete_profile_button" onclick="myModal('delete_user', '{{ $confirm_delete_profile_message }}')">Delete profile</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading">Books</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Book name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Year</th>
                            <th scope="col">Description</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($user_books as $val)
                            <tr>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->author }}</td>
                                <td>{{ $val->year }}</td>
                                <td>{{ $val->description }}</td>
                                <td>{{ $val->genre }}</td>
                                <td>
                                    <form action="delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="id" type="hidden" value="{{ $val->id }}">

                                        <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_book_message }}')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        {{--</div>--}}
    </div>
</div>
@endsection
