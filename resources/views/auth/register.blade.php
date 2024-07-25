@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-8 col-lg-6 col-xxl-5">
            <img class="mx-auto d-block w-50" src="{{asset('images/poweron_logo_with_text.svg')}}" >
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
            <div class="card">
                <div class="card-body p-0 m-0">
                    <form method="POST" action="{{ route('register') }}" id="signup_form" class="">
                        @csrf
                        <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold"> Register User </h5>
                        <hr class="m-0">
                        <div class="px-5 py-4">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <div class="row mb-3">
                                <h6 class="mt-0 fw-bold">PERSONAL INFORMATION </h6>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="role_clinic" value="1" name="role" @if(old("role") == "1" || old("role") == "") checked @endif >
                                        <label class="form-check-label" for="role_clinic">Clinic</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="role_nurse" value="2" name="role" @if(old("role") == "2") checked @endif >
                                        <label class="form-check-label" for="role_nurse">Nurse Agency</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="role_staff" value="3" name="role" @if(old("role") == "3") checked @endif >
                                        <label class="form-check-label" for="role_staff">Lundbeck Staff</label>
                                    </div>
                                </div>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class=" col-form-label text-md-right mt-0 pt-0" >Full Name <span class="text-danger">*</span></label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror " placeholder="Enter Full Name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-6 mb-3">
                                    <label for="email" class=" col-form-label text-md-right pt-0">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                    <div class="col ">
                                        <input id="email" type="email" placeholder="Enter Email Address" class="w-90 form-control @error('email') is-invalid @enderror " name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-lg-6 mb-3">
                                    <label for="contactnumber" class="col-form-label text-md-right pt-0">Contact Number <span class="text-danger">*</span></label>
                                    <div class="col">
                                        <input id="contactnumber" type="text" placeholder="8XXXXXXX" class="w-90 form-control @error('contactnumber') is-invalid @enderror " name="contactnumber" value="{{ old('contactnumber') }}" required>
                                        @error('contactnumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col m-0">
                                    <div class="form-check">
                                        <input id="receive" type="checkbox" class="form-check-input" name="receive">
                                        <label for="receive" class="form-check-label text-justify lh-sm">
                                            <small>I would like to receive updates and notifications via email and SMS.</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 clinic_name" style={{ (old("role") == "3") ? 'display:none' : '' }}>
                                <div class="col-12">
                                    <label for="clinic" class=" col-form-label text-md-right mt-0 pt-0" >Clinic <span class="text-danger">*</span></label>
                                    <select class="form-select @error('clinic') is-invalid @enderror" id="clinic" name="clinic" required>
                                        <option value="">Please Select Clinic</option>
                                        @foreach($clinics as $clinic)
                                            <option value="{{$clinic->id}}" data-address="{{$clinic->address}}" data-customer="{{$clinic->customer_name}}" @if(old("clinic") == $clinic->id) selected @endif >{{$clinic->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('clinic')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 clinic_customer" style={{ (old("role") == "3") ? 'display:none' : '' }}>
                                <div class="col-12">
                                    <label for="customer" class=" col-form-label text-md-right mt-0 pt-0" >Customer</label>
                                    <input id="customer" type="text"  class="form-control" name="customer" value="{{ old("customer") }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3 clinic_address" style={{ (old("role") == "3") ? 'display:none' : '' }}>
                                <div class="col-12">
                                    <label for="address" class=" col-form-label text-md-right mt-0 pt-0" >Address</label>
                                    <!-- <input id="address" type="text"  class="w-90 form-control @error('email') is-invalid @enderror " name="address" value="" readonly> -->
                                    <textarea class="form-control" placeholder="" id="address" name="address" readonly>{{ old("address") }}</textarea>

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <h6 class="mt-0 fw-bold">ACCOUNT DETAILS </h6>
                                <div class="col-md-12 col-sm-12 col-lg-6 mb-1">
                                    <label for="password" class=" col-form-label text-md-right pt-0">Password <span class="text-danger">*</span></label>
                                    <div class="col">
                                        <input id="password" placeholder="Enter Password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                                    <label for="password-confirm" class=" col-form-label text-md-right pt-0">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="col">
                                        <input id="password-confirm" type="password" placeholder="Enter Password Again" class="form-control" name="password_confirmation" required >
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col m-0">
                                    <div class="form-check">
                                        <input id="consent" type="checkbox" class="form-check-input" name="consent" required>
                                        <label for="consent" class="form-check-label text-justify lh-sm">
                                            <small>I consent to the collection, use and processing of the personal data I have provided above and I further acknowledge that I have read and agree to the <a class="fc-hyperlink-blue text-decoration-none" href="/files/Vyepti-Poweron-Privacy-Policy.pdf" target="_blank">Privacy Policy</a> and <a class="fc-hyperlink-blue text-decoration-none" href="/files/Vypeti-Poweron-Terms-of-Use.pdf" target="_blank">Terms of Use</a>.</small>
                                        </label>
                                        @error('consent')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-sm-6 mb-3 mx-auto">
                                    <a href="{{ route('login')}}" class="btn rounded-pill btn-vyepti-red-outline fc-vyepti-red w-100" >
                                        CANCEL
                                    </a>
                                </div>
                                <div class="col-sm-6 mb-3 mx-auto">
                                    <button class="btn rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100" type="submit">SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("input[type=radio][name=role]").change(function() {
            $("#clinic").prop('required', true);
            $("#clinic").val("").trigger('change');
            switch(this.value) {
                case "1":
                    $(".clinic_name").show();
                    $(".clinic_customer").show();
                    $(".clinic_address").show();
                    break;
                case "2":
                    // $(".clinic_name").show();
                    // $(".clinic_address").hide();

                    $("#clinic").val(29).trigger('change');
                    $(".clinic_name").hide();
                    $(".clinic_customer").hide();
                    $(".clinic_address").hide();
                    break;
                case "3":
                    $(".clinic_name").hide();
                    $(".clinic_customer").hide();
                    $(".clinic_address").hide();
                    $("#clinic").val($("#clinic option:last").val());
                    break;
            }
        });

        $("#clinic").change(function() {
            if($("input[type=radio][name=role]:checked").val() != "2" && $("#clinic").val() == 29) {
                $("#clinic").val("").trigger('change');
            } else {
                var address = $(this).children('option:selected').data('address');
                $("#address").val(address);

                var customer = $(this).children('option:selected').data('customer');
                $("#customer").val(customer);
            }
        });
    });

</script>

@endsection
