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
            {{--<input class="form-control" id="mySearchBook" type="text" placeholder="Book name" autocomplete="off" onkeyup='checkTip(event, "name");'>--}}
            {{--<input class="form-control" id="mySearchAuthor" type="text" placeholder="Author" autocomplete="off" onkeyup='checkTip(event, "author");'>--}}

            <a class="dropdown">
                <input class="form-control" data-toggle="dropdown" id="mySearchBook" type="text" placeholder="Book name" autocomplete="off" onkeyup='checkTip(event, "name");'>
            </a>
            <a class="dropdown">
                <input class="form-control" data-toggle="dropdown" id="mySearchAuthor" type="text" placeholder="Author" autocomplete="off" onkeyup='checkTip(event, "author");'>
            </a>

            <input class="form-control" id="mySearchYear" type="text" autocomplete="off" placeholder="Year">

            <select class="form-control" id="mySearchGenre" name="genre">
                <option value="">All genres</option>
                @foreach ($genres as $val)
                    <option value="{{ $val->name }}">{{ $val->name }}</option>
                @endforeach
            </select>

            <button type="button" class="btn btn-info" onclick='searchBook(event);'>Search book</button>
        </form>
    </div>
    <br>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Library</div>

            <div class="panel-body">
                <div class="row" id="myBooks">
                    @if (count($books) !== 0)
                        @foreach ($books as $val)
                            <div class="col-md-3">
                                <div class="thumbnail">
                                    <a href="book_{{ $val->id }}" name="{{ $val->id }}">
                                        @if ($val->photo)
                                            <img src="../images/books/{{$val->photo}}" style="width: 125px; height: 150px;">
                                        @else
                                            <img src="../images/default_book.jpg" style="width: 125px; height: 150px;">
                                        @endif
                                    </a>

                                    <div class="caption">
                                        <p align="center"><a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></p>
                                        <p align="center">{{ $val->author }}, {{ $val->year }}</p>
                                        @if ($val->rating)
                                            <p align="center">Rating: {{ $val->rating }} </p>
                                        @else
                                            <p align="center">Rating: 0</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @else
                        <div class="col-md-3">
                            <p> Nothing books... Add first one! </p>
                        </div>
                    @endif
                </div>
                <div class="row" align="center">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
