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
            <div class="panel-heading">Reviews</div>

            <div class="panel-body">
                @if (count($reviews) !== 0)
                    <table class="table" id="reviews_table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Book name <button class="glyphicon glyphicon-sort" onclick="sortTable('reviews_table', 0)"></button></th>
                            <th scope="col">Username <button class="glyphicon glyphicon-sort" onclick="sortTable('reviews_table', 1)"></button></th>
                            <th scope="col">Review</th>
                            <th scope="col">Rating <button class="glyphicon glyphicon-sort" onclick="sortTable('reviews_table', 3)"></button></th>
                            <th scope="col">Created <button class="glyphicon glyphicon-sort" onclick="sortTable('reviews_table', 4)"></button></th>
                            <th scope="col">Tools</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @foreach ($reviews as $val)
                            <tr>
                                <td>
                                    <a href="book_{{ $val->book_id }}" name="{{ $val->book_id }}">{{ $val->book }}</a>
                                </td>
                                <td>
                                    <a href="profile/{{ $val->user_id }}" name="{{ $val->user_id }}">{{ $val->username }}</a>
                                </td>
                                <td>{{ $val->text }}</td>
                                <td>{{ $val->rating }}</td>
                                <td>{{ $val->created_at }}</td>
                                <td>
                                    <form action="admin_del_review/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">
                                        {{csrf_field()}}
                                        <input name="admins_review_id" type="hidden" value="{{ $val->id }}">

                                        {{--<button class="btn btn-danger" type="button" id="delete_review_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_review_message }}')">Delete</button>--}}
                                        <button class="btn btn-danger" type="button" id="delete_review_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_review_message }}')" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p> Nothing reviews... </p>
                @endif

                <div class="row" align="center">
                    {{ $reviews->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
