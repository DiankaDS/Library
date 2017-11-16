@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Users</div>

                <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr class="filters">
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Tools</th>
                                {{--<th scope="col">Password</th>--}}
                                {{--<th scope="col">photo</th>--}}
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach ($users as $val)
                            <tr>
                                <td>{{ $val->username }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->phone }}</td>
{{--                                <td>{{ $val->password }}</td>--}}
                                {{--<td>{{ $val->photo }}</td>--}}
                                <td>
                                    {{--<form action="delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">--}}
                                    {{--{{csrf_field()}}--}}
                                    {{--<input name="_method" type="hidden" value="DELETE">--}}
                                    {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                    {{--<button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_author_message }}')">Delete</button>--}}
                                    {{--</form>--}}

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
