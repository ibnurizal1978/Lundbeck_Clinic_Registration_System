@extends('layouts.app')

@section('content')

    <div class="container-fluid px-8">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::route('home') }}"
                            class="fc-hyperlink-blue text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
                </ol>
            </nav>
        </div>
        <div class="row border-bottom">
            <h4 class="fc-vyepti-teal">Manage Users</h4>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-12 mb-5">
                <div class="card">
                    <div class="card-body m-0 p-0">
                        @csrf
                        <!-- <h5 class="mx-0 my-2 px-5 py-3 fc-vyepti-teal fw-bold">Users</h5>
                        <hr class="m-0"> -->
                        <div class="p-4">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-12 px-3 py 3">
                                    <table id="table_id" class="table table-striped table-bordered table-sm pt-3">
                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th class="no-sort">Receive Notification</th>
                                                <th class="no-sort">Enable</th>
                                                <!-- <th class="no-sort">&nbsp;</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @if ($user->role_id == 1)
                                                            {{ 'Clinic' }}
                                                        @elseif($user->role_id == 2)
                                                            {{ 'Nurse Agency' }}
                                                        @elseif($user->role_id == 3)
                                                            {{ 'Lundbeck Staff' }}
                                                        @elseif($user->role_id == 5)
                                                            {{ 'Sales Person Staff' }}
                                                        @else
                                                            {{ 'Admin' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->receive == 0)
                                                            <form method="POST" action="{{ route('to_notify_user') }}">
                                                                @csrf
                                                                <input type="hidden" value="{{ $user->id }}"
                                                                    name="id">
                                                                <input type="hidden" value="1" name="notify">
                                                                <button type="submit" value="Approve" title="Approve"
                                                                    class="btn btn-sm btn-vyepti-steel fc-vyepti-teal-20
                                                            d-flex justify-content-center align-items-center mx-auto px-1">
                                                                    <i class="material-icons fs-5">notifications</i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('to_notify_user') }}">
                                                                @csrf
                                                                <input type="hidden" value="{{ $user->id }}"
                                                                    name="id">
                                                                <input type="hidden" value="0" name="notify">
                                                                <button type="submit" value="Disable" title="Reject"
                                                                    class="btn btn-sm btn-vyepti-red fc-vyepti-teal-20
                                                            d-flex justify-content-center align-items-center mx-auto px-1">
                                                                    <i class="material-icons fs-5">notifications_off</i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->status == 0)
                                                            <form method="POST" action="{{ route('enable_user') }}">
                                                                @csrf
                                                                <input type="hidden" value="{{ $user->id }}"
                                                                    name="id">
                                                                <button type="submit" value="Approve" title="Approve"
                                                                    class="btn btn-sm btn-vyepti-steel fc-vyepti-teal-20
                                                            d-flex justify-content-center align-items-center mx-auto px-1">
                                                                    <i class="material-icons fs-5">thumb_up_off_alt</i>
                                                                    <!-- <small class="text-uppercase">Approve</small> -->
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('disable_user') }}">
                                                                @csrf
                                                                <input type="hidden" value="{{ $user->id }}"
                                                                    name="id">
                                                                <button type="submit" value="Disable" title="Reject"
                                                                    class="btn btn-sm btn-vyepti-red fc-vyepti-teal-20
                                                            d-flex justify-content-center align-items-center mx-auto px-1">
                                                                    <i class="material-icons fs-5">thumb_down_off_alt</i>
                                                                    <!-- <small class="text-uppercase">Cancel</small> -->
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>

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
        $(document).ready(function() {
            // $('#table_id').DataTable();
            $('#table_id').DataTable({
                "lengthChange": false,
                // searching: false,
                // paging: false,
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });
        });
    </script>

@stop
