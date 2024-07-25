@extends('layouts.app')

@section('content')
    <div class="container-fluid px-8">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::route('home') }}"
                            class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Patients List</li>
                </ol>
            </nav>
        </div>
        <div class="row border-bottom">
            <h4 class="fc-vyepti-teal">Patients List </h4>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-body">

                        <!--added by Rizal for slide 23 --> 
                        <div class="row col-lg-6">
                            <Form class="form-inline" method="POST" action="{{ route('patientSummaryFilter') }}">
                                @csrf
                                <label>Filter by</label>
                                <select name="filter_by" id="ddlViewBy">
                                    <option value="0" @if(@$filter == 0) selected @endif>All patients</option>
                                    <option value="2" @if(@$filter == 2) selected @endif>Power On</option>
                                    <option value="1" @if(@$filter == 1) selected @endif>Non Power On</option>
                                </select>
                                <input type="submit" class="btn sm btn rounded-pill bc-vyepti-teal btn-vyepti-teal fc-vyepti-steel-20 w-10" value="Filter" />
                            </form>
                            <BR/><BR/><br/>
                        </div>
                        <!--end added by Rizal --> 

                        <table class="table table-bordered table-responsive-lg">
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Patient Code</th>
                                <th>Patient Name</th>
                                <th>#1</th>
                                <th>#2</th>
                                <th>#3</th>
                                <th>#4</th>
                                <th>Patient Created On</th>
                            </tr>
                            @foreach ($data as $b)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td class="text-center" width="10%">{{ $b->patient_code }}</td>
                                    <td width="35%">{{ $b->name }}
                                        @if ($b->services_type_id == 2)
                                            <img src="{{ asset('images/poweron_logo_only.svg') }}" width="30" />
                                        @endif
                                    </td>
                                    <td class="text-center" width="8%">{{ $b->one }}</td>
                                    <td class="text-center" width="8%">{{ $b->two }}</td>
                                    <td class="text-center" width="8%">{{ $b->three }}</td>
                                    <td class="text-center" width="8%">{{ $b->four }}</td>
                                    <td class="text-center" width="17%">{{ $b->patient_created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
