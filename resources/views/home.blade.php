@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                @if (Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @elseif($errors->all())
                <div class="alert alert-danger" role="alert">
                    <ul class="text-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                   @auth
                        {{ __('You are logged in!') }}
                   @else
                        <p class="text-danger">You are not logged in! please <a href="{{route('login')}}">login</a> to use the system!</p> 
                   @endauth
        </div>
        </div>
    </div>
</div>
@endsection
