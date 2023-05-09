@extends('layout')
@section('title', 'Home')
@section('content')

<div class="container">
    <div class="mt-5">
        
        <x-alert type="success" :session="session('success')"/>

        <h1>Welcome</h1>
        @if (Auth::user())
            <h3>Nome: {{  Auth::user()->nome  }}</h3>
            <img src="{{asset(Auth::user()->foto)}}" alt="User Photo" width="100" height="100">
        @endif

    </div>
    
</div>

@endsection