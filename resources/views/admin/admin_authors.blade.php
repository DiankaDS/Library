@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Authors</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Author</th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($authors as $val)
                            <tr>
                                <td>{{ $val->name }}</td>
                                <td>
                                    {{--<form action="delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                        <button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('', '')">Delete</button>
                                    {{--</form>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <form class="form-inline" action="/" method="get">
                        {{csrf_field()}}

                        <button class="btn btn-info" type="submit">Add author</button>
                    </form>

                </div>
        </div>
        </div>
    </div>
        {{--</div>--}}
</div>

@endsection
