@extends('layouts.template')
@section('content')
    <form id="form_machining" method="post" action="{{ route('answer.answerEmptyMachining') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">
            <div class="card mb-4">
                <div class="card-body">
                    {{-- Auditor Name Select Option --}}
                    <input type="hidden" name="auditor_id" value="{{ $auditors['auditors']->id }}">
                    <div class="form-group">
                        <label for="auditor_id" class="mb-3" style="font-size: 20px; font-weight: bold;">Auditor Name
                            <span class="text-danger">*</span></label>

                        <input type="text" class="form-control mb-3" value="{{ $auditors['auditors']->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role" class="mb-3" style="font-size: 20px; font-weight: bold;">Auditor
                            Level
                            <span class="text-danger">*</span></label>
                        <input name="role" id="role" class="form-control mb-4"
                            value="@if (Auth::user()->role == 4) Section Head
                        @elseif (Auth::user()->role == 5)Dept Head
                        @else
                            Div Head @endif"
                            readonly>
                    </div>




                    {{-- To Show Area Process --}}
                    <label for="area" class="mb-3" style="font-size: 20px; font-weight: bold;">Line / Process<span
                            class="text-danger">*</span> </label>
                    <br>
                    <label for="area">{{ $sections[0]->area }}</label>
                </div>
            </div>
            @php
                $today = \Carbon\Carbon::today()->format('Y-m-d');
            @endphp

            <div class="form-group mb-3">
                <label for="my-input" class="fw-bold">Empty Passed Day</label>
                <select id="my-input" class="form-control bg-light" name="previous_day">
                    @foreach ($allDates as $date)
                        @if ($date['dates'] !== $today)
                            <option value="{{ $date['dates'] }}">
                                {{ \Carbon\Carbon::parse($date['dates'])->isoFormat('dddd, D MMMM Y') }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Card Question --}}
        {{-- @if ($auditors['keterangan'] == 'You\'re able to do this Audit') --}}
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
                                            <td style="width: 200px;">
                                                <input for="remark" type="radio" class="form-check-input1 listener"
                                                    id="remark_{{ $question->id }}_1"
                                                    data-section-id="{{ $section->id }}"
                                                    data-subsection-id="{{ $subsection->id }}"
                                                    data-question-id="{{ $question->id }}" data-value="true"
                                                    data-type="checkbox" name="answer[{{ $question->id }}][remark]"
                                                    value="100"
                                                    {{ old('remark_' . $question->id . '_1') == '1' ? 'checked' : '' }}>
                                            </td>
                                            <td style="width: 200px;">
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
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <label for="question">{{ $question->question }}<span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="answer[{{ $question->id }}][image]"
                                                    class="form-control mb-4" id="image" accept=".jpg, .jpeg, .png"
                                                    placeholder="Masukkan file foto" required>
                                                <small class="form-text" style="color: red;">File yang diperbolehkan:
                                                    JPG, JPEG, PNG.</small>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
        <button type="button" id="cancelButton" class="btn btn-secondary btn-lg btn-block">Cancel</button>
        {{-- @endif --}}


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
        const formName = 'machining';

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
    <script>
        // Ketika nilai name berubah
        $('#name').on('input', function() {
            var auditorName = $(this).val();
            // Lakukan permintaan AJAX untuk mencari auditor_id berdasarkan nama auditor
            $.ajax({
                type: 'GET',
                url: '/search/auditor',
                data: {
                    name: auditorName
                },
                success: function(response) {
                    // Jika auditor_id ditemukan, perbarui nilai input tersembunyi
                    if (response.success) {
                        $('#auditor_id').val(response.auditor_id);
                    } else {
                        // Jika tidak ada hasil, atur nilai input tersembunyi menjadi kosong
                        $('#auditor_id').val('');
                    }
                }
            });
        });
    </script>
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

            // Function to check the selected radio button and set the textarea required attribute
            function checkRadioButtons() {
                $('input[type=radio]').each(function() {
                    const questionId = $(this).data('question-id');
                    const textarea = $('#note_' + questionId);

                    if ($(this).is(':checked') && $(this).val() == '0') {
                        textarea.prop('required', true);
                    } else if ($(this).is(':checked')) {
                        textarea.prop('required', false);
                    }
                });
            }

            // Run the check function on page load to ensure correct state
            checkRadioButtons();

            // Run the check function when a radio button is changed
            $('input[type=radio]').change(function() {
                checkRadioButtons();
            });
            $('#form_machining').on('submit', function(e) {
                let fileNames = new Set();
                let isValid = true;
                let firstDuplicateInput = null;

                $('input[type=file]').each(function() {
                    const fileInput = $(this);
                    const fileName = fileInput.val().split('\\').pop();

                    // Remove any previous highlighting
                    fileInput.css('border', '');

                    if (fileNames.has(fileName)) {
                        alert('Upload gambar harus file yang berbeda.');
                        isValid = false;

                        // Highlight the duplicate file input field
                        fileInput.css('border', '2px solid red');

                        // Focus on the first duplicate input field
                        if (!firstDuplicateInput) {
                            firstDuplicateInput = fileInput;
                        }
                    }
                    fileNames.add(fileName);

                    // Check file date
                    const file = fileInput[0].files[0];
                    const currentDate = new Date();
                    const fileDate = new Date(file.lastModified);
                    const threeDaysAgo = new Date(currentDate.setDate(currentDate.getDate() - 3));

                    if (fileDate < threeDaysAgo) {
                        alert('File gambar harus diunggah maksimal 3 hari sebelum hari ini.');
                        isValid = false;

                        // Highlight the old file input field
                        fileInput.css('border', '2px solid red');

                        // Focus on the old file input field
                        if (!firstDuplicateInput) {
                            firstDuplicateInput = fileInput;
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault(); // Prevent form submission if not valid
                    if (firstDuplicateInput) {
                        firstDuplicateInput.focus();
                    }
                }
            });

            // Validate form submission
            $('#form_machining').on('submit', function(e) {
                let isValid = true;

                // Check each radio group
                $('input[type=radio]').each(function() {
                    const questionId = $(this).data('question-id');
                    const textarea = $('#note_' + questionId);

                    if ($(this).is(':checked') && $(this).val() == '0' && textarea.val().trim() ===
                        '') {
                        alert('Please fill out the textarea for question ' + questionId);
                        textarea.focus();
                        isValid = false;
                        return false; // Break the loop
                    }
                });

                if (!isValid) {
                    e.preventDefault(); // Prevent form submission if not valid
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mendapatkan referensi tombol "Cancel"
            var cancelButton = document.getElementById("cancelButton");

            // Menambahkan event listener untuk meng-handle klik tombol "Cancel"
            cancelButton.addEventListener("click", function() {
                // Merefresh halaman
                location.reload();
            });
        });
    </script>
@endpush
