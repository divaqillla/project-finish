@extends('layouts.template')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <!-- Tambahkan Notifikasi di Sini -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            {{-- <h1 class="mt-4">{{ $judul }} </h1> --}}
            <ol class="breadcrumb mb-4">
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
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Audit Supplier
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>PT Name</th>
                                <th>Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($dataForView as $data)
                                <tr>
                                    <td>{{ $data['pt'] }}</td>

                                    <td>
                                        <ul>
                                            @foreach ($data['scores'] as $sectionName => $score)
                                                <li>
                                                    {{ $sectionName }}: {{  round($score) }}
                                                </li>
                                            @endforeach

                                        </ul>

                                    </td>
                                    <td><a href="{{route('internal.supplierHistory') }}" class="btn btn-primary">View History</a>
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

    <script>
        // Mengubah data PHP ke dalam format JSON yang bisa digunakan JavaScript
        var monthlyData = {!! json_encode($monthlySupplier) !!};
    
        console.log(monthlyData);
    
        // Ekstraksi kunci (tanggal) dan urutkan dalam urutan naik
        var sortedDates = Object.keys(monthlyData).sort((a, b) => new Date(a) - new Date(b));
    
        // Buat chart menggunakan tanggal yang sudah diurutkan
        var monthlyCtx = document.getElementById("myBarChart").getContext("2d");
        var monthlyChart = new Chart(monthlyCtx, {
            type: "bar",
            data: {
                labels: sortedDates, // Gunakan tanggal yang sudah diurutkan sebagai label
                datasets: [
                    {
                        label: 'PT GPU',
                        data: sortedDates.map(date => monthlyData[date].data['PT GPU'] || 0),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'PT DM Indonesia',
                        data: sortedDates.map(date => monthlyData[date].data['PT DM Indonesia'] || 0),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'PT Menara Adi Cipta',
                        data: sortedDates.map(date => monthlyData[date].data['PT Menara Adi Cipta'] || 0),
                        backgroundColor: 'rgba(255, 206, 86, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'PT Kurnia Manunggal Sejahtera',
                        data: sortedDates.map(date => monthlyData[date].data['PT Kurnia Manunggal Sejahtera'] || 0),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Warna latar belakang
                    },
                    {
                        label: 'PT Rachmat Perdana Adhimetal',
                        data: sortedDates.map(date => monthlyData[date].data['PT Rachmat Perdana Adhimetal'] || 0),
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
