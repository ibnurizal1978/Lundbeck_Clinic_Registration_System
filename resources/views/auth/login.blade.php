@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-md-8 col-lg-6 col-xxl-5">
                <img class="mx-auto d-block w-50" src="{{ asset('images/poweron_logo_with_text.svg') }}">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-md-8 col-lg-6 col-xxl-5">
                <div class="card">
                    <div class="card-body p-0 m-0">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold"> Log In </h5>
                            <hr class="m-0">
                            <div class="px-5 py-4">
                                <!-- if account isn't approved -->
                                @if (session()->has('message'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endif

                                <!-- after password reset -->
                                @if (app('request')->has('success'))
                                    <div class="alert alert-success btn-vyepti-steel-50">
                                        {{ 'Your password has been reset! You can now login.' }}
                                    </div>
                                @endif

                                <div class="row mb-3 ">
                                    <div class="form-group ">
                                        <label for="email" class="mb-2">{{ __('Email Address') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row mb-1">
                                    <div class="form-group">
                                        <label for="password" class="mb-2">{{ __('Password') }}</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <label>
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link fc-hyperlink-blue p-0 text-decoration-none"
                                                href="{{ route('password.request') }}">
                                                {{ __('Forgot Password?') }}
                                            </a>
                                        @endif
                                    </label>
                                </div>
                                <div class="row mb-0 mt-4 ">
                                    <div class="col-xs-12 col-md-6 mx-auto">
                                        <div class="d-grid gap-0">
                                            <button class="btn rounded-pill btn-vyepti-teal fc-vyepti-steel-20"
                                                type="submit">LOG IN</button>
                                        </div>
                                    </div>
                                    <div class="col-12 mx-auto text-center">
                                        <div class="d-grid gap-0">
                                            <a class="nav-link text-muted" href="{{ route('register') }}">Don't have an
                                                account? <span class="fc-hyperlink-blue"> Sign up </span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
