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
            <div class="row">
                @if (isset($data['userCount']))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['userCount'] }}</h3>
                                <p>Total User</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('admin.hr.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (isset($data['issueCount']))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['issueCount'] }}</h3>
                                <p>Total Issues</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>

                            <a href="{{ route('admin.issue.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (isset($data['companies']))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['companies']->count() }}</h3>
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

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Issue Chart</h5>
                                <div class="d-flex flex-column">
                                    <select class="form-control" id="companyId" style="appearance: auto;">
                                        <option value="default">Select Company</option>
                                        @foreach ($data['companies'] as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="chart-container mt-3" style="height: 345px;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card pb-3">
                        <div class="card-body">
                            <h5 class="card-title">User Chart</h5>
                            <div class="chart-container" style="height: 300px;">
                                <canvas id="userChart"></canvas>
                            </div>
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

                    const labels = response.map(item => item.status.replace(/_/g, ' ').replace(/\w\S*/g,
                        function(txt) {
                            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                        }));
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
                            }
                        }
                    });
                }
            });
        }
        issueChart(companyId);

        $(document).on('change', "#companyId", function() {
            companyId = $(this).val();
            issueChart(companyId);
        })
    </script>

    <script>
        const userChart = document.getElementById('userChart').getContext('2d');
        const hrData = @json($resultData['hrCount']);
        const managerData = @json($resultData['managerCount']);

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
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;

                                if (context.datasetIndex === 0) {
                                    return `HR Count: ${value}`;
                                } else {
                                    return `Manager Count: ${value}`;
                                }
                            },
                        }
                    }
                }
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
@endsection
