@extends('layouts.admin.app')
@include('layouts.admin.sidebar')
@include('layouts.admin.header')
@section('home')
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Welcome back, Admin!
            </h1>
        </div>

        <div class="row">
            <div class="col-lg-4 col-xxl-6 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                        </div>
                        <h5 class="card-title mb-0">Monthly Users Register</h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chartjs-dashboard-user"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-6 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                        </div>
                        <h5 class="card-title mb-0">Monthly Subscription</h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chartjs-dashboard-subscriptions"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-6 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                        </div>
                        <h5 class="card-title mb-0">Monthly Guru Register</h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chartjs-dashboard-guru"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
        </div>
    </div>
</main>
@endsection
@php
    $userMonthString = '';
    $userCountString = '';
    foreach($userCount as $userCount){
        $userMonthString .= '"'. $userCount->monthname .'", ';
        $userCountString .= $userCount->count .', ';
    }

    $subscriptionMonthString = '';
    $subscriptionCountString = '';
    foreach($subscriptionCount as $subscriptionCount){
        $subscriptionMonthString .= '"'. $subscriptionCount->monthname .'", ';
        $subscriptionCountString .= $subscriptionCount->count .', ';
    }

    $guruMonthString = '';
    $guruCountString = '';
    foreach($guruCount as $guruCount){
        $guruMonthString .= '"'. $guruCount->monthname .'", ';
        $guruCountString .= $guruCount->count .', ';
    }
@endphp
@section('scripts')

<script>
    $(function() {
        // Bar chart
        new Chart(document.getElementById("chartjs-dashboard-user"), {
            type: 'bar',
            data: {
                labels: [{!! $userMonthString !!}],
                datasets: [{
                    label: "This year",
                    backgroundColor: window.theme.primary,
                    borderColor: window.theme.primary,
                    hoverBackgroundColor: window.theme.primary,
                    hoverBorderColor: window.theme.primary,
                    data: [{!! $userCountString !!}],
                    barPercentage: .75,
                    categoryPercentage: .5
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        stacked: false,
                        ticks: {
                            stepSize: 20
                        }
                    }],
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            color: "transparent"
                        }
                    }]
                }
            }
        });
        new Chart(document.getElementById("chartjs-dashboard-subscriptions"), {
            type: 'bar',
            data: {
                labels: [{!! $subscriptionMonthString !!}],
                datasets: [{
                    label: "This year",
                    backgroundColor: window.theme.primary,
                    borderColor: window.theme.primary,
                    hoverBackgroundColor: window.theme.primary,
                    hoverBorderColor: window.theme.primary,
                    data: [{!! $subscriptionCountString !!}],
                    barPercentage: .75,
                    categoryPercentage: .5
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        stacked: false,
                        ticks: {
                            stepSize: 20
                        }
                    }],
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            color: "transparent"
                        }
                    }]
                }
            }
        });
        new Chart(document.getElementById("chartjs-dashboard-guru"), {
            type: 'bar',
            data: {
                labels: [{!! $guruMonthString !!}],
                datasets: [{
                    label: "This year",
                    backgroundColor: window.theme.primary,
                    borderColor: window.theme.primary,
                    hoverBackgroundColor: window.theme.primary,
                    hoverBorderColor: window.theme.primary,
                    data: [{!! $guruCountString !!}],
                    barPercentage: .75,
                    categoryPercentage: .5
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        stacked: false,
                        ticks: {
                            stepSize: 20
                        }
                    }],
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            color: "transparent"
                        }
                    }]
                }
            }
        });
    });
</script>
@endsection
@include('layouts.admin.footer')