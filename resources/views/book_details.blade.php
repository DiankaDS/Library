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

                <div class="panel-body">

                    @if ( $book_info->photo )
                        <img src="../images/books/{{$book_info->photo}}">
                    @else
                        <img src="../images/default_book.jpg">
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

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Send a wish</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $val)
                            <tr>
                                <td>{{ $val->username }}</td>
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->surname }}</td>
                                <td>
                                    <form action="orders" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="book_id" type="hidden" value="{{ $book_info->id }}">
                                        <input name="giving_id" type="hidden" value="{{ $val->id }}">

                                        <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                                            <label for="date_start">Date start</label>

                                            <input name="date_start" type="date">
                                            @if ($errors->has('date_start'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('date_start') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                                            <label for="date_end">Date end</label>

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

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Text</th>
                            <th scope="col">Rating</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reviews as $val)
                            <tr>
                                <td>{{ $val->username }}</td>
                                <td>{{ $val->text }}</td>
                                <td>{{ $val->rating }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    {{--</div>--}}
</div>
@endsection
