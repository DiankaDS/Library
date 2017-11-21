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
                    <table class="table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Photo</th>
                            <th scope="col">Book name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Year</th>
                            <th scope="col">Description</th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($books as $val)
                            <tr>
                                <td>
                                    <a href="book_{{ $val->id }}" name="{{ $val->id }}">
                                        <img src="../images/books/{{$val->photo}}" height="42" width="42">
                                    </a>
                                </td>
                                <td><a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a></td>
                                <td>{{ $val->author }}</td>
                                <td>{{ $val->genre }}</td>
                                <td>{{ $val->year }}</td>
                                <td>{{ $val->description }}</td>
                                <td>

                                    <form action="admin_del_book/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        <input name="admins_book_id" type="hidden" value="{{ $val->id }}">

                                        <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_book_message }}')">Delete</button>
                                        {{--<button class="btn btn-warning" type="submit" formaction="admin_up_book/{{ $val->id }}">Update</button>--}}
                                    </form>

                                </td>
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
