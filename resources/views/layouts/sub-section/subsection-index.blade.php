@extends('layouts.template')
@section('content')
    <main>
        <div class="container-fluid px-4">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('subsection.create') }}" class="btn btn-outline-primary">+ SUBSECTION</a>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Subsection
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTables">
                        <thead class="table-secondary">
                            <tr>
                                <th>Subsection Name</th>
                                <th>Order</th>
                                <th class="w-25">Section Name</th>
                                <th class="w-25">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subsection as $data)
                                <tr>
                                    <td>{{ $data->title }}</td>
                                    <td>{{ $data->order }}</td>
                                    <td>
                                        {{ $data->sections->area }}
                                    </td>
                                    <td>
                                        <a href="{{route('subsection.edit',$data->id)}}" class="btn btn-primary">Edit</a>
                                        <a href="{{route('subsection.destroy',$data->id)}}" class="btn btn-danger">Delete</a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </main>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>


    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable();

        });
    </script>
@endpush
