@extends('layouts.app')
@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Clinics</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('clinics.create') }}"> Create New Clinic</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>            
            <th>Status</th>            
            <th width="280px">Action</th>
        </tr>
        @foreach ($clinics as $clinic)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $clinic->name }}</td>            
            <td>{{ $clinic->status }}</td>     
            <td>{{ $clinic->address }}</td>    
            <td>
                <form action="{{ route('clinics.destroy',$clinic->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('clinics.show',$clinic->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('clinics.edit',$clinic->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $clinics->links() !!}

@endsection