@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Coversheet</h2>
            </div>
            <div class="pull-right">
            <!-- <a class="btn btn-success" href="{{ route('batches.create') }}"> Create New Batch</a> -->
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p></p>
        </div>
    @endif
    
    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>No</th>
            <th>batch_number</th>
            <th>location_id</th>
        </tr>
        @foreach ($patient as $b)
            <tr>
            <td>{{ $b->id }}</td>
            <td>{{ $b->batch_number }}</td>
            <td>{{ $b->location_id }}</td>                  
        
            </tr>
        @endforeach
    </table>
    

@endsection