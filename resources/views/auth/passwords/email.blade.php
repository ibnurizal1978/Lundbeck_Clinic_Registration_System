@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-8 col-lg-6 col-xxl-5">
            <img class="mx-auto d-block w-50" src="{{asset('images/poweron_logo_with_text.svg')}}" >
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-8 col-lg-6 col-xxl-5">
            <div class="card">
                <div class="card-body p-0 m-0">
                    <form method="POST" action="{{ route('auth.email') }}">
                        @csrf

                        <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold">{{ __('Forgot Password') }}</h5>
                        <hr class="m-0">

                        <div class="px-5 py-4">

                            @if(app('request')->has('success'))
                                <div class="alert alert-success btn-vyepti-steel-50">
                                    {{ "We have emailed your password reset link!" }}
                                </div>
                            @endif

                            <!-- @if(app('request')->has('failed'))
                                <div class="alert alert-danger">
                                    {{ "An error has been encountered. Please try again" }}
                                </div>
                            @endif -->

                            <div class="row mb-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class=" col-form-label text-md-right mt-0 pt-0" >{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-0">
                                <div class="col-sm-4 mb-3 mx-auto">
                                    <a href="{{ route('logout') }}" class="btn rounded-pill btn-vyepti-red-outline fc-vyepti-red w-100" >
                                        CANCEL
                                    </a>
                                </div>
                                <div class="col-sm-8 mb-3 mx-auto">
                                    <button class="btn rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100" type="submit">{{ __('SEND PASSWORD RESET LINK') }}</button>
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
