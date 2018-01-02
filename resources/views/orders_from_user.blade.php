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
            {{--<div class="panel-heading">My waiting orders</div>--}}
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseOne">My waiting orders</a>
                    <span class="label label-primary">{{ count($orders_from_user_not_accept) }}</span>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">

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
                            {{--<th scope="col">Name--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 2)"></button>--}}
                            {{--</th>--}}
                            {{--<th scope="col">Surname--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 3)"></button>--}}
                            {{--</th>--}}
                            <th scope="col">Date start
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 2)"></button>
                            </th>
                            <th scope="col">Date end
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_not_accept_table', 3)"></button>
                            </th>
                            {{--<th scope="col">Tools</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_from_user_not_accept as $val)
                            <tr>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->user_id }}" name="{{ $val->user_id }}">{{ $val->username }}</a></td>
                                {{--<td>{{ $val->name }}</td>--}}
                                {{--<td>{{ $val->surname }}</td>--}}
                                <td id="date_start_{{ $val->order_id }}">{{ $val->date_start }}
                                    <button class="btn btn-warning" onclick="editDate('date_start_{{ $val->order_id }}', '{{ $val->order_id }}','{{ $val->date_start }}', 'date_start')" type="button" id="edit_date_button" data-toggle="tooltip" data-placement="top" title="Edit date">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>
                                </td>
                                <td id="date_end_{{ $val->order_id }}">{{ $val->date_end }}
                                    <button class="btn btn-warning" onclick="editDate('date_end_{{ $val->order_id }}', '{{ $val->order_id }}','{{ $val->date_end }}', 'date_end')" type="button" id="edit_date_button" data-toggle="tooltip" data-placement="top" title="Edit date">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>
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
            {{--<div class="panel-heading">Taken books</div>--}}
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseTwo">Taken books</a>
                    <span class="label label-primary">{{ count($orders_from_user_accept) }}</span>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse in">

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
                            {{--<th scope="col">Name--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 2)"></button>--}}
                            {{--</th>--}}
                            {{--<th scope="col">Surname--}}
                                {{--<button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 3)"></button>--}}
                            {{--</th>--}}
                            <th scope="col">Phone</th>
                            <th scope="col">E-mail
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 2)"></button>
                            </th>
                            <th scope="col">Date start
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 3)"></button>
                            </th>
                            <th scope="col">Date end
                                <button class="glyphicon glyphicon-sort" onclick="sortTable('orders_from_user_accept_table', 4)"></button>
                            </th>
                            {{--<th scope="col">Tools</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_from_user_accept as $val)
                            <tr>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->user_id }}" name="{{ $val->user_id }}">{{ $val->username }}</a></td>
                                {{--<td>{{ $val->name }}</td>--}}
                                {{--<td>{{ $val->surname }}</td>--}}
                                <td>{{ $val->phone }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td id="date_end_accept_{{ $val->order_id }}">{{ $val->date_end }}
                                    <button class="btn btn-warning" onclick="editDate('date_end_accept_{{ $val->order_id }}', '{{ $val->order_id }}', '{{ $val->date_end }}', 'date_end')" type="button" id="edit_date_accept_button" data-toggle="tooltip" data-placement="top" title="Edit date">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>
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
