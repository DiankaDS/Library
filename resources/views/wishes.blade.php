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
                                        <td>{{ $val->votes }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Show votes
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    @if (count($vote_users->where('book_id', $val->id)) != 0)
                                                    @foreach ($vote_users as $user)
                                                        @if ($user->book_id == $val->id)
                                                            <li><a href="profile/{{ $user->user_id }}">{{ $user->username }}</a></li>
                                                        @endif
                                                    @endforeach
                                                    @else
                                                        <li><a href="#">No one...</a></li>
                                                    @endif
                                                </ul>
                                                @if (count($auth_books_votes->where('book_id', $val->id)) == 0)
                                                    <form class="form-inline" action="/add_vote" method="post" id="add_vote" name="add_vote" style ='display:inline;'>
                                                        <input name="book_id" type="hidden" value="{{ $val->id }}">
                                                        {{csrf_field()}}

                                                        {{--<button class="btn btn-success" type="submit">Vote up</button>--}}
                                                        <button class="btn btn-success" type="submit" data-toggle="tooltip" data-placement="top" title="Vote up"><span class="glyphicon glyphicon-thumbs-up"></span></button>
                                                    </form>
                                                @else
                                                    <form class="form-inline" action="/delete_vote" method="post" id="delete_vote" name="delete_vote" style ='display:inline;'>
                                                        <input name="book_id" type="hidden" value="{{ $val->id }}">
                                                        {{csrf_field()}}

                                                        {{--<button class="btn btn-danger" type="submit">Vote down</button>--}}
                                                        <button class="btn btn-danger" type="submit" data-toggle="tooltip" data-placement="top" title="Vote down"><span class="glyphicon glyphicon-thumbs-down"></span></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
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

    </div>
@endsection
