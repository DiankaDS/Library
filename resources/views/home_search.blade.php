@extends('layouts.app')

<script>
    var genres = [];
    var tags = [];
    var years = [];
</script>
@foreach ($genres as $val)
<script>genres.push({"id":"{{ $val->id }}", "name":"{{ $val->name }}"});</script>
@endforeach
@foreach ($tags as $val)
    <script>tags.push({"id":"{{ $val->id }}", "name":"{{ $val->name }}"});</script>
@endforeach
@foreach ($years as $val)
    <script>years.push({"id":"{{ $val->name }}", "name":"{{ $val->name }}"});</script>
@endforeach

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
        <div class="col-md-2">
            <a href="/"><button type="button" class="btn btn-info">Clear filters</button></a>
            {{--<button type="button" class="btn btn-info" onclick='newSearchBook(event);'>Search</button>--}}
        </div>
        <div class="col-md-9 col-md-offset-1">
            <input class="form-control" id="mySearch" type="search" placeholder="Search for book or authors..." autocomplete="off" onkeyup='setTimeout(newSearchBook(event), 1000);'>
        </div>
        <br>
    </div>

    <div class="row"><br></div>

        <div class="row">

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseGenres">Genres</a>
                    </h4>
                </div>
                <div id="collapseGenres" class="panel-collapse collapse">

                <div class="panel-body">
                    <form id="searchbox_genres">
                        <input class="form-control" type="text" name="genre" placeholder="Search genre..." autocomplete="off" onkeyup="newCheckTip(event, 'genres')">

                        <div class="list-group" id="genres_list">

                            <div class="list-group" id="genres_list_checked"></div>
                            <div class="list-group" id="genres_list_unchecked">
                            @foreach ($genres->take(5) as $val)
                                <a href="#" class="list-group-item checkbox">
                                    <label>
                                        {{--<input type="checkbox" id="genre_{{ $val->id }}" value="{{ $val->id }}" onclick='newSearchBook(event);'>--}}
                                        <input type="checkbox" id="genres_{{ $val->id }}" value="{{ $val->id }}" onclick='clickCheckbox(event, "genres");'>
                                        {{ $val->name }}
                                    </label>
                                </a>
                            @endforeach
                            </div>

                        </div>
                    </form>
                </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseYears">Years</a>
                    </h4>
                </div>
                <div id="collapseYears" class="panel-collapse collapse">

                <div class="panel-body">
                    <form id="searchbox_years">
                        <input class="form-control" type="text" name="years" placeholder="Search year..." autocomplete="off" onkeyup="newCheckTip(event, 'years')">

                        <div class="list-group" id="years_list">

                            <div class="list-group" id="years_list_checked"></div>
                            <div class="list-group" id="years_list_unchecked">
                            @foreach ($years->take(5) as $val)
                                <a href="#" class="list-group-item checkbox">
                                    <label>
                                        <input type="checkbox" id="years_{{ $val->name }}" value="{{ $val->name }}" onclick='clickCheckbox(event, "years");'>
                                        {{ $val->name }}
                                    </label>
                                </a>
                            @endforeach
                            </div>

                        </div>
                    </form>
                    {{--<button id="nextYears">Show More</button>--}}
                    {{--<button id="prevYears">Show Less</button>--}}
                </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseTags">Tags</a>
                    </h4>
                </div>
                <div id="collapseTags" class="panel-collapse collapse">

                <div class="panel-body">
                    <form id="searchbox_tags">
                        <input class="form-control" type="text" name="tags" placeholder="Search tag..." autocomplete="off" onkeyup="newCheckTip(event, 'tags')">

                        <div class="list-group" id="tags_list">

                            <div class="list-group" id="tags_list_checked"></div>
                            <div class="list-group" id="tags_list_unchecked">
                                @foreach ($tags->take(5) as $val)
                                    <a href="#" class="list-group-item checkbox">
                                        <label>
                                            <input type="checkbox" id="tags_{{ $val->id }}" value="{{ $val->id }}" onclick='clickCheckbox(event, "tags");'>
                                            {{ $val->name }}
                                        </label>
                                    </a>
                                @endforeach
                            </div>

                        </div>
                    </form>
                </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseRating">Rating</a>
                    </h4>
                </div>
                <div id="collapseRating" class="panel-collapse collapse in">

                <div class="panel-body">
                    <form id="searchbox_ratings">
                        <div class="list-group" id="ratings_list">

                            @for($n = 5; $n > 0; $n--)
                                <a href="#" class="list-group-item radio">
                                    <label>
                                        <input type="radio" id="ratings_{{ $n }}" value="{{ $n }}" name="optradio" onclick='newSearchBook(event);'>
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

        </div>

        <div class="col-md-9">
            <div class="row" id="myBooks">

                @if (count($books) !== 0)
                    @foreach ($books as $val)
                        <div class="col-md-4 col-sm-4 col-xs-6">
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
                                    <p align="center">
                                        @foreach (explode(",", $val->formats) as $val_1)
                                            <span class="label label-primary">{{ $val_1 }}</span>
                                        @endforeach
                                    </p>
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


            {{--============================================================================--}}

            <div class="row" id="pagination" align="center">
            {{ $books->links() }}

                {{--<p>count {{ $books->count() }}</p>--}}
                {{--<p>currentPage {{ $books->currentPage() }}</p>--}}
                {{--<p>firstItem {{ $books->firstItem() }}</p>--}}
                {{--<p>hasMorePages {{ $books->hasMorePages() }}</p>--}}
                {{--<p>lastItem {{ $books->lastItem() }}</p>--}}
                {{--<p>nextPageUrl {{ $books->nextPageUrl() }}</p>--}}
                {{--<p>perPage {{ $books->perPage() }}</p>--}}
                {{--<p>previousPageUrl {{ $books->previousPageUrl() }}</p>--}}
                {{--<p>total {{ $books->firstItem() }}</p>--}}
                {{--<p>url {{ $books->firstItem() }}</p>--}}

            </div>

            {{--============================================================================--}}
            {{--<div class="row" id="pagination_ajax" hidden>--}}
                {{--<ul class="pagination">--}}
                    {{--@if ($books->onFirstPage())--}}
                        {{--<li class="page-item disabled">--}}
                            {{--<a class="page-link" href="#">--}}
                                {{--<span aria-hidden="true">&laquo;</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@else--}}
                        {{--<li class="page-item">--}}
                            {{--<a class="page-link" href="{{ $books->previousPageUrl() }}">--}}
                                {{--<span aria-hidden="true">&laquo;</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@endif--}}

                    {{--@if ($books->currentPage() > 1)--}}
                        {{--@for ($i = $books->currentPage() - 2; $i < $books->currentPage(); $i++)--}}
                            {{--@if ($i > 0)--}}
                            {{--<li class="page-item"><a class="page-link" href="{{ $books->url($i) }}">{{ $i }}</a></li>--}}
                            {{--@endif--}}
                        {{--@endfor--}}
                    {{--@endif--}}

                    {{--<li class="page-item active"><a class="page-link" href="#">{{ $books->currentPage() }}</a></li>--}}

                    {{--@if ($books->hasMorePages())--}}
                        {{--@for ($i = $books->currentPage() + 1; $i <= $books->currentPage() + 2; $i++)--}}
                            {{--@if ($i != $books->lastPage() + 1)--}}
                                {{--<li class="page-item"><a class="page-link" href="{{ $books->url($i) }}">{{ $i }}</a></li>--}}
                            {{--@endif--}}
                        {{--@endfor--}}
                    {{--@endif--}}

                    {{--@if ($books->hasMorePages())--}}
                        {{--<li class="page-item">--}}
                            {{--<a class="page-link" href="{{ $books->nextPageUrl() }}">--}}
                                {{--<span aria-hidden="true">&raquo;</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@else--}}
                        {{--<li class="page-item disabled">--}}
                            {{--<a class="page-link" href="#">--}}
                                {{--<span aria-hidden="true">&raquo;</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@endif--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--============================================================================--}}
        </div>


        {{--<div class="col-md-3">--}}
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

            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Tags</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<form id="searchbox_tags">--}}
                        {{--<input class="form-control" type="text" name="tags" placeholder="Search tag..." autocomplete="off" onkeyup="newCheckTip(event, 'tags')">--}}

                        {{--<div class="list-group" id="tags_list">--}}

                            {{--<div class="list-group" id="tags_list_checked"></div>--}}
                            {{--<div class="list-group" id="tags_list_unchecked">--}}
                            {{--@foreach ($tags->take(5) as $val)--}}
                                {{--<a href="#" class="list-group-item checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox" id="tags_{{ $val->id }}" value="{{ $val->id }}" onclick='clickCheckbox(event, "tags");'>--}}
                                        {{--{{ $val->name }}--}}
                                    {{--</label>--}}
                                {{--</a>--}}
                            {{--@endforeach--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Rating</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<form id="searchbox_ratings">--}}
                        {{--<div class="list-group" id="ratings_list">--}}

                            {{--@for($n = 5; $n > 0; $n--)--}}
                                {{--<a href="#" class="list-group-item radio">--}}
                                    {{--<label>--}}
                                        {{--<input type="radio" id="ratings_{{ $n }}" value="{{ $n }}" name="optradio" onclick='newSearchBook(event);'>--}}
                                        {{--@for($i = 0; $i < $n; $i++)--}}
                                            {{--<span class="glyphicon glyphicon-star" aria-hidden="true"></span>--}}
                                        {{--@endfor--}}
                                        {{--@for($i = 0; $i < 5 - $n; $i++)--}}
                                            {{--<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>--}}
                                        {{--@endfor--}}
                                    {{--</label>--}}
                                {{--</a>--}}
                            {{--@endfor--}}

                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
@endsection
