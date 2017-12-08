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
            <div class="panel-heading">Books</div>

            <div class="panel-body">
                @if (count($books) !== 0)
                    <table class="table" id="books_table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Photo</th>
                            <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 1)"></button></th>
                            <th scope="col">Author <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 2)"></button></th>
                            <th scope="col">Genre <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 3)"></button></th>
                            <th scope="col">Year <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 4)"></button></th>
                            <th scope="col">Tags <button class="glyphicon glyphicon-sort" onclick="sortTable('books_table', 5)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($books as $val)
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
                                <td id="tag_{{ $val->id }}">
                                    @foreach ($tags as $tag)
                                        @if ($tag->book_id == $val->id)
                                            <span class="label label-primary" >{{ $tag->tag }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <form action="admin_del_book/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="admins_book_id" type="hidden" value="{{ $val->id }}">

                                        <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_book_message }}')">Delete</button>
                                    </form>

                                    <button class="btn btn-info" type="button" onclick="addTagModal('{{ $val->id }}', '{{ $all_tags }}')">Edit tags</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> Nothing books... </p>
                @endif

                <div class="row" align="center">
                    {{ $books->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
