@extends('layouts.supplier.layout-supp')
@section('content-supplier')
    <form id="form_kms" method="post" action="{{ route('suppanswer.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="card-body">
                <div class="card mb-4">
                    <div class="card-body">

                        <input type="hidden" name="auditor_id" value="{{Auth::guard('suppliers')->user()->id}}">
                        <label for="line" class="mb-3" style="font-size: 20px; font-weight: bold;">Line/Process:</label>
                        <select id="line" name="line" class="form-control mb-4">
                            <option value="Incoming Inspection NM">Incoming Inspection NM</option>
                            <option value="Vendor / Subcont">Vendor / Subcont</option>
                        </select>

                        <label for="vendor" class="mb-3" style="font-size: 20px; font-weight: bold;">Nama
                            Vendor/Subcont:</label>
                        <input type="text" id="vendor" name="vendor" class="form-control mb-4"
                            value="{{ Auth::guard('suppliers')->user()->pt }}" placeholder="Enter Vendor/Subcount Name">
                    </div>
                </div>
            </div>

        {{-- Card Question --}}
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
                        Nama Part : {{ $section->part->part_name }}
                    </label>
                    <br>
                    <label for="problem" class="mb-3" style="font-size: 18px; font-weight: bold;">Problem :
                        {{ $section->problem }}</label>
                    @foreach ($section->subsections as $subsection)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="6" style="font-size: 16px; font-weight: bold;">
                                        {{ $subsection->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>{{ $subsection->questions[0]->yes_desc }}</td>
                                    <td>{{ $subsection->questions[0]->no_desc }}</td>
                                    <td>Note</td>

                                </tr>
                                @foreach ($subsection->questions as $question)
                                    @if ($question->type != 'image')
                                        <tr>
                                            {{-- <td data-question-id="{{ $question->id }}">{{ $question->question }}</td> --}}
                                            <td data-question-id="{{ $question->id }}" style="width: 250px;">
                                                {{ $question->question }}
                                                <input type="hidden" name="question_id[{{ $question->id }}]"
                                                    value="{{ $question->id }}">
                                            </td>

                                            <td style="width: 150px;">
                                                <input for="remark" type="radio" class="form-check-input1 listener"
                                                    id="remark_{{ $question->id }}_1"
                                                    data-section-id="{{ $section->id }}"
                                                    data-subsection-id="{{ $subsection->id }}"
                                                    data-question-id="{{ $question->id }}" data-value="true"
                                                    data-type="checkbox" name="answer[{{ $question->id }}][remark]"
                                                    value="100"
                                                    {{ old('remark_' . $question->id . '_1') == '1' ? 'checked' : '' }}
                                                    @required(true)>
                                            </td>
                                            <td style="width: 150px;">
                                                <input for="remark" type="radio" class="form-check-input2 listener"
                                                    id="remark_{{ $question->id }}_2"
                                                    data-section-id="{{ $section->id }}"
                                                    data-subsection-id="{{ $subsection->id }}"
                                                    data-question-id="{{ $question->id }}" data-value="false"
                                                    data-type="checkbox" name="answer[{{ $question->id }}][remark]" 
                                                    value="0"
                                                    {{ old('remark_' . $question->id . '_2') == '0' ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <textarea type="text" for="note" class="form-control listener" rows="4" id="note_{{ $question->id }}"
                                                    data-section-id="{{ $section->id }}" data-subsection-id="{{ $subsection->id }}"
                                                    data-question-id="{{ $question->id }}" data-type="note" name="answer[{{ $question->id }}][note]"></textarea></textarea>
                                            </td>
                                        </tr>
                                    @else
                                        {{-- <div class="card mb-4"> --}}
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <label for="question">{{ $question->question }}<span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="answer[{{ $question->id }}][image]"
                                                    class="form-control mb-4" id="image" accept=".jpg, .jpeg, .png"
                                                    placeholder="Masukkan file foto" required>
                                                <small class="form-text" style="color: red;">File yang diperbolehkan: JPG,
                                                    JPEG, PNG.</small>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

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
    {{-- <script src="{{ asset('js/datatables-simple-demo.js') }}"></script> --}}
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mendapatkan referensi tombol "Cancel"
            var cancelButton = document.getElementById("cancelButton");

            // Menambahkan event listener untuk meng-handle klik tombol "Cancel"
            cancelButton.addEventListener("click", function() {
                // Merefresh halaman
                location.reload();
            });
        });
    </script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#auditor_name').change(function() {
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
                    line: $('#line').val(),
                    vendor: $('#vendor').val(),
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


            $('form').submit(function(event) {
                // Mencari input catatan untuk radio button yang dipilih "No"
                var emptyNotes = $('input[type="text"]').filter(function() {
                    // Mendapatkan nilai dari radio button "Yes" atau "No" yang terpilih
                    var radioValue = $(this).closest('tr').find('input[type="radio"]:checked')
                        .val();
                    // Memeriksa apakah radio button yang dipilih adalah "No" dan catatan kosong
                    return radioValue === '0' && !this.value.trim();
                });

                // Jika ada catatan yang belum diisi untuk radio button yang dipilih "No"
                if (emptyNotes.length) {
                    // Mencegah pengiriman formulir
                    event.preventDefault();

                    // Mendapatkan pertanyaan terkait dari atribut data-question-id
                    var questionId = emptyNotes.closest('tr').find('td[data-question-id]').data(
                        'question-id');
                    var questionText = $('td[data-question-id="' + questionId + '"]').text();

                    // Menampilkan pesan peringatan dengan teks pertanyaan yang terkait
                    alert('Silakan isi catatan untuk pertanyaan: ' + questionText);

                    // Mengarahkan fokus ke input catatan yang belum diisi
                    emptyNotes.first().focus();
                }
            });
        });
    </script>
    <script>
        const formName = 'k2fa';
    
        $(document).ready(function() {
            const data = {!! json_encode($sections->toArray()) !!};
    
            // create draft / assign draft to form
            function formDraft() {
                const getItem = localStorage.getItem('form') || null;
                const dataStorage = getItem ? JSON.parse(getItem) : null;
                const dataStorageSelected = dataStorage ? dataStorage[formName] : null;
    
                if (!dataStorageSelected) {
                    const formData = [];
    
                    data?.forEach((item, index) => {
                        const dataPage = {
                            id: item?.id || '',
                            page: index + 1,
                            sections: []
                        };
    
                        item?.subsections?.forEach((section, indexSection) => {
                            const dataSection = {
                                id: section?.id || '',
                                section: indexSection + 1,
                                questions: []
                            }
    
                            section?.questions?.forEach((question, indexQuestion) => {
                                const dataQuestion = {
                                    id: question?.id || '',
                                    question: indexQuestion + 1,
                                    type: 'checkbox',
                                    answer: '',
                                    note: ''
                                }
    
                                dataSection.questions.push(dataQuestion);
                            })
    
                            dataPage.sections.push(dataSection);
                        });
    
                        formData.push(dataPage);
                    })
    
                    localStorage.setItem('form', JSON.stringify({
                        ...dataStorage,
                        [formName]: formData
                    }))
                } else {
                    const dataStorageSelected = dataStorage[formName];
    
                    dataStorageSelected?.forEach(item => item.sections.forEach(section => section.questions.forEach(
                        question => {
                            if (question.type === 'checkbox') {
                                const id = question.id || '';
                                const answer = question.answer || '';
                                const note = question.note || '';
    
                                switch (answer) {
                                    case 'true':
                                        $(`#remark_${id}_1`).prop('checked', true);
                                        break;
    
                                    case 'false':
                                        $(`#remark_${id}_2`).prop('checked', true);
                                        break;
    
                                    default:
                                        break;
                                }
                                if (note) $(`#note_${id}`).text(note)
                            }
                        })));
                }
            }
    
            // reset draft
            function resetDraft() {
                const getItem = localStorage.getItem('form') || null;
                const dataStorage = JSON.parse(getItem);
    
                localStorage.setItem('form', JSON.stringify({
                    ...dataStorage,
                    [formName]: null
                }));
                formDraft()
            }
    
            formDraft();
    
            // set form to draft
            $('.listener').change((e) => {
                const getItem = localStorage.getItem('form') || null;
                const dataStorage = JSON.parse(getItem);
                const dataStorageSelected = dataStorage[formName];
    
                const {
                    type,
                    sectionId,
                    subsectionId,
                    questionId,
                    value
                } = Object.assign({}, e.target.dataset)
    
                const formData = [];
    
                dataStorageSelected?.forEach(item => {
                    const dataPage = {
                        ...item,
                        sections: []
                    };
                    item?.sections?.forEach(section => {
                        const dataSection = {
                            ...section,
                            questions: []
                        };
    
                        section?.questions?.forEach(question => {
                            const selectedQuestion = item.id == sectionId && section
                                .id == subsectionId && question.id == questionId;
    
                            dataSection.questions.push({
                                ...question,
                                answer: selectedQuestion && type ===
                                    'checkbox' ? value : question.answer,
                                note: selectedQuestion && type === 'note' ?
                                    e.target.value : question.note
                            });
                        })
    
                        dataPage.sections.push(dataSection);
                    });
    
                    formData.push(dataPage);
                })
    
                localStorage.setItem('form', JSON.stringify({
                    ...dataStorage,
                    [formName]: formData
                }))
            })
        })
    </script>
@endpush
