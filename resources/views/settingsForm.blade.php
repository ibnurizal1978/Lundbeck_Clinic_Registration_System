@extends('layouts.app')

@section('content')
<div class="container-fluid px-8">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><a href="{{ URL::route('home') }}" class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <h4 class="fc-vyepti-teal fw-bold">Settings</h4>
    </div>
    <hr>
    <div class="row justify-content-center pt-3">
        <div class="col-md-8">
            <div class="card mb-5">
                <h5 class="card-header pt-3 px-5 pb-3 fw-bold" style="color:#41748D; background-color:white; font-size:22px !important;">Edit Account</h5>

                <div class="card-body px-5">
                    <form method="POST" action="{{ route('update_settings') }}">
                        @csrf
                        <!-- success message -->
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class = "row">
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="username" class="col-12 col-form-label text-md-right" style="font-size:16px;">{{ __('New Username') }}</label>

                                <div class="col-12">
                                    <input id="username" type="username" name="username" placeholder="Enter New Username" class="form-control"
                                    >

                                    @error('username')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <h5 class="mt-3 fw-bold" style="font-size:16px!important;"> PASSWORD RESET </h5>
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="current_password" class="col-12 col-form-label text-md-right"style="font-size:16px;">{{ __('Old Password') }}</label>

                                <div class="col-12">
                                    <input id="current_password" type="text" placeholder="Enter Old Password" class="form-control" name="current_password" >

                                    @error('current_password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class=" row ">
                            <div class="col-12 col-lg-6 mb-3`" >
                                <label for="password" class="col-12 col-form-label text-md-right"style="font-size:16px;">{{ __('New Password') }}</label>

                                <div class="col-12">
                                    <input id="password" type="password" placeholder="Enter New Password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 mb-3">
                                <label for="password-confirm" class="col-12 col-form-label text-md-right"style="font-size:16px;">{{ __('Confirm Password') }}</label>

                                <div class="col-12">
                                    <input id="password-confirm" placeholder="Enter New Password Confirmation" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                    @error('password_confirmation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="text-center">
                                <button type="submit" class="btn btn-dark rounded-pill mt-3 shadow mb-3" style="background-color:#41748D !important; border:none; width:170px;">
                                    {{ __('SUBMIT') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
