@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Orders</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Book name</th>
                                {{--<th scope="col">Author</th>--}}
                                {{--<th scope="col">Year</th>--}}
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">Phone</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Date start</th>
                                <th scope="col">Date end</th>
                                <th scope="col">Decision</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders_to_user as $val)
                            <tr>
                                <td>{{ $val->book }}</td>
                                {{--<td>{{ $val->author }}</td>--}}
                                {{--<td>{{ $val->year }}</td>--}}
                                <td>{{ $val->username }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>{{ $val->phone }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>

                                <td>

                                    <form action="accept_order" id="accept" method="post" name="accept">
                                        {{csrf_field()}}
                                        <input name="order_id" type="hidden" value="{{ $val->order_id }}">

                                        <button class="btn btn-primary" type="submit">Accept</button>
                                    </form>

                                    <form action="delete_order" id="delete" method="post" name="delete">
                                        {{csrf_field()}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        <input name="order_id" type="hidden" value="{{ $val->order_id }}">

                                        <button class="btn btn-danger" type="submit">Reject</button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Given books</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Book name</th>
                            {{--<th scope="col">Author</th>--}}
                            {{--<th scope="col">Year</th>--}}
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Phone</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Date start</th>
                            <th scope="col">Date end</th>
                            {{--<th scope="col">Decision</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($given_books as $val)
                            <tr>
                                <td>{{ $val->book }}</td>
                                {{--<td>{{ $val->author }}</td>--}}
                                {{--<td>{{ $val->year }}</td>--}}
                                <td>{{ $val->username }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>{{ $val->phone }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>

                                {{--<td>--}}

                                    {{--<form action="accept_order" id="accept" method="post" name="accept">--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<input name="order_id" type="hidden" value="{{ $val->order_id }}">--}}

                                        {{--<button class="btn btn-primary" type="submit">Accept</button>--}}
                                    {{--</form>--}}

                                    {{--<form action="delete_order" id="delete" method="post" name="delete">--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        {{--<input name="order_id" type="hidden" value="{{ $val->order_id }}">--}}

                                        {{--<button class="btn btn-danger" type="submit">Reject</button>--}}
                                    {{--</form>--}}

                                {{--</td>--}}
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
