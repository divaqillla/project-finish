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
                    Add Subsection
                </div>
                <div class="card-body">
                    <form action="{{ route('subsection.store') }}" method="POST">
                        @csrf

                        {{-- Model 1 --}}
                        {{-- <div class="form-group mb-3">
                            <label for="my-input">Section Name</label>
                            <select class="form-control" type="text" name="section_id">
                                @foreach ($section as $select)
                                    <option value="{{ $select->id }}">{{ $select->area }} | {{ $select->problem }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="my-input">Subsection Name</label>
                            <input class="form-control" type="text" name="section_id">
                        </div>

                        <div class="form-group mb-3">
                            <label for="my-input">Order</label>
                            <input class="form-control" type="number" name="order">
                        </div> --}}



                        {{-- Model 2 --}}
                        <div class="form-group mb-3">
                            <label for="my-input">Section Name</label>
                            <select class="form-control" type="text" name="section_id">
                                @foreach ($section as $select)
                                    <option value="{{ $select->id }}">{{ $select->area }} | {{ $select->problem }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="my-input">Subsection Name</label>
                        <div id="inputFormRow">
                            <div class="input-group">

                                <input class="form-control" type="text" name="title[]" placeholder="Title">

                                <input class="form-control" type="number" name="order[]" placeholder="order">

                            </div>
                        </div>


                        <div id="newRow"></div>


                        <div class="d-flex">
                            <button id="addRow" type="button" class="btn btn-sm btn-secondary mb-4 mt-3">+ Add
                                Subsection Input</button>

                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>


                    </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
        $("#addRow").click(function() {

            // Get the JSON data as an array
            var barangArray = {!! $section !!};

            // Create the options HTML using a loop
            var options = '';

            // Create the new row HTML

            var html = '';
            html += '<div id="inputFormRow" class="mt-3">';
            html += '<div class="input-group mb-3">';
            html += '<input class="form-control" type="text" name="title[]" placeholder="Title">'
            html +=
                '<input class="form-control" type="number" name="order[]" placeholder="Order">';

            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Kurangi</button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            // Append the new row to #newRow

            $('#newRow').append(html);
            // $('.livesearch').select2();
        });

        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputFormRow').remove();
        });
    </script>
@endpush
