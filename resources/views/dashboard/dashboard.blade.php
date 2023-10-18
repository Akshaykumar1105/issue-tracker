@extends('dashboard.layout.dashboard_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->


    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                {{-- {{$data[]}} --}}

                @if (isset($data['user']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['user'] }}</h3>
                                <p>All User</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('admin.hr.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (isset($data['manager']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $data['manager'] }}</h3>
                                <p>Total Managers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            @if (auth()->user()->hasRole('hr'))
                                <a href="{{ route('hr.manager.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @else
                                <a href="{{ route('admin.hr.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                @endif

                @if (isset($data['issue']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['issue'] }}</h3>
                                <p>Total Issues</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            @if (auth()->user()->hasRole('hr'))
                                <a href="{{ route('hr.issue.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @else
                                <a href="{{ route('admin.issue.index') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                @endif

                @if (isset($data['company']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['company']->count() }}</h3>
                                <p>Total Companies</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('admin.company.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
            </div>

            @role('admin')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">Issue Chart</h5>
                                    <div class="d-flex flex-column">
                                        {{-- <label class="card-title" style="font-weight: 400;font-size: 17px;">Company</label> --}}
                                        <select class="form-control" id="companyId" style="appearance: auto;">
                                            <option value="default">Select Company</option>
                                            @foreach ($data['company'] as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="chart-container mt-3" style="height: 350px;">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card pb-3">
                            <div class="card-body">
                                <h5 class="card-title">User Chart</h5>
                                <div class="chart-container" style="height: 500px;">
                                    <canvas id="userChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <script>
                    $("#userChart").addClass("chart-width");
                    let companyId;
                    let myChart;

                    function issueChart(companyId) {
                        if (myChart) {
                            myChart.destroy();
                        }
                        $.ajax({
                            url: "{{ route('admin.dashboard.issue.chart') }}",
                            data: {
                                companyId: companyId
                            },
                            success: function(response) {
                                const ctx = document.getElementById('myChart');

                                const labels = response.map(item => item.status);
                                const data = response.map(item => item.count);

                                myChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Issue Status',
                                            data: data,
                                            backgroundColor: [
                                                'red', 'blue', 'yellow', 'green', 'purple'
                                            ],
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: false,
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                    issueChart(companyId);

                    $(document).on('change', "#companyId", function() {
                        companyId = $(this).val();
                        console.log(companyId)
                        issueChart(companyId);
                    })
                </script>

                <script>
                    const userChart = document.getElementById('userChart').getContext('2d');
                    const hrData = @json($resultData['hrData']);
                    const managerData = @json($resultData['managerData']);

                    const months = Object.keys(hrData);
                    const hrCounts = Object.values(hrData);
                    const managerCounts = Object.values(managerData);

                    new Chart(userChart, {
                        type: 'bar',
                        data: {
                            labels: months.map(month => formatDateLabel(month)),
                            datasets: [{
                                    label: 'HR Users',
                                    data: hrCounts,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1,
                                },
                                {
                                    label: 'Manager Users',
                                    data: managerCounts,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1,
                                },
                            ],
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number Of User',
                                    },
                                    ticks: {
                                        stepSize: 2,
                                    },
                                },
                                x: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Months',
                                    },
                                    ticks: {
                                        autoSkip: false,
                                    },
                                }
                            },
                        },
                    });

                    function formatDateLabel(month) {
                        const monthNames = [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ];
                        return monthNames[month - 1];
                    }
                </script>
            @endrole
        </div><!-- /.container-fluid -->

    </section>

    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>{{ __('messages.footer') }}</strong>
        <div class="float-right d-none d-sm-inline-block">
            {{ __('messages.version') }}
        </div>
    </footer>
    <!-- /.control-sidebar -->
@endsection
