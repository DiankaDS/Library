@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{--<div class="col-md-8 col-md-offset-2">--}}
            <div class="panel panel-default">
                <div class="panel-heading">Library</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{--You are logged in!--}}

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Book name</th>
                                <th scope="col">Author</th>
                                <th scope="col">Year</th>
                                <th scope="col">Rating</th>
                                {{--<th scope="col">Genre</th>--}}
                                {{--<th scope="col">Tools</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($books as $val)
                            <tr>
                                <td>
                                    <a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a>
                                </td>

                                <td>{{ $val->author }}</td>

                                <td>{{ $val->year }}</td>

                                <td>
                                    @if($val->rating)
                                        {{ $val->rating }}
                                    @else
                                        0
                                    @endif
                                </td>

                                {{--<td>{{ $val->genre }}</td>--}}

                                {{--<td>--}}
                                    {{--<form action="orders/{{ $val->id }}" id="{{ $val->id }}" method="post" name="id">--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<input name="_method" type="hidden" value="DELETE">--}}
                                        {{--<input name="id" type="hidden" value="{{ $val->id }}">--}}

                                        {{--<button class="btn btn-success" type="submit">Take</button>--}}
                                    {{--</form>--}}
                                {{--</td>--}}
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                </div>
            </div>
        {{--</div>--}}
    </div>
</div>
@endsection
