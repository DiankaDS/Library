@extends('layouts.app')

@section('content')
    <div class="container" onclick='clearTips();'>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            {{--<div class="col-md-8 col-md-offset-2">--}}
                <div class="panel panel-default">
                    {{--<div class="panel-heading">Search book to add</div>--}}

                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapseOne">Search your book in library</a>
                        </h4>
                    </div>

                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">

                            <div class="col-md-6">
                                <input class="form-control" type="text" autocomplete="off" name="name" onkeyup='googleSearch(event);' placeholder="Please, search your book here" autofocus>
                            <br>
                            </div>

                            <div class="row col-md-12" id="myBooks"><p align="center"> You will see books here. </p></div>

                        </div>
                    </div>
                </div>
            {{--</div>--}}
        </div>


        <div class="row">
            {{--<div class="col-md-8 col-md-offset-2">--}}
            <div class="panel panel-default">
                {{--<div class="panel-heading">Add new book</div>--}}
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseTwo">Not found your book? Add new one</a>
                    </h4>
                </div>

                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form class="form-horizontal col-md-8 col-md-offset-2" method="POST" enctype="multipart/form-data" action="/add_book/complete" id="create_book_form">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Book name</label>

                                <div class="col-md-6">

                                    <a class="dropdown">
                                        <input class="form-control" data-toggle="dropdown" id="name" type="text" autocomplete="off" name="name" value="{{ old('name') }}" onkeyup='checkTip(event, "name");' required>
                                    </a>
                                    {{--<input id="name" type="text" autocomplete="off" class="form-control" name="name" value="{{ old('name') }}" onkeyup='checkTip(event, "name");' required>--}}

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
                                <label for="author" class="col-md-4 control-label">Author</label>

                                <div class="col-md-6">

                                    <a class="dropdown">
                                        <input class="form-control" data-toggle="dropdown" id="author" type="text" autocomplete="off" name="author" value="{{ old('author') }}" onkeyup='checkTip(event, "author");' required>
                                        {{--<input class="form-control" data-toggle="dropdown" id="author" type="text" autocomplete="off" name="author" value="{{ old('author') }}" onkeyup='checkTip(event, "author");' required>--}}
                                    </a>

                                    @if ($errors->has('author'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('author') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">
                                <label for="genre" class="col-md-4 control-label">Genre</label>

                                <div class="col-md-6">
                                    <a class="dropdown">
                                        <input class="form-control" data-toggle="dropdown" id="genre" type="text" autocomplete="off" name="genre" value="{{ old('genre') }}" onkeyup='checkTip(event, "genre");' required>
                                    </a>

                                    @if ($errors->has('genre'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('genre') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                                <label for="year" class="col-md-4 control-label">Year</label>

                                <div class="col-md-6">
                                    <input id="year" type="text" autocomplete="off" class="form-control" name="year" value="{{ old('year') }}" required>

                                    @if ($errors->has('year'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('year') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    {{--<input id="description" type="text" autocomplete="off" class="form-control" name="description" value="{{ old('description') }}" required>--}}
                                    <textarea rows="4" cols="50" name="description" id="description" autocomplete="off" class="form-control" required>{{ old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                                <label for="photo" class="col-md-4 control-label">Photo</label>

                                <div class="col-md-6">
                                    <input id="photo" type="file" name="photo">
                                    <input id="google_photo" name="google_photo" type="hidden">

                                    @if ($errors->has('photo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('photo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group" id="formTagsinput">
                                <label for="tags" class="col-md-4 control-label">Tags</label>
                                {{--<br>--}}
                                <a class="dropdown">
                                    <input class="form-control" id="mySearchTags" type="text" name="tags" data-role="tagsinput" autocomplete="off">
                                </a>
                            </div>

                            <div class="form-group" id="formFormatsinput">
                                <label for="formats" class="col-md-4 control-label">Formats</label>
                                <br>
                                <a class="dropdown">
                                    <input class="form-control" id="mySearchFormats" type="text" name="formats" data-role="tagsinput" autocomplete="off">
                                </a>
                            </div>


                            <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                                <label for="link" class="col-md-4 control-label">Link</label>

                                <div class="col-md-6">
                                    <input id="link" type="text" autocomplete="off" class="form-control" name="link" value="{{ old('link') }}">

                                    @if ($errors->has('link'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-md-4 control-label">Price</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" autocomplete="off" class="form-control" name="price" value="{{ old('price') }}">

                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <input id="span_tags" type="hidden" name="span_tags" value="">
                            <input id="span_formats" type="hidden" name="span_formats" value="">

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {{--<button type="submit" class="btn btn-success" value="Add_book">Add book</button>--}}
                                    <button type="button" class="btn btn-success" value="Add_book" onclick="addBookSubmit()">Add book</button>

                                    <input id="wish" type="hidden" name="wish" value="0">
                                    <button type="button" class="btn btn-info" value="Wish_book" onclick="wishBook()">Wish book</button>

                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="form-group" id="formTagsinputModal" hidden>
                        <label for="tags" class="control-label">Tags:</label>
                        <a class="dropdown">
                            <input class="form-control" id="mySearchTagsModal" type="text" name="tags" data-role="tagsinput" autocomplete="off">
                        </a>
                    </div>

                    <div class="form-group" id="formFormatsinputModal" hidden>
                        <label for="formats" class="control-label">Formats:</label>
                        <a class="dropdown">
                            <input class="form-control" id="mySearchFormatsModal" type="text" name="formats" data-role="tagsinput" autocomplete="off">
                        </a>
                    </div>

                </div>
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection
