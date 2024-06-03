@extends('layouts.template')
@section('content')
    <form method="post" action="{{ route('answer.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">
            <div class="card mb-4">
                <div class="card-body">
                    {{-- Auditor Name Select Option --}}
                    <label for="auditor_id" class="mb-3" style="font-size: 20px; font-weight: bold;">Auditor Name <span
                            class="text-danger">*</span></label>
                    <select name="auditor_id" id="name" class="form-control mb-4">
                        <option value="">Select Auditor Name</option>
                        @foreach ($auditors as $auditor)
                            <option value="{{ $auditor->id }}">{{ $auditor->name }}</option>
                        @endforeach
                    </select>

                    {{-- Auditor Level Select Option --}}
                    <label for="role" class="mb-3" style="font-size: 20px; font-weight: bold;">Auditor Level
                        <span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-control mb-4">
                        <option value="">Select Auditor Level</option>
                    </select>

                    {{-- To Show Area Process --}}
                    <label for="area" class="mb-3" style="font-size: 20px; font-weight: bold;">Line / Process<span
                            class="text-danger">*</span> </label>
                    <br>
                    <label for="area">{{ $sections[0]->area }}</label>
                </div>
            </div>
        </div>

        {{-- Card Question
        @foreach ($sections as $section)
            <div class="card mb-4">
                <div class="card-title fs-5 ms-2 fw-bold   ">
                    Page {{ $loop->iteration }}
                </div>
                <div class="card-body">
                    <img id="documentImagePreview" src="{{ asset('assets/img/' . $section->image) }}"
                        alt="Document Image Preview" class="img-fluid">
                    <br>
                    <label for="part_name" class="mb-3" style="font-size: 18px; font-weight: bold;">
                        NamaPart : {{ $section->part->part_name }}
                    </label>
                    <br>
                    <label for="problem" class="mb-3" style="font-size: 18px; font-weight: bold;">Problem :
                        {{ $section->problem }}</label>
                    @foreach ($section->subsections as $subsection)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="3" style="font-size: 16px; font-weight: bold;">{{ $subsection->title }}
                                    </td>
                                </tr>
                                @foreach ($subsection->questions as $question)
                                    <tr>
                                        <td></td>
                                        <td>{{ $question->yes_desc }}</td>
                                        <td>{{ $question->no_desc }}</td>
                                        <td>Note</td>
                                    </tr>
                                    <tr>
                                        {{-- <td data-question-id="{{ $question->id }}">{{ $question->question }}</td>
                                        <td data-question-id="{{ $question->id }}">
                                            {{ $question->question }}
                                            <input type="hidden" name="question_id[{{ $question->id }}]"
                                                value="{{ $question->id }}">
                                        </td>

                                        <td>
                                            <input for="remark" type="radio" class="form-check-input1"
                                                id="remark_{{ $question->id }}_1" name="remark[{{ $question->id }}]"
                                                value="10"
                                                {{ old('remark_' . $question->id . '_1') == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input for="remark" type="radio" class="form-check-input2"
                                                id="remark_{{ $question->id }}_2" name="remark[{{ $question->id }}]"
                                                value="0"
                                                {{ old('remark_' . $question->id . '_2') == '0' ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                              <textarea type="text" for="note" class="form-control" rows="4"
                                                id="note_[{{ $question->id }}]" name="note[{{ $question->id }}]"></input>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <label for="image">Lampiran Foto Bukti <span class="text-danger">*</span></label>
                        <input type="file" name="image[{{ $section->id }}]" class="form-control mb-4" id="image"
                            accept="image/*" placeholder="Masukkan file foto">
                    </div>
                </div>
            </div>
        @endforeach --}}

        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
        <button type="button" class="btn btn-secondary btn-lg btn-block">Cancel</button>
    </form>
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
        $(document).ready(function() {
            $('#name').change(function() {
                var auditorId = $(this).val();
                if (auditorId) {
                    $.ajax({
                        type: 'GET',
                        url: '/get-auditor-level/' + auditorId,
                        success: function(response) {
                            $('#role').empty();
                            $.each(response, function(key, value) {
                                $('#role').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#role').empty();
                    $('#role').append('<option value="">Select Auditor Level</option>');
                }
            });

            // Mengirim data formulir hanya jika catatan tidak null
            $('form').submit(function(e) {

                // Membuat objek data yang akan dikirim melalui AJAX
                var formData = {
                    _token: $('input[name=_token]').val(),
                    auditor_id: $('#auditor_id').val(),
                    role: $('#role').val(),
                    question_id: $('input[name=question_id]').val(),
                    remark: $('input[name^="remark"]').serializeArray() // Mengambil data remark
                };

                // Mengambil data catatan
                var notes = {};
                $('input[name^="note"]').each(function() {
                    var noteValue = $(this).val();
                    if (noteValue !== '') {
                        notes[$(this).attr('name').match(/\d+/)[0]] =
                            noteValue; // Menambahkan catatan jika tidak null
                    }
                });
                formData['note'] = notes; // Menambahkan data catatan ke formData

                // Mengirim data hanya jika catatan tidak null

            });
        });
    </script>
@endpush
