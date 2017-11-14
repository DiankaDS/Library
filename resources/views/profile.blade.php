@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    {{--@if (session('status'))--}}
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
                    <button class="btn btn-light"><a href="/update_user">Update profile</a></button>
                    <button class="btn btn-light"><a href="/set_password">Set new password</a></button>
                    <button class="btn btn-info"><a href="/delete_user">Delete profile</a></button>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">My orders</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Book name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Date start</th>
                            <th scope="col">Date end</th>
                            <th scope="col">Owner</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($user_orders as $val)
                            <tr>
                                <td>{{ $val->book }}</td>
                                <td>{{ $val->author }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                                <td>{{ $val->owner }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

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

                                        <button class="btn btn-info" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
