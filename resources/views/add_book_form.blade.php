@extends('layouts.app')

@section('content')
    <div class="container" onclick='clearTips();'>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add new book</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="add_book/complete">
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
                                    <button type="submit" class="btn btn-primary" value="Add_book">
                                        Add book
                                    </button> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
