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
                        <form class="form-horizontal col-md-8 col-md-offset-2" method="POST" enctype="multipart/form-data" action="add_book/complete">
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
                                        <input class="form-control" data-toggle="dropdown" id="author" type="text" autocomplete="off" name="author" value="{{ old('author') }}" required>
                                        {{--<input class="form-control" data-toggle="dropdown" id="author" type="text" autocomplete="off" name="author" value="{{ old('author') }}" onkeyup='checkTip(event, "author");' required>--}}
                                    </a>

                                    @if ($errors->has('author'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('author') }}</strong>
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

                            <div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">
                                <label for="genre" class="col-md-4 control-label">Genre</label>

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <select class="form-control" id="genre" name="genre">
                                            @foreach ($genres as $val)
                                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                    <input id="photo" type="file" name="photo" required>

                                    @if ($errors->has('photo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('photo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-success" value="Add_book">
                                        Add book
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{--</div>--}}
            </div>
        </div>


        <div id="googleModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Are you sure to add this book?</h4>
                    </div>
                    <div class="modal-body" align="center"></div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit" id="YesButton">Add book</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">No, back</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
