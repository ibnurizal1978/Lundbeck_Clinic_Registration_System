@extends('layouts.app')

@section('content')

<div class="container-fluid px-8">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" ><a href="{{ URL::route('home') }}" class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Patients</li>
            </ol>
        </nav>
    </div>
    <div class="row border-bottom">
        <h4 class="fc-vyepti-teal">Manage Patients</h4>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-12 mb-5">
            <div class="card">
                <div class="card-body m-0 p-0">
                    @csrf
                    <!-- <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold">Users</h5>
                    <hr class="m-0"> -->
                    <div class="p-4">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 px-3 py 3">
                                <table id="table_id" class="table table-striped table-bordered table-sm pt-3">
                                    <thead>
                                        <tr>
                                            <th>Patient ID</th>
                                            <th>Created On</th>
                                            <th>Name</th>
                                            <th>NRIC</th>
                                            <th>Clinic</th>
                                            <th>Is PSP?</th>
                                            <th>Patient Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patients as $patient)
                                            <tr>
                                                <td>{{$patient->id}}</td>
                                                <td>{{date_format(date_create($patient->created_at),"d F Y H:i:s")}}</td>
                                                <td>{{$patient->name}}</td>
                                                <td>{{$patient->nric}}</td>
                                                <td>{{$patient->clinic_name}}</td>
                                                <!-- <td>{{$patient->psp_reg}}</td> -->
                                                <td>
                                                    @if($patient->psp_reg == 0)
                                                        {{ "No" }}
                                                    @else
                                                        {{ "Yes" }}
                                                    @endif
                                                </td>
                                                <td>{{$patient->patient_code}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js-script')
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script> -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.css') }}">
<script type="text/javascript" charset="utf8" src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready( function () {
        // $('#table_id').DataTable();
        $('#table_id').DataTable( {
            "lengthChange": false,
            // searching: false,
            // paging: false,
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }]
        });
    } );

</script>

@stop
