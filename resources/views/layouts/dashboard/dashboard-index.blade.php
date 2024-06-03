@extends('layouts.template')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Grafik Achievement</li> <br>
            </ol>
            {{-- <h3 class="d-flex text-danger mt-2 fw-bold">{{Auth::getDefaultdriver()}}</h3> --}}

            <div class="row">
                <div class="row">


                    {{-- <div class="col-6">
                        {{-- <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Target Achievement Weekly
                            </div>
                            <div class="card-body">
                                <canvas id="weeklyCastingChart" width="10%" height="5"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- @if (Auth::user()->auditor_level == 'Div Head') --}}
                    <div class="col-6">
                        <div class="card mb-4">
                            <div class="card-header">

                                <i class="fas fa-chart-bar me-1"></i>

                                Target Achievement Yearly Chart For Division Head
                                <select id="yearFilter">
                                    <!-- Add an option for all years -->
                                    <option value="all">All Years</option>
                                    <!-- Loop through the yearlyAudit data to generate options for each year -->
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>

                                </select>

                            </div>
                            <div class="card-body" style="height: 50vh"><canvas id="yearlyChart" width="100%"
                                    height="200"></canvas></div>
                        </div>
                    </div>
                    {{-- @endif --}}


                    {{-- @if (Auth::user()->auditor_level == 'Dept Head') --}}
                    <div class="col-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Target Achievement Per Weeks Chart For Department Head
                            </div>
                            <div class="card-body" style="height: 50vh;"><canvas id="perWeeksChart" width="100%"
                                    height="200"></canvas></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Target Achievement Monthly For Section Head
                                <select id="monthFilter">
                                    <option value="all">All Months</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                    <!-- Tambahkan opsi untuk bulan-bulan lainnya sesuai kebutuhan -->
                                </select>
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Auditors Achievement Recaps
                            </div>
                            <div class="px-3 py-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Line</th>
                                                <th>Passed</th>
                                                <th>Not Passed</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($areaStatistics as $dp)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dp['area'] }}</td>
                                                    <td>{{ $dp['total_passed'] }}</td>
                                                    <td>{{ $dp['total_not_passed'] }}</td>
                                                    <td>
                                                        @php
                                                            $routeName = '';
                                                            switch ($dp['area']) {
                                                                case 'Casting HPDC':
                                                                    $routeName = 'castingHistory';
                                                                    break;
                                                                case 'Machining':
                                                                    $routeName = 'machininggHistory';
                                                                    break;
                                                                case 'Assy':
                                                                    $routeName = 'assyHistory';
                                                                    break;
                                                                case 'Painting':
                                                                    $routeName = 'paintingHistory';
                                                                    break;
                                                                case 'Supplier':
                                                                    $routeName = 'supplierHistory';
                                                                    break;
                                                            }
                                                        @endphp
                                                        @if ($routeName)
                                                            <a href="{{ route($routeName) }}"
                                                                class="btn btn-primary btn-sm">Detail</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}

                </div>
            </div>

        </div>
    </main>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    <script>

        // Yearly filter yearFilter

        document.getElementById('yearFilter').addEventListener('change', (event) => {
            const selectedYear = event.target.value;
            filterYearChartData(selectedYear);
        });

        const filterYearChartData = (selectedYear) => {
            const filteredYearData = selectedYear === 'all' ? yearlyResult : filterByYear(yearlyResult, selectedYear);
            updateYearChart(filteredYearData);
        };


        const filterByYear = (data, year) => {
            const filteredYearData = {};
            Object.entries(data).forEach(([key, value]) => {
                const date = new Date(key);
                if (date.getYear() + 1 === parseInt(year)) {
                    filteredYearData[key] = value;
                }
            });
            return filteredYearData;
        };

        const updateYearChart = (filteredYearData) => {
            yearlyResult.data.labels = Object.keys(filteredYearData);
            yearlyResult.data.datasets.forEach((dataset, index) => {
                const datasetValues = Object.values(filteredYearData).map((item) => item.data[dataset.label] || 0);
                dataset.data = datasetValues;
            });
            yearlyResult.update();
        };





        // Monthly Filter

        document.getElementById('monthFilter').addEventListener('change', (event) => {
            const selectedMonth = event.target.value;
            filterChartData(selectedMonth);
        });

        const filterChartData = (selectedMonth) => {
            const filteredData = selectedMonth === 'all' ? monthlyData : filterByMonth(monthlyData, selectedMonth);
            updateChart(filteredData);
        };

        const filterByMonth = (data, month) => {
            const filteredData = {};
            Object.entries(data).forEach(([key, value]) => {
                const date = new Date(key);
                if (date.getMonth() + 1 === parseInt(month)) {
                    filteredData[key] = value;
                }
            });
            return filteredData;
        };

        const updateChart = (filteredData) => {
            monthlyChart.data.labels = Object.keys(filteredData);
            monthlyChart.data.datasets.forEach((dataset, index) => {
                const datasetValues = Object.values(filteredData).map((item) => item.data[dataset.label] || 0);
                dataset.data = datasetValues;
            });
            monthlyChart.update();
        };


        // var weeklyResult = {!! json_encode($weeklyResult) !!};

        // // Ambil elemen canvas sebagai tempat untuk membuat chart
        // var weeklyCtx = document.getElementById('weeklyCastingChart').getContext('2d');

        // // Inisialisasi Chart
        // var weeklyCastingChart = new Chart(weeklyCtx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'], // Label hari
        //         datasets: [{
        //             label: 'Jumlah Audit',
        //             data: Object.values(weeklyResult), // Data jumlah audit
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(153, 102, 255, 1)'
        //             ],
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(153, 102, 255, 1)'
        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             },
        //             yAxes: [{
        //                 ticks: {
        //                     min: 0,
        //                     max: 20,
        //                     stepSize: 2,

        //                 },
        //                 gridLines: {
        //                     display: true,
        //                 },
        //             }, ],
        //         }
        //     }
        // });
        // <script>
        var yearlyResult = {!! json_encode($yearlyAudit) !!};

        console.log(yearlyResult);
        // Ambil elemen canvas sebagai tempat untuk membuat chart
        var yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        var yearlyChart = new Chart(yearlyCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(yearlyResult), // Label bulan
                datasets: [{
                        label: 'Casting HPDC',
                        data: Object.values(yearlyResult).map(item => item['Casting HPDC'] || 0),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Machining',
                        data: Object.values(yearlyResult).map(item => item['Machining'] || 0),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Assy',
                        data: Object.values(yearlyResult).map(item => item['Assy'] || 0),
                        backgroundColor: 'rgba(255, 206, 86, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Painting',
                        data: Object.values(yearlyResult).map(item => item['Painting'] || 0),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Warna latar belakang
                    }
                    // ,
                    // {
                    //     label: 'Supplier',
                    //     data: Object.values(yearlyResult).map(item => item['Supplier'] || 0),
                    //     backgroundColor: 'rgba(153, 102, 255, 0.5)', // Warna latar belakang
                    // }
                ]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        align: 'center',
                        anchor: 'center'
                    }
                },
                tooltips: {
                    displayColors: true,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                        },
                        barThickness: 40
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            max: 4,
                            stepSize: 1,
                        },
                        type: 'linear',
                    }],
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
            },
        });





        var perWeeks = {!! json_encode($auditsPerWeek) !!};

        console.log(perWeeks);
        // Ambil elemen canvas sebagai tempat untuk membuat chart
        var perWeeksCtx = document.getElementById('perWeeksChart').getContext('2d');
        var perWeeksChart = new Chart(perWeeksCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(perWeeks), // Label bulan
                datasets: [{
                        label: 'Casting HPDC',
                        data: Object.values(perWeeks).map(item => item['Casting HPDC'] || 0),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Machining',
                        data: Object.values(perWeeks).map(item => item['Machining'] || 0),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Assy',
                        data: Object.values(perWeeks).map(item => item['Assy'] || 0),
                        backgroundColor: 'rgba(255, 206, 86, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Painting',
                        data: Object.values(perWeeks).map(item => item['Painting'] || 0),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Warna latar belakang
                    }
                    // ,
                    // {
                    //     label: 'Supplier',
                    //     data: Object.values(perWeeks).map(item => item['Supplier'] || 0),
                    //     backgroundColor: 'rgba(153, 102, 255, 0.5)', // Warna latar belakang
                    // }
                ]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        align: 'center',
                        anchor: 'center'
                    }
                },
                tooltips: {
                    displayColors: true,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                        },
                        barThickness: 40
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            max: 4,
                            stepSize: 1
                        },
                        type: 'linear',
                    }],
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
            },
        });


        var monthlyData = {!! json_encode($monthlyCasting) !!};

        // Menampilkan grafik menggunakan Chart.js
        var monthlyCtx = document.getElementById("myBarChart").getContext("2d");
        var monthlyChart = new Chart(monthlyCtx, {
            type: "bar",
            data: {
                labels: Object.keys(monthlyData), // Label bulan
                datasets: [{
                        label: 'Casting HPDC',
                        data: Object.values(monthlyData).map(item => item.data['Casting HPDC'] || 0),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Machining',
                        data: Object.values(monthlyData).map(item => item.data['Machining'] || 0),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Assy',
                        data: Object.values(monthlyData).map(item => item.data['Assy'] || 0),
                        backgroundColor: 'rgba(255, 206, 86, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Painting',
                        data: Object.values(monthlyData).map(item => item.data['Painting'] || 0),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'Supplier',
                        data: Object.values(monthlyData).map(item => item.data['Supplier'] || 0),
                        backgroundColor: 'rgba(153, 102, 255, 0.5)', // Warna latar belakang
                    }
                ]
            },
            options: {
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                        },
                        barThickness: 40,
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                            max: 20,
                            stepSize: 2,
                        },
                        gridLines: {
                            display: true,
                        },
                    }],
                },
                legend: {
                    position: "bottom",
                },
            },
        });
    </script>
@endpush
