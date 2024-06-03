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
            <a href="{{ url('/checksheetpainting') }}" class="btn btn-outline-primary">+ CHECKSHEET</a>
            <a href="{{ url('/painting-history') }}" class="btn btn-outline-secondary">HISTORY</a>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Audit Painting
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
                            @foreach ($auditorsPainting as $auditor)
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
                                            <a href="{{ route('detailPainting', $auditor->id) }}" class="btn btn-primary mb-1">Detail</a><br>

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
@endpush
