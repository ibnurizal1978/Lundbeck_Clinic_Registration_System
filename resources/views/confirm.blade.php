@extends('layouts.app')
@section('content')

<div class="container-fluid px-8">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><a href="{{ URL::route('home') }}" class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Confirm Appointment</li>
            </ol>
        </nav>
    </div>
    <div class="row border-bottom">
        <h4 class="fc-vyepti-teal">Confirm Appointment</h4>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-xs-12 col-md-10 col-xl-8 mb-5">
            <div class="card">
                <div class="card-body m-0 p-0">
                    <form id="formConfirm" method="POST" action="{{ route('confirm_appointment') }}">
                        @csrf
                        <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold">Confirm Infusion Appointment</h5>
                        <hr class="m-0">
                        <div class="px-5 py-4">
                            @if(session()->has('message'))
                                <div class="alert alert-success btn-vyepti-steel-50">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="row mb-2">
                                <h6 class="mt-0 fw-bold">APPOINTMENT DETAILS</h6>
                                <label class="col-form-label text-md-right pt-1 fw-bold">Clinic Name </label>
                                <label class="fc-vyepti-teal">{{ $session->clinic }}</label>
                            </div>
                            <div class="row mb-1">
                                <h6 class="mt-0 fw-bold">TREATMENT DETAILS</h6>
                                <div class="col-xs-12 col-lg-3">
                                    <label for="password" class="col-form-label text-md-right fw-bold pt-1">Treatment </label>
                                    <div>
                                        <label class="fc-vyepti-teal">{{ $session->treatment }}</label>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-9">
                                    <label class="col-md-4 col-form-label text-md-right fw-bold pt-1">Location </label>
                                    <div>
                                        <label class="fc-vyepti-teal">{{ $session->address }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-xs-12 col-lg-6">
                                    <label class="col-md-4 col-form-label text-md-right fw-bold pt-1">Select Date </label>
                                    <div class="d-flex">
                                        <label class="fc-vyepti-teal">{{ Carbon\Carbon::createFromFormat('m-d-Y', $session->session_date)->format('l, F d, Y'); }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12">
                                    <label class="col-md-4 col-form-label text-md-right fw-bold pt-1">Select Time </label>
                                    <div class="d-flex">
                                        <label class="fc-vyepti-teal">{{ $session->time_start . ' - ' . $session->time_end }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <label class="col-md-4 col-form-label text-md-right fw-bold pt-1">Status</label>
                                    <div class="d-flex">
                                        <label class="fc-vyepti-teal">
                                        @switch($session->status)
                                            @case('0')
                                                Pending
                                                @break
                                            @case('1')
                                                Accepted
                                                @break
                                            @case('2')
                                                Completed
                                                @break
                                            @default
                                                Rejected
                                        @endswitch
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="appointment_id" id="appointment_id" value="{{ $session->appointment_id }}">
                            <input type="hidden" name="session_id" id="session_id" value="{{ $session->session_id }}">
                            <input type="hidden" name="token" id="token" value="{{ $session->token }}">

                            @if($session->status == '0')
                            <div class="row mx-0 mt-4 px-0 text-center">
                                <div class="col-12 col-sm-6 mb-3 mx-auto">
                                    <button class="btn rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100" name="status" value="1" type="submit">ACCEPT</button>
                                </div>
                                <div class="col-12 col-sm-6 mb-3 mx-auto">
                                    <button class="btn rounded-pill btn-vyepti-red-outline fc-vyepti-red w-100" name="status" value="-1" type="submit">REJECT</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#formConfirm').submit(function(event){
        if(!confirm("Please click OK to confirm.")){
            event.preventDefault();
        }
    });
</script>
@endsection
