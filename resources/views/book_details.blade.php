@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">About book</div>

                <div class="panel-body" align="center">

                    @if ($book_info->photo)
                        <img src="{{$book_info->photo}}" height="300" width="250">
                    @else
                        <img src="../images/default_book.jpg" height="300" width="250">
                    @endif

                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Book name</th>
                            <td>{{ $book_info->name }}</td>
                        </tr>
                        <tr>
                            <th>Author</th>
                            <td>{{ $book_info->author }}</td>
                        </tr>
                        <tr>
                            <th>Genre</th>
                            <td>{{ $book_info->genre }}</td>
                        </tr>
                        <tr>
                            <th>Year</th>
                            <td>{{ $book_info->year }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $book_info->description }}</td>
                        </tr>
                        <tr>
                            <th>Date add</th>
                            <td>{{ $book_info->created_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="panel panel-default">
            {{--<div class="panel-heading">Users who have a book</div>--}}
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseOne">Users who have a book</a>
                    <span class="label label-primary">{{ count($users) }}</span>
                </h4>
            </div>

            <div id="collapseOne" class="panel-collapse collapse">

            <div class="panel-body">

                @if (count($users) != 0)
                    <table class="table" id="users_have_book_table">
                        <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Username <button class="glyphicon glyphicon-sort" onclick="sortTable('users_have_book_table', 1)"></button></th>
                            <th scope="col">Name <button class="glyphicon glyphicon-sort" onclick="sortTable('users_have_book_table', 2)"></button></th>
                            <th scope="col">Surname <button class="glyphicon glyphicon-sort" onclick="sortTable('users_have_book_table', 3)"></button></th>
                            <th scope="col">Send a wish</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $val)
                            <tr>
                                <td>
                                    <a href="profile/{{ $val->id }}" name="{{ $val->id }}">
                                        @if ($val->photo)
                                            <img src="../images/users/{{$val->photo}}" height="42" width="42">
                                        @else
                                            <img src="../images/default_user.jpg" height="42" width="42">
                                        @endif
                                    </a>
                                </td>
                                <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>
                                    <form action="orders" id="{{ $val->id }}" method="post" name="id" class="form-inline">
                                        {{csrf_field()}}
                                        <input name="book_id" type="hidden" value="{{ $book_info->id }}">
                                        <input name="giving_id" type="hidden" value="{{ $val->id }}">

                                        <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                                            <label for="date_start">Date start:</label>

                                            <input class="form-control" id="datepicker" name="date_start" placeholder="YYYY-MM-DD" type="text">
                                            {{--<input name="date_start" type="date" class="form-control" placeholder="date">--}}
                                            @if ($errors->has('date_start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('date_start') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                                            <label for="date_end">Date end:</label>

                                            <input class="form-control" id="datepicker" name="date_end" placeholder="YYYY-MM-DD" type="text">
                                            {{--<input name="date_end" type="date" class="form-control">--}}
                                            @if ($errors->has('date_end'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('date_end') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <button class="btn btn-success" type="submit">Take</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> This book has nothing... </p>
                @endif

            </div>
            </div>
        </div>

        <div class="panel panel-default">
            {{--<div class="panel-heading">Reviews</div>--}}
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseTwo">Reviews</a>
                </h4>
            </div>

            @if (!$user_reviews)
                <div id="collapseTwo" class="panel-collapse collapse in">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="add_review" id="add_review">
                        {{ csrf_field() }}
                        <div class="col-md-4">
                            <label for="name" class="col-md-4 control-label">Rating</label>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="rating" name="rating">
                                        @foreach (range(5, 1, -1) as $val)
                                            <option value="{{ $val }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <label for="name" class="col-md-4 control-label">Review</label>
                            <div class="col-md-6">

                                <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">

                                <textarea rows="4" cols="50" name="review" form="add_review" id="review" placeholder="Enter review here..."></textarea>

                                    @if ($errors->has('review'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('review') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                </div>
                            <input name="book_id" type="hidden" value="{{ $book_info->id }}">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Add review</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            <div class="panel-body">

                @if (count($reviews) != 0)
                    <div class="col-md-6">
                        @foreach ($reviews as $val)
                        <div class="panel panel-default">
                            <div class="panel-heading" id="review">
                                <a href="profile/{{ $val->user_id }}" name="{{ $val->user_id }}">
                                    {{--<img src="../images/users/{{$val->photo}}" height="42" width="42">--}}
                                    @if ($val->photo)
                                        <img src="../images/users/{{$val->photo}}" height="42" width="42">
                                    @else
                                        <img src="../images/default_user.jpg" height="42" width="42">
                                    @endif
                                </a>
                                <strong><a href="profile/{{ $val->user_id }}" name="{{ $val->user_id }}">{{ $val->username }}</a></strong>

                                @if( $val->user_id == Auth::user()->id )
                                    <button onclick="editReview('{{ $val->id }}','{{ $val->text }}')" class="btn btn-warning pull-right">Edit</button>
                                @endif

                                <div class="panel-body">
                                    <strong>Rating: {{ $val->rating }}</strong>

                                    <div id="review_{{ $val->id }}">
                                        <p class="text">{{ $val->text }}</p>
                                    </div>

                                    <span class="text-muted">commented at {{ $val->created_at }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p> This book hasn't reviews... Be first! </p>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
