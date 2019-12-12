@extends('layouts.staff')
@section('title', 'Staff dashboard')

@section('page-heading')
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
@endsection

@section('page-content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Staffs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\User::where('role_id', 2)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tutors</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ App\User::where('role_id', 3)->count() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tutees</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\User::where('role_id', 4)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-6">

            <!-- avg -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Average number of messages for each personal tutor</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Messages</th>
                            <th>Tutees</th>
                            <th>Average</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse(\App\User::averageMessagesPerTutor() as $stat)
                            <tr>
                                <td>{{ $stat['name'] }}</td>
                                <td>{{ $stat['messages'] }}</td>
                                <td>{{ $stat['tutees'] }}</td>
                                <td>{{ $stat['avg'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td rowspan="4">No records found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-lg-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exeptional reports</h6>
                </div>
                <div class="card-body">
                    <div class="card border-left-warning py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Students without a personal tutor</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\User::studentsWithNoPersonalTutor() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-left-danger py-2 mt-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Students with no interaction for 7 days</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\User::studentsWithNoInteractionInNDays(7) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-bottom-danger py-2 mt-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Students with no interaction for 28 days</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\User::studentsWithNoInteractionInNDays(28) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
