{{-- <div id="layoutSidenav">
            @include('layouts/partials/sidebar')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{$judul}}</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Static Navigation</li>
                        </ol>
                            <div class="card-body">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <label for="product_name" class="mb-3">Auditor Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control mb-4" id="auditorName" placeholder="Enter Auditor Name">
                                        
                                        <label for="line" class="mb-3">Level Auditor <span class="text-danger">*</span></label>
                                        <select class="form-control mb-4" name="line" required>
                                            <option value="" disabled selected>Select Level Auditor</option>
                                            <option value="staff">Staff</option>
                                            <option value="sechead">Section Head</option>
                                            <option value="depthead">Department Head</option>
                                            <option value="divhead">Division Head</option>
                                        </select>
                                        
                                        <label for="line" class="mb-3">Line / Process <span class="text-danger">*</span></label>
                                            <select class="form-control mb-4" name="line" required>
                                                <option value="" disabled selected>Select Line</option>
                                                <option value="casthpdc">Casting HPDC</option>
                                                <option value="casthpdc">Machining</option>
                                                <option value="casthpdc">Assy</option>
                                                <option value="casthpdc">Painting</option>

                                            </select>
                                    </div>
                                </div>
                            </div>


                           
                            <div> Page 1</div>
                            <div class="card-body">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="product_name">Nama Parts dan Problemnya<span class="text-danger">*</span></label>
                                            <div id="documentImagePreviewContainer" class="mt-2">
                                                <img id="documentImagePreview" src="{{ asset('path/to/default/image.jpg') }}" alt="Document Image Preview" class="img-fluid">                 
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Apakah Dies #2 (2A, 2B) sudah dilakukan perbaikan dimensi celah groove locking dan dimensi celah groove locking "OK" ?</th>
                                                            <th>Ya, perbaikan sudah dilakukan dan dimensi celah groove locking sesuai std 1,8 ±0,1</th>
                                                            <th>Tidak, dari hasil sampling masih ditemukan dimensi groove locking tidak sesuai std 1,8 ±0,1</th>
                                                            <th>Note</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <label for="sample_check_1">Hasil cek sample KE-1 menggunakan pin gauge / caliper</label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_1" name="sample_check" value="1" {{ old('sample_check') == '1' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_2" name="sample_check" value="2" {{ old('sample_check') == '2' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <textarea class="form-control" name="audit_note_1">{{ old('audit_note_1') }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Add more rows for additional entries -->
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <label for="sample_check_1">Hasil cek sample KE-2 menggunakan pin gauge / caliper</label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_1" name="sample_check" value="1" {{ old('sample_check') == '1' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_2" name="sample_check" value="2" {{ old('sample_check') == '2' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <textarea class="form-control" name="audit_note_1">{{ old('audit_note_1') }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Add more rows for additional entries -->
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <label for="sample_check_1">Hasil cek sample KE-3 menggunakan pin gauge / caliper</label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_1" name="sample_check" value="1" {{ old('sample_check') == '1' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_2" name="sample_check" value="2" {{ old('sample_check') == '2' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <textarea class="form-control" name="audit_note_1">{{ old('audit_note_1') }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Add more rows for additional entries -->
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <label for="sample_check_1">Hasil cek sample KE-4 menggunakan pin gauge / caliper</label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_1" name="sample_check" value="1" {{ old('sample_check') == '1' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_2" name="sample_check" value="2" {{ old('sample_check') == '2' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <textarea class="form-control" name="audit_note_1">{{ old('audit_note_1') }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Add more rows for additional entries -->
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <label for="sample_check_1">Hasil cek sample KE-5 menggunakan pin gauge / caliper</label>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_1" name="sample_check" value="1" {{ old('sample_check') == '1' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input" id="sample_check_2" name="sample_check" value="2" {{ old('sample_check') == '2' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="form-check">
                                                                    <textarea class="form-control" name="audit_note_1">{{ old('audit_note_1') }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Add more rows for additional entries -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <label for="product_name" class="mb-3">Lampiran Foto Bukti <span class="text-danger">*</span></label>
                                                    <input type="file" class="form-control mb-4" id="fileInput" accept="image/*" placeholder="Masukkan file foto">
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-lg btn-block">Submit</button>
                            <button type="button" class="btn btn-secondary btn-lg btn-block">Cancel</button>
                        </div>
                        <div style="height: 100vh"></div>
                        <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
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
    </body>
</html>  --}}

@extends('layouts.template')
@section('content')
    <div class="card-body">
        <div class="card mb-4">
            <div class="card-body">
                <label for="product_name" class="mb-3">Auditor Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control mb-4" id="auditorName" placeholder="Enter Auditor Name">

                <label for="line" class="mb-3">Level Auditor <span class="text-danger">*</span></label>
                <select class="form-control mb-4" name="line" required>
                    <option value="" disabled selected>Select Level Auditor</option>
                    <option value="staff">Staff</option>
                    <option value="sechead">Section Head</option>
                    <option value="depthead">Department Head</option>
                    <option value="divhead">Division Head</option>
                </select>

                <label for="line" class="mb-3">Line / Process <span class="text-danger">*</span></label>
                <select class="form-control mb-4" name="line" required>
                    <option value="" disabled selected>Select Line</option>
                    <option value="casthpdc">Casting HPDC</option>
                    <option value="casthpdc">Machining</option>
                    <option value="casthpdc">Assy</option>
                    <option value="casthpdc">Painting</option>

                </select>
            </div>
        </div>
    </div>
    @php
        $totalSections = count($data); // Menghitung jumlah total section
    @endphp
    @foreach ($sections as $index => $section)
        <div>Page {{ $index + 1 }}</div>
        <div class="card-body">
        {{-- <div class="card mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <div class="card mb-4">
                            <div class="card-body">
                                <label for="product_name">Nama Parts dan Problemnya<span
                                        class="text-danger">*</span></label>
                                <div id="documentImagePreviewContainer" class="mt-2">
                                    <img id="documentImagePreview" src="{{ asset('path/to/default/image.jpg') }}"
                                        alt="Document Image Preview" class="img-fluid">
                                                  
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            @foreach ($data[$i]->subsections as $title)
                                @foreach ($data2 as $b)
                                    @foreach ($b->questions as $question)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>{{ $title->title }}</th>
                                                        <th>{{ $question->yes_desc }}</th>
                                                        <th>{{ $question->no_desc }}</th>
                                                        <th>Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($data2 as $b)
                                                        @foreach ($b->questions as $question)
                                                            <tr>
                                                                <td>
                                                                    <div>
                                                                        <label>{{ $question->question }}</label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="form-check">
                                                                        <input type="radio" class="form-check-input2"
                                                                            id="sample_check_1" name="sample_check1"
                                                                            value="1"
                                                                            {{ old('sample_check') == '1' ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="form-check">
                                                                        <input type="radio" class="form-check-input1"
                                                                            id="sample_check_2" name="sample_check"
                                                                            value="2"
                                                                            {{ old('sample_check') == '2' ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="form-check">
                                                                        <textarea class="form-control" name="audit_note_1">{{ old('audit_note_1') }}</textarea>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endforeach
                            <div class="card mb-4">
                                <div class="card-body">
                                    <label for="product_name" class="mb-3">Lampiran Foto Bukti <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control mb-4" id="fileInput" accept="image/*"
                                        placeholder="Masukkan file foto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    @endforeach
@endsection
@push('js')
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script></script>
@endpush
