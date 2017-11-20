@extends('layouts.app')

@section('content')
<div class="container">

    @guest
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2><p class="text-danger">
                   Welcome, guest! Please, login or register to see more.
                </p></h2>
            </div>
        </div>
    @endguest

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

    <div class="row">
        <div class="col-md-4">
            <input class="form-control" id="mySearch" type="text" placeholder="Quick search">
        </div>
    </div>
    <br>

    <div class="row">
        <div class="panel panel-default">
                <div class="panel-heading">Library</div>

                <div class="panel-body">

                    {{--You are logged in!--}}
                        {{--<div class="filterable">--}}

                        {{--<table class="table">--}}
                            {{--<thead>--}}
                            {{--<tr class="filters">--}}
                                {{--<th scope="col">Photo</th>--}}
                                {{--<th scope="col">Book name<input type="text" class="form-control" placeholder="Search name"></th>--}}
                                {{--<th scope="col">Author<input type="text" class="form-control" placeholder="Search author"></th>--}}
                                {{--<th scope="col">Year<input type="text" class="form-control" placeholder="Search year"></th>--}}
                                {{--<th scope="col">Genre<input type="text" class="form-control" placeholder="Search genre"></th>--}}
                                {{--<th scope="col">Rating<input type="text" class="form-control" placeholder="Search rating"></th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody id="myTable">--}}
                            {{--@foreach ($books as $val)--}}
                            {{--<tr>--}}
                                {{--<td>--}}
                                    {{--<a href="book_{{ $val->id }}" name="{{ $val->id }}">--}}
                                        {{--<img src="../images/books/{{$val->photo}}" height="50" width="50">--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a>--}}
                                {{--</td>--}}

                                {{--<td>{{ $val->author }}</td>--}}
                                {{--<td>{{ $val->year }}</td>--}}
                                {{--<td>{{ $val->genre }}</td>--}}

                                {{--<td>--}}
                                    {{--@if($val->rating)--}}
                                        {{--{{ $val->rating }}--}}
                                    {{--@else--}}
                                        {{--0--}}
                                    {{--@endif--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}

                    <div class="row">
                        @foreach ($books as $val)
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <a href="book_{{ $val->id }}" name="{{ $val->id }}">
                                        <img src="../images/books/{{$val->photo}}" style="width: 125px; height: 150px;">
                                        <div class="caption">
                                            <p align="center"><a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></p>
                                            <p align="center">{{ $val->author }}, {{ $val->year }}</p>
                                            @if($val->rating)
                                                <p align="center">Rating: {{ $val->rating }} </p>
                                            @else
                                                <p align="center">Rating: 0</p>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        {{--</div>--}}
    </div>

</div>
@endsection
