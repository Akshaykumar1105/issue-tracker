@extends('dashboard.layout.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @if (isset($data['managerCount']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $data['managerCount'] }}</h3>
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

                @if (isset($data['issueCount']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['issueCount'] }}</h3>
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
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Issue Chart</h5>
                        </div>
                        <div class="chart-container mt-3" style="height: 350px;">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const issueStatusData = @json($issueStatus);
        function issueChart() {
        const ctx = document.getElementById('myChart');
        
        const labels = issueStatusData.map(item => item.status.replace(/_/g, ' ').replace(/\w\S*/g,
            function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }));
        const data = issueStatusData.map(item => item.count);

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
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const dataIndex = context.dataIndex;
                                const value = data[dataIndex];
                                return `Count: ${value}`;
                            },
                        }
                    }
                },
            }
        });
    }
    issueChart();
    </script>
@endsection
