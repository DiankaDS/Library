@extends('layouts.app')

@section('content')
    <div class="container" onclick='clearTips();'>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapseOne">Wished books</a>
                        </h4>
                    </div>

                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            @if (count($wished_books) != 0)

                                <table class="table" id="wished_books">
                                    <thead>
                                    <tr>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('wished_books', 1)"></button></th>
                                        <th scope="col">Author <button class="glyphicon glyphicon-sort" onclick="sortTable('wished_books', 2)"></button></th>
                                        <th scope="col">Genre <button class="glyphicon glyphicon-sort" onclick="sortTable('wished_books', 3)"></button></th>
                                        <th scope="col">Year <button class="glyphicon glyphicon-sort" onclick="sortTable('wished_books', 4)"></button></th>
                                        <th scope="col">Votes <button class="glyphicon glyphicon-sort" onclick="sortTable('wished_books', 5)"></button></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($wished_books as $val)
                                        <tr>
                                            <td>
                                                <a href="book_{{ $val->id }}" name="{{ $val->id }}">
                                                    @if ($val->photo)
                                                        <img src="{{$val->photo}}" height="42" width="42">
                                                    @else
                                                        <img src="../images/default_book.jpg" height="42" width="42">
                                                    @endif
                                                </a>
                                            </td>
                                            <td><a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></td>
                                            <td>{{ $val->author }}</td>
                                            <td>{{ $val->genre }}</td>
                                            <td>{{ $val->year }}</td>
                                            <td>0</td>
                                            <td><button class="btn btn-primary" type="button">Vote</button></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p> Nothing books... </p>
                            @endif

                            <div class="row" align="center">
                                {{ $wished_books->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        {{--<div class="row">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">--}}
                    {{--<h4 class="panel-title">--}}
                        {{--<a data-toggle="collapse" href="#collapseTwo">Add wished book</a>--}}
                    {{--</h4>--}}
                {{--</div>--}}

                {{--<div id="collapseTwo" class="panel-collapse collapse">--}}
                    {{--<div class="panel-body">--}}
                        {{--<form class="form-horizontal col-md-8 col-md-offset-2" method="POST" enctype="multipart/form-data" action="/add_book/complete" id="create_book_form">--}}
                            {{--{{ csrf_field() }}--}}

                            {{--<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                                {{--<label for="name" class="col-md-4 control-label">Book name</label>--}}

                                {{--<div class="col-md-6">--}}

                                    {{--<a class="dropdown">--}}
                                        {{--<input class="form-control" data-toggle="dropdown" id="name" type="text" autocomplete="off" name="name" value="{{ old('name') }}" onkeyup='checkTip(event, "name");' required>--}}
                                    {{--</a>--}}

                                    {{--@if ($errors->has('name'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('name') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">--}}
                                {{--<label for="author" class="col-md-4 control-label">Author</label>--}}

                                {{--<div class="col-md-6">--}}

                                    {{--<a class="dropdown">--}}
                                        {{--<input class="form-control" data-toggle="dropdown" id="author" type="text" autocomplete="off" name="author" value="{{ old('author') }}" onkeyup='checkTip(event, "author");' required>--}}
                                        {{--<input class="form-control" data-toggle="dropdown" id="author" type="text" autocomplete="off" name="author" value="{{ old('author') }}" onkeyup='checkTip(event, "author");' required>--}}
                                    {{--</a>--}}

                                    {{--@if ($errors->has('author'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('author') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">--}}
                                {{--<label for="genre" class="col-md-4 control-label">Genre</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<a class="dropdown">--}}
                                        {{--<input class="form-control" data-toggle="dropdown" id="genre" type="text" autocomplete="off" name="genre" value="{{ old('genre') }}" onkeyup='checkTip(event, "genre");' required>--}}
                                    {{--</a>--}}

                                    {{--@if ($errors->has('genre'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('genre') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">--}}
                                {{--<label for="year" class="col-md-4 control-label">Year</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="year" type="text" autocomplete="off" class="form-control" name="year" value="{{ old('year') }}" required>--}}

                                    {{--@if ($errors->has('year'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('year') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">--}}
                                {{--<label for="description" class="col-md-4 control-label">Description</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="description" type="text" autocomplete="off" class="form-control" name="description" value="{{ old('description') }}" required>--}}
                                    {{--<textarea rows="4" cols="50" name="description" id="description" autocomplete="off" class="form-control" required>{{ old('description') }}</textarea>--}}

                                    {{--@if ($errors->has('description'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('description') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">--}}
                                {{--<label for="photo" class="col-md-4 control-label">Photo</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="photo" type="file" name="photo" required>--}}
                                    {{--<input id="google_photo" name="google_photo" type="hidden">--}}

                                    {{--@if ($errors->has('photo'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('photo') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group">--}}
                                {{--<div class="col-md-6 col-md-offset-4">--}}
                                    {{--<button type="submit" class="btn btn-success" value="Add_book">--}}
                                        {{--Add book--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">Search book to add</div>--}}

                    {{--<div class="panel-heading">--}}
                        {{--<h4 class="panel-title">--}}
                            {{--<a data-toggle="collapse" href="#collapseOne">Search your book in library</a>--}}
                        {{--</h4>--}}
                    {{--</div>--}}

                    {{--<div id="collapseOne" class="panel-collapse collapse in">--}}
                        {{--<div class="panel-body">--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input class="form-control" type="text" autocomplete="off" name="name" onkeyup='googleSearch(event);' placeholder="Please, search your book here" autofocus>--}}
                                {{--<br>--}}
                            {{--</div>--}}

                            {{--<div class="row col-md-12" id="myBooks"><p align="center"> You will see books here. </p></div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    </div>
@endsection
