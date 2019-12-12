@extends('layouts.admin')
@section('title', 'Admin dashboard')

@section('page-heading')
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
@endsection

@section('page-content')
    <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c1">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <i class="zmdi zmdi-email"></i>
                        </div>
                        <div class="text">
                            <h2>{{ App\Chat::lastNDaysMessage(7) }}</h2>
                            <span>Chats in the last 7 days</span>
                        </div>
                    </div>
                    <div class="overview-chart">
                        <canvas id="widgetChart1"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c2">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <i class="zmdi zmdi-folder-person"></i>
                        </div>
                        <div class="text">
                            <h2>{{ App\User::studentsWithNoPersonalTutor() }}</h2>
                            <span>Students without a personal tutor</span>
                        </div>
                    </div>
                    <div class="overview-chart">
                        <canvas id="widgetChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c3">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <i class="zmdi zmdi-folder-person"></i>
                        </div>
                        <div class="text">
                            <h2>{{ App\User::studentsWithNoInteractionInNDays(7) }}</h2>
                            <span>Students with no interaction for 7 days</span>
                        </div>
                    </div>
                    <div class="overview-chart">
                        <canvas id="widgetChart3"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c4">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                            <i class="zmdi zmdi-folder-person"></i>
                        </div>
                        <div class="text">
                            <h2>{{ App\User::studentsWithNoInteractionInNDays(7) }}</h2>
                            <span>Students with no interaction for 28 days</span>
                        </div>
                    </div>
                    <div class="overview-chart">
                        <canvas id="widgetChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="title-1 m-b-25">Average number of messages for each personal tutor</h2>
        <div class="table-responsive table--no-card m-b-40">
            <table class="table table-borderless table-striped table-earning">
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
@endsection
