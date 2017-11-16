@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Books</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr class="filters">
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
                                <td>{{ $val->name }}</td>
                                <td>{{ $val->author }}</td>
                                <td>{{ $val->genre }}</td>
                                <td>{{ $val->year }}</td>
                                <td>{{ $val->description }}</td>
                                <td>
                                    {{--<form action="delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">--}}
                                    {{--{{csrf_field()}}--}}
                                    {{--<input name="_method" type="hidden" value="DELETE">--}}
                                    {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                    <button class="btn btn-warning" type="button">Update</button>
                                    <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('', '')">Delete</button>
                                    {{--</form>--}}
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
