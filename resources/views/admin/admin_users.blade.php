@extends('layouts.admin')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Users</div>

            <div class="panel-body">
                @if (count($users) !== 0)
                <table class="table" id="users_table">
                    <thead>
                    <tr class="filters">
                        <th scope="col">Photo</th>
                        <th scope="col">Username <button class="glyphicon glyphicon-sort" onclick="sortTable('users_table', 1)"></button></th>
                        <th scope="col">Name <button class="glyphicon glyphicon-sort" onclick="sortTable('users_table', 2)"></button></th>
                        <th scope="col">Surname <button class="glyphicon glyphicon-sort" onclick="sortTable('users_table', 3)"></button></th>
                        <th scope="col">E-mail <button class="glyphicon glyphicon-sort" onclick="sortTable('users_table', 4)"></button></th>
                        <th scope="col">Phone</th>
                        <th scope="col">Tools</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @foreach ($users as $val)
                        <tr>
                            <td>
                                <img src="../images/users/{{$val->photo}}" height="42" width="42">
                            </td>
                            <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->surname }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->phone }}</td>
                            <td>
                                <form class="form-inline" action="delete_user" method="post" id="{{ $val->id }}" name="delete_user" style ='display:inline;'>
                                    <input name="admins_user_id" type="hidden" value="{{ $val->id }}">
                                    {{csrf_field()}}

                                    <button class="btn btn-danger" type="button" id="delete_profile_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_profile_message }}')">Delete user</button>
                                </form>

                                @if ($val->admin == 0)
                                    <form class="form-inline" action="add_to_admin" method="post" id="add_to_admin_{{ $val->id }}" name="add_to_admin" style ='display:inline;'>
                                        <input name="admins_user_id" type="hidden" value="{{ $val->id }}">
                                        {{csrf_field()}}

                                        <button class="btn btn-info" type="button" onclick="myModal('add_to_admin_{{ $val->id }}', '{{ $confirm_add_to_admin_message }}')">Add to admin</button>
                                    </form>
                                @else
                                    <form class="form-inline" action="delete_from_admin" method="post" id="delete_from_admin_{{ $val->id }}" name="delete_from_admin" style ='display:inline;'>
                                        <input name="admins_user_id" type="hidden" value="{{ $val->id }}">
                                        {{csrf_field()}}

                                        <button class="btn btn-warning" type="button" onclick="myModal('delete_from_admin_{{ $val->id }}', '{{ $confirm_delete_from_admin_message }}')">Delete from admin</button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <p> Nothing users... </p>
                @endif

                <div class="row" align="center">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
