@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Profile</h1>
            
            <table class="table">
                <tbody>
                <tr>
                    <th>Username</th>
                    <td>{{ $user_info['username'] }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user_info['name'] }}</td>
                </tr>
                <tr>
                    <th>Surname</th>
                    <td>{{ $user_info['surname'] }}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>{{ $user_info['email'] }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user_info['phone'] }}</td>
                </tr>
                </tbody>
            </table>


        </div>
    </div>
</div>
@endsection
