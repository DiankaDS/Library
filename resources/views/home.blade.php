@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                                <th scope="col">Year</th>
                                <th scope="col">Description</th>
                                <th scope="col">Genre</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($books as $val)
                            <tr>
                                <td>{{ $val->name }}</td>

                                <td>{{ $val->year }}</td>

                                <td>{{ $val->description }}</td>

                                <td>{{ $val->genre }}</td>
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
