@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">


        <div class="col-md-4">
            <input class="form-control" id="mySearch" type="text" placeholder="Quick search">
        </div>
    </div>
    <br>

    <div class="row">
        <div class="panel panel-default">
                <div class="panel-heading">Library</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{--You are logged in!--}}
                        <div class="filterable">

                        <table class="table">
                            <thead>
                            <tr class="filters">
                                <th scope="col">Book name<input type="text" class="form-control" placeholder="Search name"></th>
                                <th scope="col">Author<input type="text" class="form-control" placeholder="Search author"></th>
                                <th scope="col">Year<input type="text" class="form-control" placeholder="Search year"></th>
                                <th scope="col">Genre<input type="text" class="form-control" placeholder="Search genre"></th>
                                <th scope="col">Rating<input type="text" class="form-control" placeholder="Search rating"></th>
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach ($books as $val)
                            <tr>
                                <td>
                                    <a href="book_{{ $val->id }}" name="{{ $val->id }}">{{ $val->name }}</a>
                                </td>

                                <td>{{ $val->author }}</td>
                                <td>{{ $val->year }}</td>
                                <td>{{ $val->genre }}</td>

                                <td>
                                    @if($val->rating)
                                        {{ $val->rating }}
                                    @else
                                        0
                                    @endif
                                </td>
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
