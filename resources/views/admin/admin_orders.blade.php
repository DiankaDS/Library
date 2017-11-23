@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Orders</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Order id</th>
                            <th scope="col">Giving</th>
                            <th scope="col">Taker</th>
                            <th scope="col">Date start</th>
                            <th scope="col">Date end</th>
                            <th scope="col">Book name</th>
                            <th scope="col">Accept</th>
                            <th scope="col">Return</th>
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

                </div>
        </div>
    </div>
        {{--</div>--}}
</div>

@endsection
