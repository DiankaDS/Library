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
                                <th scope="col">Book</th>
                                {{--<th scope="col">Author</th>--}}
                                {{--<th scope="col">Year</th>--}}
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">Date start</th>
                                <th scope="col">Date end</th>
                                <th scope="col">Tools</th>

                                {{--<th scope="col">Genre</th>--}}
                                {{--<th scope="col">Tools</th>--}}
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
                                <td>{{ $val->date_start }}</td>
                                <td>{{ $val->date_end }}</td>

                                <td>
                                    <button class="btn btn-light"><a href="#">Accept</a></button>
                                    <button class="btn btn-info"><a href="#">Reject</a></button>

                                    {{--<form action="orders/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                        {{--<button class="btn btn-success" type="submit">Take</button>--}}
                                    {{--</form>--}}
                                </td>
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
