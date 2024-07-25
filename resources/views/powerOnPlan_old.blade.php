@extends('layouts.app')

@section('content')
    <div class="container-fluid px-8">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::route('home') }}"
                            class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Power-On Treatment Plan</li>
                </ol>
            </nav>
        </div>
        <div class="row border-bottom">
            <h4 class="fc-vyepti-teal">Power-On Treatment Plan </h4>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-xs-12 col-md-10 col-lg-8 col-xl-6 mb-5">
                <div class="card">
                    <div class="card-body m-0 p-0">
                        <form method="POST" action="{{ route('createPSP') }}">
                            @csrf
                            <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold"> Enroll For Power-On Treatment Plan </h5>
                            <hr class="m-0">
                            <div class="px-5 py-4">
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif

                                <div
                                    @if (auth()->user()->role_id == 4) class='row mb-3' @else class='row mb-3 d-none' @endif>
                                    <label for="clinic" class=" col-form-label text-md-right mt-0 pt-0">Clinic <span
                                            class="text-danger">*</span></label>
                                    <div class="col">
                                        <select class="form-select @error('clinic') is-invalid @enderror" id="clinic_id"
                                            name="clinic_id" required>
                                            <option value="">Please Select Clinic</option>
                                            @foreach ($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" data-psp_code="{{ $clinic->psp_code }}"
                                                    @if ($clinic->id == auth()->user()->clinic_id || $clinic->id == old('clinic_id')) selected @endif>
                                                    {{ '[' . $clinic->psp_code . '] ' . $clinic->name }}</option>
                                            @endforeach
                                        </select>
                                        <hr />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <h6 class="mt-0 fw-bold">PERSONAL INFORMATION </h6>
                                    <div class="col-md-12 mb-2">
                                        <label for="name" class=" col-form-label text-md-right mt-0 pt-0">Full Name
                                            <span class="text-danger">*</span></label>
                                        <div class="col ">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror "
                                                placeholder="Enter Full Name" name="name" value="{{ old('name') }}"
                                                required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                                        <label for="code" class=" col-form-label text-md-right pt-0">Patient's Code
                                            <span class="text-danger">*</span></label>
                                        <div class="col">
                                            <input id="code" type="text"
                                                class="form-control @error('code') is-invalid @enderror " name="code"
                                                value="" required autofocus readonly>

                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                                        <label for="nric" class=" col-form-label text-md-right pt-0">NRIC <span
                                                class="text-danger">*</span></label>
                                        <div class="col">
                                            <div class="input-group @error('l4_nric') is-invalid @enderror">
                                                <select id="fl_nric" name="fl_nric"
                                                    class="form-select text-center border border-dark"
                                                    style="max-width: 30%;">
                                                    <option value="S"
                                                        @if (old('fl_nric') == 'S') selected @endif>S
                                                    </option>
                                                    <option value="F"
                                                        @if (old('fl_nric') == 'F') selected @endif>F</option>
                                                </select>
                                                <input id="cl_nric" name="cl_nric" type="text"
                                                    class="form-control text-center @error('cl_nric') is-invalid @enderror"
                                                    style="max-width: 30%;" value="XXXX" readonly>
                                                <input id="l4_nric" name="l4_nric" type="text"
                                                    class="form-control @error('l4_nric') is-invalid @enderror"
                                                    placeholder="Last 4 digit(e.g. 123A)"
                                                    value="{{ old('l4_nric') }}" maxlength="4">
                                            </div>
                                            @error('l4_nric')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-xs-12 col-md-6 mx-auto">
                                        <div class="d-grid gap-0">
                                            <button class="btn rounded-pill btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                type="submit">SUBMIT</button>
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
    <script>
        $(document).ready(function() {
            var psp_code = $("#clinic_id").children("option:selected").data("psp_code");
            if (psp_code) {
                var count = '{{ sprintf('%04d', $count + 1) }}';
                $("#code").val(psp_code + "-" + count);
            }

            $("#clinic_id").change(function() {
                var psp_code = $(this).children("option:selected").data("psp_code");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('/') }}" + "/GetPatientCount",
                    data: {
                        clinic_id: $(this).children("option:selected").val()
                    },
                    type: "POST",
                    success: function(data) {
                        $("#code").val(psp_code + "-" + ('0'.repeat(4) + (Number(data) + 1))
                            .slice(-4));
                    },
                    error: function(request, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
