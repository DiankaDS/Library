@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Genres</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Genre</th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($genres as $val)
                            <tr>
                                <td>{{ $val->name }}</td>
                                <td>
                                    {{--<form action="delete/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                        {{--<button class="btn btn-danger" type="button" id="delete_book_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_author_message }}')">Delete</button>--}}
                                    {{--</form>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <form class="form-inline" action="/" method="get">
                        {{csrf_field()}}

                        <button class="btn btn-info" type="submit">Add genre</button>
                    </form>

                </div>
        </div>
    </div>
        {{--</div>--}}
</div>

@endsection
