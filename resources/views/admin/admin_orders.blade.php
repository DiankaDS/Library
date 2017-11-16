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
                                <td>{{ $val->giving }}</td>
                                <td>{{ $val->taker }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                                <td>{{ $val->book }}</td>
                                <td>{{ $val->accept }}</td>
                                <td>{{ $val->return }}</td>
                                <td>
                                    {{--<form action="delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">--}}
                                    {{--{{csrf_field()}}--}}
                                    {{--<input name="_method" type="hidden" value="DELETE">--}}
                                    {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                    <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('', '')">Delete</button>
                                    {{--</form>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{--<form class="form-inline" action="/" method="get">--}}
                        {{--{{csrf_field()}}--}}

                        {{--<button class="btn btn-info" type="submit">Add order</button>--}}
                    {{--</form>--}}

                </div>
        </div>
    </div>
        {{--</div>--}}
</div>

@endsection
