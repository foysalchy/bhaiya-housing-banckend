@extends('layouts.backend')

@section('content')
<style>
    #main{
        background:black
    }
</style>
<div class="container " style="margin-top:10%;background:black">
    <div class="row justify-content-center">
        <div class="col-md-8 pt-12 text-center" style="color:white">
            <img src="{{ asset('/') }}{{ $setting->img_path ?? '' }}" alt="" style="max-width:150px; margin-bottom:20px;">

            @if(Auth::check())
                <h3 class="mt-3">Welcome Back, {{ Auth::user()->name }} 👋</h3>
                <p class="text-">
                    You are successfully logged in.  
                    Manage your content, explore new features, and keep your dashboard organized.
                </p>
                <p class="font-semibold">
                    Have a productive day!
                </p>
            @else
                <h3 class="mt-3">Welcome to Your Dashboard 👋</h3>
                <p class="text- ">
                    Please log in to access your personalized dashboard and manage your account.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
