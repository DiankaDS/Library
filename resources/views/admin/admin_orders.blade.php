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
            <div class="panel-heading">Orders</div>

            <div class="panel-body">
                @if (count($orders) !== 0)
                    <table class="table" id="orders_table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Order id <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 0)"></button></th>
                            <th scope="col">Giving <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 1)"></button></th>
                            <th scope="col">Taker <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 2)"></button></th>
                            <th scope="col">Date start <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 3)"></button></th>
                            <th scope="col">Date end <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 4)"></button></th>
                            <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 5)"></button></th>
                            <th scope="col">Accept <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 6)"></button></th>
                            <th scope="col">Return <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_table', 7)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($orders as $val)
                            <tr>
                                <td>{{ $val->order_id }}</td>
                                <td><a href="profile/{{ $val->giving_id }}" name="{{ $val->giving_id }}">{{ $val->giving }}</a></td>
                                <td><a href="profile/{{ $val->taker_id }}" name="{{ $val->taker_id }}">{{ $val->taker }}</a></td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td>{{ $val->accept }}</td>
                                <td>{{ $val->return }}</td>
                                <td>
                                    <form action="delete_order" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="order_id" type="hidden" value="{{ $val->id }}">

                                        <button class="btn btn-danger" type="button" id="delete_order_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_order_message }}')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> Nothing orders... </p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
