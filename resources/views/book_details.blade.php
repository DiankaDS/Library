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

{{--                    @if ( $book_info->photo )--}}
                    <img src="../images/books/{{$book_info->photo}}" height="300" width="250">
                    {{--@else--}}
                        {{--<img src="../images/books/default_book.jpg">--}}
                    {{--@endif--}}

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
                            <th>Year</th>
                            <td>{{ $book_info->year }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $book_info->description }}</td>
                        </tr>
                        <tr>
                            <th>Genre</th>
                            <td>{{ $book_info->genre }}</td>
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
                <div class="panel-heading">Users who have a book</div>

                <div class="panel-body">

{{--                    {{ var_dump($users) }}--}}

                    @if( count($users) != 0 )

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Photo</th>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Send a wish</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $val)
                            <tr>
                                <td><a href="profile/{{ $val->id }}" name="{{ $val->id }}">
                                        <img src="../images/users/{{$val->photo}}" height="42" width="42"></a>
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

                                            <input name="date_start" type="date">
                                            @if ($errors->has('date_start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('date_start') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                                            <label for="date_end">Date end:</label>

                                            <input name="date_end" type="date">
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

            <div class="panel panel-default">
                <div class="panel-heading">Reviews</div>

                @if( !$user_reviews )

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

                    @if( count($reviews) != 0 )
                    <div class="col-md-6">
                        @foreach ($reviews as $val)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="profile/{{ $val->id }}" name="{{ $val->id }}">
                                    <img src="../images/users/{{$val->photo}}" height="42" width="42">
                                </a>
                                <strong><a href="profile/{{ $val->id }}" name="{{ $val->id }}">{{ $val->username }}</a></strong>
                            <div class="panel-body">
                                <strong>Rating: {{ $val->rating }}</strong>
                                <p class="text">{{ $val->text }}</p>
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
    {{--</div>--}}
</div>
@endsection
