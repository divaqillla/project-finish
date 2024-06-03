@extends('layouts.template')
@section('content')
    <main>
        <div class="container-fluid px-4">

            <!-- Tambahkan Notifikasi di Sini -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            {{-- <h1 class="mt-4">Dashboard Audit Machining </h1> --}}
            {{-- <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Grafik Achievement</li>
            </ol>
            <div class="row">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Target Achievement 80%
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <a href="{{ url('/checksheetmachining') }}" class="btn btn-outline-primary">+ CHECKSHEET</a>
            <a href="{{ url('/machiningHistory') }}" class="btn btn-outline-secondary">HISTORY</a>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Audit Machining
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Date</th>
                                <th>Auditor Name</th>
                                <th>Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($auditorsMachining as $auditor)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($today)->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td>{{ $auditor->name }}</td>
                                    <td>
                                        @foreach ($score as $section_id => $section_score)
                                            @if (round($section_score) < 100)
                                                <span style="color: red;">{{ $section_id }}:
                                                    {{ round($section_score) }}</span>
                                            @else
                                                {{ $section_id }}: {{ round($section_score) }}
                                            @endif
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- @foreach ($score as $section_id => $section_score) --}}
                                        <a href="{{ route('detailmachining', $auditor->id) }}"
                                            class="btn btn-primary mb-1">Detail</a><br>
                                        {{-- @endforeach --}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ $auditor->name }}</td>
                                    <td>
                                        @foreach ($score as $section_id => $section_score)
                                            @if (round($section_score) < 100)
                                                <span style="color: red;">{{ round($section_score) }}</span>
                                            @else
                                                {{ round($section_score) }}
                                            @endif
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- @foreach ($score as $section_id => $section_score) --}}
                                        <a href="{{ route('detailmachining', $auditor->id) }}"
                                            class="btn btn-primary mb-1">Detail</a><br>
                                        {{-- @endforeach --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Your Website 2023</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
    </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    {{-- <script>
        var auditorsData = {!! json_encode($monthlyMachining) !!};
        var auditorNames = [];
        var auditorData = [];

        auditorsData.forEach(function(auditor) {
            auditorNames.push(auditor.name);
            auditorData.push(auditor.data);

        });

        var ctx = document.getElementById("myBarChart");
        var myLineChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: auditorNames,
                datasets: [{
                    label: "Jumlah Audit",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [
                        @foreach ($monthlyMachining as $auditor)
                            {{ $auditor->total_days_with_audit }},
                        @endforeach
                    ],

                }, ],

            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month",
                        },
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            maxTicksLimit: 6,
                        },
                        barThickness: 50
                    }, ],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 20,
                            stepSize: 2,

                        },
                        gridLines: {
                            display: true,
                        },
                    }, ],
                },
                legend: {
                    display: false,
                },
            },
        });
    </script> --}}
@endpush
