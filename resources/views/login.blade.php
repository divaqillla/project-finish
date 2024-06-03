@extends('layouts/templatelogin')
@section('content')
    <div class="w-50 center border rounded px-3 py-3 mx-auto" style="padding-top: 4rem; margin-top: 4rem;">
        <h1>Login</h1>
        @if (Session::has('login_failed'))
            <div class="alert alert-danger">
                {{ Session::get('login_failed') }}
            </div>
        @endif
        <form action="/sesi/login" method="POST" class="container-xl">
            @csrf
            <div class="mb-3">
                <label for="nrp" class="form-label">NRP</label>
                <input type="number" value="{{ Session::get('nrp') }}" id="nrp" name="nrp" class="form-control" min="0"
                    maxlength="5" required>
                <div id="nrp-error" style="color: red; font-size: 0.8em; display: none;">
                    NRP harus terdiri dari 5 angka.
                </div>
            </div>

            <div class="mb-3">
                <label for="auditor_name" class="form-label">Auditor Name</label>
                <input type="text" name="auditor_name" id="auditor_name" class="form-control" required>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">LOGIN</button>
    </div>
    </form>
    </div>
@endsection
@push('js')
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
<script>
    document.getElementById('nrp').addEventListener('input', function() {
        var inputValue = this.value;
        if (inputValue.length > 5) {
            this.value = inputValue.slice(0, 5); // Potong nilai input menjadi 6 karakter pertama
            document.getElementById('nrp-error').style.display = 'block'; // Tampilkan pesan kesalahan
        } else {
            document.getElementById('nrp-error').style.display =
                'none'; // Sembunyikan pesan kesalahan jika input valid
        }
    });
</script>
<script>
    document.getElementById('auditor_name').addEventListener('input', function() {
        var inputValue = this.value;
        // Menghapus karakter non-huruf dari input
        inputValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
        // Atur nilai input ke nilai yang telah dimodifikasi
        this.value = inputValue;
    });
    </script>
@endpush
