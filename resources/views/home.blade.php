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

        <form class="form-inline">
            <input class="form-control" id="mySearchBook" type="text" placeholder="Book name">
            <input class="form-control" id="mySearchAuthor" type="text" placeholder="Author">
            <input class="form-control" id="mySearchYear" type="text" placeholder="Year">
            <input class="form-control" id="mySearchGenre" type="text" placeholder="Genre">

            {{--<select class="form-control" id="mySearchAuthor" name="author">--}}
                {{--<option value="">All authors</option>--}}
                {{--@foreach ($authors as $val)--}}
                    {{--<option value="{{ $val->id }}">{{ $val->name }}</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
            {{--<select class="form-control" id="mySearchGenre" name="genre">--}}
                {{--<option value="">All genres</option>--}}
                {{--@foreach ($genres as $val)--}}
                    {{--<option value="{{ $val->id }}">{{ $val->name }}</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}

            <button type="button" class="btn btn-info" onclick='searchBook(event);'>Search book</button>
        </form>

    </div>
    <br>

    <div class="row">
        <div class="panel panel-default">
                <div class="panel-heading">Library</div>

                <div class="panel-body">

                    <div class="row" id="myBooks">
                        @foreach ($books as $val)
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <a href="book_{{ $val->id }}" name="{{ $val->id }}">
                                        <img src="../images/books/{{$val->photo}}" style="width: 125px; height: 150px;">
                                    </a>
                                    <div class="caption">
                                        <p align="center"><a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></p>
                                        <p align="center">{{ $val->author }}, {{ $val->year }}</p>
                                        @if($val->rating)
                                            <p align="center">Rating: {{ $val->rating }} </p>
                                        @else
                                            <p align="center">Rating: 0</p>
                                        @endif
                                    </div>
                                    {{--</a>--}}
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
