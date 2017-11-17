@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        {{--<div class="col-md-8 col-md-offset-2">--}}
            <div class="panel panel-default">
                <div class="panel-heading">Waiting orders</div>

                <div class="panel-body">

                    @if( count($orders_to_user) !== 0 )

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
                                @if(!$val->accept)
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
                                        <form class="form-inline" action="accept_order" method="post">
                                            {{csrf_field()}}
                                            <input name="order_id" type="hidden" value="{{ $val->order_id }}">
                                            <button class="btn btn-success" type="submit">Accept</button>
                                            <button class="btn btn-danger" type="submit" formaction="delete_order">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p> No one orders... </p>
                    @endif

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Given books</div>

                <div class="panel-body">

                    @if( count($orders_to_user) !== 0 )

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
                            <th scope="col">Create return</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_to_user as $val)
                            @if($val->accept)
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
                                    <form class="form-inline" action="book_return" method="post" id="return_form">
                                        {{csrf_field()}}
                                        <input name="order_id" type="hidden" value="{{ $val->order_id }}">
                                        {{--<button class="btn btn-primary" type="submit">Return</button>--}}

                                        <button class="btn btn-primary" type="button" onclick="myModal('return_form', '{{ $confirm_return_form_message }}')">Return</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                    @else
                        <p> No one orders... </p>
                    @endif

                </div>
            </div>
       {{--</div>--}}
    </div>
</div>

@endsection
