@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">About book</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
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
                                    <form action="orders/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                        <button class="btn btn-success" type="submit">Take</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
