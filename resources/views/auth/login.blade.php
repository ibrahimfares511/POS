@php
$title = 'تسجيل دخول';
@endphp
@extends('layouts.login')

@section('content')
<div class="login-header">
    <div class="login-header-inner flex">
      <img class='rounded-circle' src="{{ URL('pos_style/images/route.jfif') }}" alt="Route">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class='form-inputs'>
            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder='UserName' required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class='form-inputs'>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder='Password' required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class='form-check-forget'>
            <div class='form-check'>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            @if (Route::has('password.request'))
                <a class="btn btn-link form-forget" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">
              {{ __('Login') }}
          </button>
        </div>
      </form>
    </div>

    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
      viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
      <defs>
        <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
      </defs>
      <g class="parallax">
        <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(75,119,190, 0.7)" />
        <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(42,180,192,0.5)" />
        <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(75,119,190, 0.3)" />
        <use xlink:href="#gentle-wave" x="48" y="7" fill="rgba(42,180,192,1)" />
      </g>
    </svg>
  </div>


@endsection
