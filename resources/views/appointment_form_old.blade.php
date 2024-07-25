@extends('layouts.app')

@section('content')
    <style>

    </style>

    <div class="container-fluid px-8">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::route('home') }}"
                            class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Infusion Appointment</li>
                </ol>
            </nav>
        </div>
        <div class="row border-bottom">
            <h4 class="fc-vyepti-teal">Infusion Appointment </h4>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-xs-12 col-md-10 col-xl-8 mb-5">
                <div class="card">
                    <div class="card-body m-0 p-0">
                        <form method="POST" action="{{ route('make_appointment') }}">
                            @csrf
                            <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold">Add New Infusion Appointment</h5>
                            <hr class="m-0">
                            <div class="px-5 py-4">
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif

                                <div
                                    @if (auth()->user()->role_id == 4 || auth()->user()->role_id == 5) class='row mb-3' @else class='row mb-3 d-none' @endif>
                                    <label for="clinic" class=" col-form-label text-md-right mt-0 pt-0">Clinic <span
                                            class="text-danger">*</span></label>
                                    <div class="col">
                                        <select class="form-select @error('clinic') is-invalid @enderror" id="clinic"
                                            name="clinic" required>
                                            <option value="">Please Select Clinic</option>
                                            @foreach ($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" data-address="{{ $clinic->address }}"
                                                    data-psp_code="{{ $clinic->psp_code }}"
                                                    @if ($clinic->id == auth()->user()->clinic_id || $clinic->id == old('clinic')) selected @endif>
                                                    {{ '[' . $clinic->psp_code . '] ' . $clinic->name }}</option>
                                            @endforeach
                                        </select>
                                        <hr />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <h6 class="mt-0 fw-bold">APPOINTMENT DETAILS</h6>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input patient_status" type="radio" id="existing"
                                                value="existing" name="patient_status"
                                                @if (old('patient_status') == 'existing' || old('patient_status') == '') checked @endif>
                                            <label class="form-check-label" for="existing">Existing Patient</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input patient_status" type="radio" id="new"
                                                value="new" name="patient_status"
                                                @if (old('patient_status') == 'new') checked @endif>
                                            <label class="form-check-label" for="new">New Patient</label>
                                        </div>
                                    </div>

                                    @error('patient_status')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-3" id="patient_new">
                                    <div class="col">
                                        <div class="row mb-3">
                                            <div class="col-md-12 mb-2">
                                                <label for="name"
                                                    class="col-form-label text-md-right pt-0 fw-bold">Patient's Name <span
                                                        class="text-danger">*</span></label>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror "
                                                    placeholder="Enter Patient Name" name="name"
                                                    value="{{ old('name') }}" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                                                <label for="code"
                                                    class="col-form-label text-md-right pt-0 fw-bold">Patient's Code <span
                                                        class="text-danger">*</span></label>
                                                <input id="code" type="text"
                                                    class="form-control @error('code') is-invalid @enderror "
                                                    placeholder="Enter Patient Code" name="code"
                                                    value="{{ old('code') }}" readonly>
                                            </div>

                                            <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                                                <label for="l4_nric" class="col-form-label text-md-right pt-0 fw-bold">NRIC
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group @error('l4_nric') is-invalid @enderror">
                                                    <select id="fl_nric" name="fl_nric"
                                                        class="form-select text-center border border-dark"
                                                        style="max-width: 25%;">
                                                        <option value="S"
                                                            @if (old('fl_nric') == 'S') selected @endif>S
                                                        </option>
                                                        <option value="F"
                                                            @if (old('fl_nric') == 'F') selected @endif>F</option>
                                                    </select>
                                                    <input id="cl_nric" name="cl_nric" type="text"
                                                        class="form-control text-center @error('cl_nric') is-invalid @enderror"
                                                        style="max-width: 25%;" value="XXXX" readonly>
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
                                </div>

                                <div class="row mb-4" id="patient_existing">
                                    <div class="col-12">
                                        <label for="existing_patient"
                                            class=" col-form-label text-md-right pt-0 fw-bold">Patient's
                                            Name <span class="text-danger">*</span></label>
                                        <select class="form-select @error('existing_patient') is-invalid @enderror"
                                            id="existing_patient" name="existing_patient">
                                            <option value="">Please Select Patient</option>
                                        </select>
                                        @error('existing_patient')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="patient_id" id="patient_id" value="1">
                                <input type="hidden" name="appointment_id" value="1">
                                <input type="hidden" name="treatment_id" value="1">
                                <input type="hidden" name="clinic_id" value="{{ Auth::user()->clinic_id }}">

                                <div class="row mb-2">
                                    {{-- <h6 class="mt-0 fw-bold">TREATMENT DETAILS</h6> --}}
                                    <div class="col-xs-12 col-lg-3">
                                        <label for="treatment" class="col-form-label text-md-right fw-bold">Dosage <span
                                                class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('treatment') is-invalid @enderror"
                                            id="treatment" name="treatment" required>
                                            @foreach ($treatments as $treatment)
                                                <option value="{{ $treatment->name }}"
                                                    @if ($treatment->name == old('treatment')) selected @endif>
                                                    {{ $treatment->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-lg-9">
                                        <label class="col-12 col-form-label text-md-right fw-bold">Location <span
                                                class="text-danger">*</span></label>
                                        <div>
                                            <label id="address" name="address"></label>
                                            <input type="hidden" id="location" name="location" value="">
                                        </div>
                                        @error('treatment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-xs-12 col-md-12 col-lg-6">
                                        <label class="col-md-4 col-form-label text-md-right fw-bold">Select Date <span
                                                class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <input class="form-control datepicker me-1" id="date" name="date"
                                                placeholder="DD-MM-YYYY" required>
                                        </div>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-xs-12 col-md-12 col-lg-6 mb-2" id="select-times"
                                        style="display:none;">
                                        <label for="times" class="col-md-4 col-form-label text-md-right fw-bold">Select
                                            Time <span class="text-danger">*</span></label>
                                        {{-- <div class="row apt_time m-0 p-0" id="weekdays">
                                            <label class="p-0 mb-1" style="font-size:80%;">Monday - Friday</label> --}}

                                        <select
                                            class="form-select weekday_slot time_slot @error('time') is-invalid @enderror"
                                            name="time" id="weekdays_time">
                                            <option value="">Please Select Time</option>
                                            @foreach ($weekdays_times as $weekdays_time)
                                                <option value="{{ $weekdays_time->times_id }}">
                                                    {{ $weekdays_time->times }}</option>
                                            @endforeach
                                        </select>
                                        {{-- </div> --}}

                                        {{-- <div class="row apt_time m-0 p-0" id="saturdays" disabled>
                                            <label class="p-0 col-4 mb-1" style="font-size:80%;"> Saturday </label> --}}

                                        <select
                                            class="form-select saturday_slot time_slot @error('time') is-invalid @enderror"
                                            name="time" id="weekends_time">
                                            <option value="">Please Select Time</option>
                                            @foreach ($weekends_times as $weekends_time)
                                                <option value="{{ $weekends_time->times_id }}">
                                                    {{ $weekends_time->times }}</option>
                                            @endforeach
                                        </select>
                                        {{-- </div> --}}
                                        @error('time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-xs-12 col-md-6 mx-auto">
                                        <div class="d-grid gap-0">
                                            <button
                                                class="btn rounded-pill bc-vyepti-teal btn-vyepti-teal fc-vyepti-steel-20 w-100"
                                                type="submit">ADD NEW APPOINTMENT</button>
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
        // list of patients from database
        var patients = [];
        @foreach ($patients as $patient)
            var temp = {
                "id": "{{ $patient->id }}",
                "name": "{{ $patient->name }}",
                "clinic_id": "{{ $patient->clinic_id }}"
            }
            patients.push(temp);
        @endforeach

        @if (old('patient_status') == 'new')
            // initially hide div[patient_new]
            $("#patient_new").show();
            $("#patient_existing").hide();
        @else
            $("#patient_new").hide();
            $("#patient_existing").show();
        @endif

        // existing patient or new patient
        $("input[type=radio][name=patient_status]").change(function() {
            if (this.value == "new") {
                $("#patient_new").show();
                $("#patient_existing").hide();
            } else {
                $("#patient_new").hide();
                $("#patient_existing").show();
            }
        });

        //date picker
        $('.datepicker').datepicker({
            dateFormat: "dd-mm-yy",
            showOn: "button",
            buttonText: "<i class='fa fa-calendar fa-lg'></i>",
            minDate: 0, //disable past dates
            beforeShowDay: function(date) { //disable sundays
                var day = date.getDay();
                return [(day != 0), ''];
            },
        }).next(".ui-datepicker-trigger").addClass("btn btn-vyepti-teal fc-vyepti-steel-20");

        // set the enabling and disabling of times
        $("#date").on("change", function() {
            var selected_date = $(this).val();
            var selected_date_parts = selected_date.split('-');

            // uncheck all time selections
            $(".time_slot option:selected").prop("selected", false)

            // get the day of the week (0 - Sunday, 1 - Monday, ..)
            var day_of_the_week = moment(selected_date_parts[2] + '-' + selected_date_parts[0] + '-' +
                selected_date_parts[1], "YYYY-DD-MM").day();
            // day_of_the_week = new Date(selected_date);
            if (day_of_the_week != 6) { // weekday (Sunday is disabled)
                $("#select-times").show();
                $("#weekdays_time").attr('name', 'time')
                $("#weekdays_time").show();
                $("#weekends_time").attr('name', 'weekends_time')
                $("#weekends_time").hide();

                $('.time_slot option').removeAttr('disabled');
                $('.weekday_slot option').each(function() {
                    if (this.value !== '' && moment().format('DD-MM-YYYY') === selected_date) {
                        var times_selected = this.value.split('-');
                        var times_selected_1 = moment(times_selected[0].trim(), 'HH:mm');
                        var times_selected_2 = moment(times_selected[1].trim(), 'HH:mm');
                        var currenthour = moment();
                        if (moment.duration(times_selected_1.diff(currenthour)).asHours() < 2) {
                            $(this).attr("disabled", true);
                        }
                    }
                });

                $(".saturday_slot").prop("disabled", true);
                $(".weekday_slot").prop("disabled", false);
            } else { // saturday
                $("#select-times").show();
                $("#weekdays_time").attr('name', 'weekdays_time')
                $("#weekdays_time").hide();
                $("#weekends_time").attr('name', 'time')
                $("#weekends_time").show();

                $('.time_slot option').removeAttr('disabled');
                $('.saturday_slot option').each(function() {
                    if (this.value !== '' && moment().format('DD-MM-YYYY') === selected_date) {
                        var times_selected = this.value.split('-');
                        var times_selected_1 = moment(times_selected[0].trim(), 'HH:mm');
                        var times_selected_2 = moment(times_selected[1].trim(), 'HH:mm');
                        var currenthour = moment();
                        if (moment.duration(times_selected_1.diff(currenthour)).asHours() < 2) {
                            $(this).attr("disabled", true);
                        }
                    }
                });

                $(".saturday_slot").prop("disabled", false);
                $(".weekday_slot").prop("disabled", true);
            }
        });

        $(document).ready(function() {
            var address = $("#clinic").children("option:selected").data("address");
            if (address) {
                $("#address").html(address);
                $("#location").val($("#clinic").val());

                // patients
                $.each(patients, function(index, value) {
                    if (value.clinic_id == $("#clinic").val()) {
                        $('#existing_patient')
                            .append($("<option></option>")
                                .attr("value", value.id)
                                .text(value.name));
                    }
                });
            }

            $("#clinic").change(function() {
                var address = $(this).children("option:selected").data("address");

                $("#address").html(address);
                $("#location").val($("#clinic").val());

                // patients
                $('#existing_patient option:not(:first)').remove();
                $.each(patients, function(index, value) {
                    if (value.clinic_id == $("#clinic").val()) {
                        $('#existing_patient')
                            .append($("<option></option>")
                                .attr("value", value.id)
                                .text(value.name));
                    }
                });

                var psp_code = $(this).children("option:selected").data("psp_code");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                console.log($("#clinic").val());
                $.ajax({
                    url: "{{ url('/') }}" + "/GetPatientCount",
                    data: {
                        clinic_id: $("#clinic").val()
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

            var psp_code = $("#clinic").children("option:selected").data("psp_code");
            if (psp_code) {
                if ($("#clinic").val()) {
                    $("#clinic").trigger("change");
                }
                var count = '{{ sprintf('%04d', $patient_count + 1) }}';
                $("#code").val(psp_code + "-" + count);
            }
        });
    </script>
@endsection
