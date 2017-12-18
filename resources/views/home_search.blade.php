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

        <div class="col-md-6 col-md-offset-3">
            <input class="form-control" id="mySearch" type="search" placeholder="Search for book or authors..." autocomplete="off" onkeyup='newSearchBook(event);'>

        </div>
        <div class="col-md-2">
            {{--<button type="button" class="btn btn-info" onclick='location.reload();'>Clear filters</button>--}}

            <a href="/home_search"><button type="button" class="btn btn-info">Clear filters</button></a>
            {{--<button type="button" class="btn btn-info" onclick='newSearchBook(event);'>Search</button>--}}
        </div>
        <br>
    </div>

    <div class="row"><br></div>

        <div class="row">

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Genre</div>
                <div class="panel-body">
                    <form id="searchbox_genre">
                        <input class="form-control" type="text" name="genre" placeholder="Search genre..." autocomplete="off" onkeyup="newCheckTip(event, '{{ $genres }}', 'genres_list')">

                        <div class="list-group" id="genres_list">
                            @foreach ($genres->take(5) as $val)
                                <a href="#" class="list-group-item checkbox">
                                    <label>
                                        <input type="checkbox" id="genre_{{ $val->id }}" value="{{ $val->id }}" onclick='newSearchBook(event);'>
                                        {{ $val->name }}
                                    </label>
                                </a>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Year</div>
                <div class="panel-body">
                    <form id="searchbox_year">

                        <div class="list-group" id="year_list">
                            @foreach ($years as $val)
                                <a href="#" class="list-group-item checkbox">
                                    <label>
                                        <input type="checkbox" id="year_{{ $val->name }}" value="{{ $val->name }}" onclick='newSearchBook(event);'>
                                        {{ $val->name }}
                                    </label>
                                </a>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="row" id="myBooks">

                @if (count($books) !== 0)
                    @foreach ($books as $val)
                        <div class="col-md-6">
                            <div class="thumbnail" style="width: 250px; height: 300px;">
                                <a href="book_{{ $val->id }}" name="{{ $val->id }}">
                                    @if ($val->photo)
                                        <img src="{{$val->photo}}" style="width: 125px; height: 150px;">
                                    @else
                                        <img src="../images/default_book.jpg" style="width: 125px; height: 150px;">
                                    @endif
                                </a>

                                <div class="caption">
                                    <p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></p>
                                    <p align="center" style="text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $val->author }}, {{ $val->year }}</p>
                                    @if ($val->rating)
                                        <p align="center">Rating: <b>{{ $val->rating }}</b></p>
                                    @else
                                        <p align="center">Rating: <b>0</b></p>
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
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="?page=1" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                    <li class="page-item"><a class="page-link" href="?page=2">2</a></li>
                    {{--<li class="page-item"><a class="page-link" href="?page=3">3</a></li>--}}
                    <li class="page-item">
                        <a class="page-link" href="?page=2" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{--============================================================================--}}
            {{--@if ($paginator->hasPages())--}}
                {{--<ul class="pager">--}}
                    {{-- Previous Page Link --}}
                    {{--@if ($paginator->onFirstPage())--}}
                        {{--<li class="disabled"><span>? Previous</span></li>--}}
                    {{--@else--}}
                        {{--<li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">? Previous</a></li>--}}
                    {{--@endif--}}
                    {{-- Pagination Elements --}}
                    {{--@foreach ($elements as $element)--}}
                        {{-- "Three Dots" Separator --}}
                        {{--@if (is_string($element))--}}
                            {{--<li class="disabled"><span>{{ $element }}</span></li>--}}
                        {{--@endif--}}
                        {{-- Array Of Links --}}
                        {{--@if (is_array($element))--}}
                            {{--@foreach ($element as $page => $url)--}}
                                {{--@if ($page == $paginator->currentPage())--}}
                                    {{--<li class="active my-active"><span>{{ $page }}</span></li>--}}
                                {{--@else--}}
                                    {{--<li><a href="{{ $url }}">{{ $page }}</a></li>--}}
                                {{--@endif--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    {{--@endforeach--}}
                    {{-- Next Page Link --}}
                    {{--@if ($paginator->hasMorePages())--}}
                        {{--<li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next ?</a></li>--}}
                    {{--@else--}}
                        {{--<li class="disabled"><span>Next ?</span></li>--}}
                    {{--@endif--}}
                {{--</ul>--}}
            {{--@endif--}}
            {{--============================================================================--}}

            {{--<div class="row" align="center">--}}
                {{--{{ $books->links() }}--}}
            {{--</div>--}}
        </div>


        <div class="col-md-3">
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Authors</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<form class="searchbox">--}}
                        {{--<div class="list-group" id="authors_list">--}}
                            {{--@foreach ($authors->take(5) as $val)--}}
                                {{--<a href="#" class="list-group-item checkbox"><label><input type="checkbox" value="">{{ $val->name }}</label></a>--}}
                            {{--@endforeach--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="panel panel-default">
                <div class="panel-heading">Tags</div>
                <div class="panel-body">
                    <form id="searchbox_tag">
                        <input class="form-control" type="text" name="tags" placeholder="Search tag..." autocomplete="off" onkeyup="newCheckTip(event, '{{ $tags }}', 'tags_list')">

                        <div class="list-group" id="tags_list">
                            @foreach ($tags->take(5) as $val)
                                <a href="#" class="list-group-item checkbox">
                                    <label>
                                        <input type="checkbox" id="tag_{{ $val->id }}" value="{{ $val->id }}" onclick='newSearchBook(event);'>
                                        {{ $val->name }}
                                    </label>
                                </a>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Rating</div>
                <div class="panel-body">
                    <form id="searchbox_rating">
                        <div class="list-group" id="rating_list">

                            @for($n = 5; $n > 0; $n--)
                                <a href="#" class="list-group-item radio">
                                    <label>
                                        <input type="radio" id="rating_{{ $n }}" value="{{ $n }}" name="optradio" onclick='newSearchBook(event);'>
                                        @for($i = 0; $i < $n; $i++)
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        @endfor
                                        @for($i = 0; $i < 5 - $n; $i++)
                                            <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                                        @endfor
                                    </label>
                                </a>
                            @endfor

                        </div>
                    </form>
                </div>
            </div>

        </div>
        {{--</div>--}}
    </div>
</div>
@endsection
