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
                        <table class="table">
                            <thead>
                            <tr class="filters">
                                <th scope="col">Photo</th>
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Phone</th>
                                {{--<th scope="col">Admin</th>--}}
                                <th scope="col">Tools</th>
                                {{--<th scope="col">Password</th>--}}
                                {{--<th scope="col">photo</th>--}}
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach ($users as $val)
                            <tr>
                                <td>
                                    <img src="../images/users/{{$val->photo}}" height="42" width="42">
                                </td>
                                <td>{{ $val->username }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->phone }}</td>
{{--                                <td>{{ $val->password }}</td>--}}
                                {{--<td>{{ $val->photo }}</td>--}}
                                <td>
                                    {{--<button class="btn btn-info" type="button">Add to admin</button>--}}
                                    
                                    <form class="form-inline" action="delete_user" method="post" id="{{ $val->id }}" name="delete_user">
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        <input name="admins_user_id" type="hidden" value="{{ $val->id }}">
                                        {{csrf_field()}}

                                        <button class="btn btn-danger" type="button" id="delete_profile_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_profile_message }}')">Delete user</button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>

        </div>
    </div>
        {{--</div>--}}
</div>

@endsection
