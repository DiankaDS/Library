@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">My waiting orders</div>

            <div class="panel-body">

                @if (count($orders_from_user_not_accept) != 0)

                    <table class="table" id="orders_from_user_not_accept_table">
                        <thead>
                        <tr>
                            <th scope="col">Book name
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 0)"></button>
                            </th>
                            <th scope="col">Username
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 1)"></button>
                            </th>
                            <th scope="col">Name
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 2)"></button>
                            </th>
                            <th scope="col">Surname
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 3)"></button>
                            </th>
                            <th scope="col">Date start
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 4)"></button>
                            </th>
                            <th scope="col">Date end
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 5)"></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_from_user_not_accept as $val)
                            <tr>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> No one orders... </p>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Taken books</div>

            <div class="panel-body">

                @if (count($orders_from_user_accept) != 0)

                    <table class="table" id="orders_from_user_accept_table">
                        <thead>
                        <tr>
                            <th scope="col">Book name
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 0)"></button>
                            </th>
                            <th scope="col">Username
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 1)"></button>
                            </th>
                            <th scope="col">Name
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 2)"></button>
                            </th>
                            <th scope="col">Surname
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 3)"></button>
                            </th>
                            <th scope="col">Phone</th>
                            <th scope="col">E-mail
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 5)"></button>
                            </th>
                            <th scope="col">Date start
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 6)"></button>
                            </th>
                            <th scope="col">Date end
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 7)"></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_from_user_accept as $val)
                            <tr>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>{{ $val->phone }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> No one orders... </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
