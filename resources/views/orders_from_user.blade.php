@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading">My waiting orders</div>

                <div class="panel-body">

                    @if( count($orders_from_user_not_accept) != 0 )

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Book name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            {{--<th scope="col">Phone</th>--}}
                            {{--<th scope="col">E-mail</th>--}}
                            <th scope="col">Date start</th>
                            <th scope="col">Date end</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_from_user_not_accept as $val)
{{--                            @if(!$val->accept)--}}
                            <tr>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                {{--<td>{{ $val->phone }}</td>--}}
                                {{--<td>{{ $val->email }}</td>--}}
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>
                            </tr>
                            {{--@endif--}}
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

                    @if( count($orders_from_user_accept) != 0 )

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Book name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Phone</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Date start</th>
                            <th scope="col">Date end</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders_from_user_accept as $val)
{{--                            @if($val->accept)--}}
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
                            {{--@endif--}}
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
