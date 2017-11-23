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
                    <table class="table">
                        <thead>
                        <tr class="filters">
                            <th scope="col">Book name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Review</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Created</th>
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
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        <input name="admins_review_id" type="hidden" value="{{ $val->id }}">

                                        <button class="btn btn-danger" type="button" id="delete_review_button" onclick="myModal('{{ $val->id }}', '{{ $confirm_delete_review_message }}')">Delete</button>
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
