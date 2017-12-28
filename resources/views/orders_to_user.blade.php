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
            {{--<div class="panel-heading">Waiting orders</div>--}}
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseOne">Waiting orders</a>
                    <span class="label label-primary">{{ count($orders_to_user_not_accept) }}</span>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">

            <div class="panel-body">

                @if (count($orders_to_user_not_accept) != 0)
                    <table class="table" id="orders_to_user_not_accept_table">
                        <thead>
                        <tr>
                            <th scope="col">Book name
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_not_accept_table', 0)"></button>
                            </th>
                            <th scope="col">Username
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_not_accept_table', 1)"></button>
                            </th>
                            {{--<th scope="col">Name--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_not_accept_table', 2)"></button>--}}
                            {{--</th>--}}
                            {{--<th scope="col">Surname--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_not_accept_table', 3)"></button>--}}
                            {{--</th>--}}
                            <th scope="col">Phone</th>
                            <th scope="col">E-mail
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_not_accept_table', 2)"></button>
                            </th>
                            <th scope="col">Date start
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_not_accept_table', 3)"></button>
                            </th>
                            <th scope="col">Date end
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_not_accept_table', 4)"></button>
                            </th>
                            <th scope="col">Decision</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_to_user_not_accept as $val)
                            <tr>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></td>
                                {{--<td>{{ $val->name }}</td>--}}
                                {{--<td>{{ $val->surname }}</td>--}}
                                <td>{{ $val->phone }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                                <td>
                                    <form class="form-inline" action="accept_order" method="post">
                                        {{csrf_field()}}
                                        <input name="order_id" type="hidden" value="{{ $val->order_id }}">
                                        {{--<button class="btn btn-success" type="submit">Accept</button>--}}
                                        {{--<button class="btn btn-danger" type="submit" formaction="delete_order">Reject</button>--}}
                                        <button class="btn btn-success" type="submit" data-toggle="tooltip" data-placement="top" title="Accept"><span class="glyphicon glyphicon-ok"></span></button>
                                        <button class="btn btn-danger" type="submit" formaction="delete_order" data-toggle="tooltip" data-placement="top" title="Reject"><span class="glyphicon glyphicon-remove"></span></button>
                                    </form>
                                </td>
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

        <div class="panel panel-default">
            {{--<div class="panel-heading">Given books</div>--}}
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseTwo">Given books</a>
                    <span class="label label-primary">{{ count($orders_to_user_accept) }}</span>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">

            <div class="panel-body">

                @if (count($orders_to_user_accept) != 0)
                    <table class="table" id="orders_to_user_accept_table">
                        <thead>
                        <tr>
                            <th scope="col">Book name
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_accept_table', 0)"></button>
                            </th>
                            <th scope="col">Username
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_accept_table', 1)"></button>
                            </th>
                            {{--<th scope="col">Name--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_accept_table', 2)"></button>--}}
                            {{--</th>--}}
                            {{--<th scope="col">Surname--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_accept_table', 3)"></button>--}}
                            {{--</th>--}}
                            <th scope="col">Phone</th>
                            <th scope="col">E-mail
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_accept_table', 2)"></button>
                            </th>
                            <th scope="col">Date start
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_accept_table', 3)"></button>
                            </th>
                            <th scope="col">Date end
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_to_user_accept_table', 4)"></button>
                            </th>
                            <th scope="col">Create return</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_to_user_accept as $val)
                            <tr>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></td>
                                {{--<td>{{ $val->name }}</td>--}}
                                {{--<td>{{ $val->surname }}</td>--}}
                                <td>{{ $val->phone }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                                <td>
                                    <form class="form-inline" action="book_return" method="post" id="return_form">
                                        {{csrf_field()}}
                                        <input name="order_id" type="hidden" value="{{ $val->order_id }}">

                                        {{--<button class="btn btn-primary" type="button" onclick="myModal('return_form', '{{ $confirm_return_form_message }}')">Return</button>--}}
                                        <button class="btn btn-primary" type="button" onclick="myModal('return_form', '{{ $confirm_return_form_message }}')" data-toggle="tooltip" data-placement="top" title="Returned"><span class="glyphicon glyphicon-ok"></span></button>
                                    </form>
                                </td>
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
</div>

@endsection
