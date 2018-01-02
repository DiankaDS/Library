@extends('layouts.admin')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Recommended books</div>

            <div class="panel-body">

                @if (count($books) !== 0)
                    <table class="table" id="books_table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Photo</th>
                            <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 1)"></button></th>
                            <th scope="col">Username <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 2)"></button></th>
                            <th scope="col">Price <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 3)"></button></th>
                            <th scope="col">Link <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 4)"></button></th>
                            <th scope="col">Formats <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 5)"></button></th>
                            <th scope="col">Date add <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 6)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($books as $val)
                            <tr>
                                <td>
                                    <a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">
                                        @if ($val->book_photo)
                                            <img src="{{$val->book_photo}}" height="42" width="42">
                                        @else
                                            <img src="../images/default_book.jpg" height="42" width="42">
                                        @endif
                                    </a>
                                </td>
                                <td><a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a></td>
                                <td><a href="profile/{{ $val->user_id }}" name="{{ $val->user_id }}">{{ $val->username }}</a></td>
                                <td id="price_{{ $val->id }}">{{ $val->price }}
                                    <button onclick="editInput('price_{{ $val->id }}', '{{ $val->id }}', '{{ $val->price }}', 'edit_recommendation')" class="btn btn-warning" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>
                                </td>
                                <td>
                                    @if ($val->link)
                                        <a href="{{ $val->link }}">Show</a>
                                    @else
                                        <p>None</p>
                                    @endif
                                </td>
                                <td>
                                    @foreach (explode(",", $val->formats) as $val_1)
                                        <span class="label label-primary">{{ $val_1 }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $val->created_at }}</td>
                                <td>
                                    <form action="/admin_approve" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="admins_user_book_id" type="hidden" value="{{ $val->id }}">

                                        {{--<button class="btn btn-success" type="button" id="admin_approve" onclick="myModal('{{ $val->id }}', '{{ $confirm_approve_message }}')">Approve</button>--}}

                                        {{--<button class="btn btn-success" type="submit">Approve</button>--}}
                                        {{--<button class="btn btn-danger" type="submit" formaction="/admin_not_approve">Reject</button>--}}
                                        <button class="btn btn-success" type="submit" data-toggle="tooltip" data-placement="top" title="Approve">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </button>
                                        <button class="btn btn-danger" type="submit" formaction="/admin_not_approve" data-toggle="tooltip" data-placement="top" title="Reject">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> Nothing recommended books... </p>
                @endif

                <div class="row" align="center">
                    {{ $books->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
