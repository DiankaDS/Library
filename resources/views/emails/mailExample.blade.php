{{--@extends('layouts.app')--}}

{{--@section('content')--}}
<div class="container">

    Hello {{ $name }} {{ $surname }}, I want to take your book!
    Please, accept or reject this order <a href='http://localhost:8000/orders_to_user'>here</a>.

    Best regards, {{ Auth::user()->name }} {{ Auth::user()->surname }}
        e-mail: {{ Auth::user()->email }}
        phone: {{ Auth::user()->phone }}

</div>
{{--@endsection--}}
