@extends('layouts.supplier.layout-supp')
@section('content-supplier')
    <main class="my-5">
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Detail Audit Supplier
                </div>
                <div class="card-body">
                    <h4 class="fw-bold">Auditor Data</h4>


                    <div class="my-3">
                        <div class="table-responsive">
                            <table class="table table-primary table-bordered w-175">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">PT Name</th>
                                        <th scope="col">Today audited</th>
                                        <th scope="col">Audit Score</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td>
                                            {{ Carbon\Carbon::parse($data[0]->created_at)->isoFormat('dddd, D MMMM Y') }}
                                        </td>
                                        <td scope="row">{{ $auditor->pt }}</td>
                                        <td>{{ count($data) }}</td>
                                        <td>
                                            @foreach ($dataForView as $sect)
                                            <ul>
                                                @foreach ($sect['scores'] as $sectionName => $score)
                                                    <li>
                                                        {{ $sectionName }}: {{ round ($score['average_score']) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                        </td>


                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <hr>
                    <h4 class="fw-bold">Audit Data</h4>
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>Section</th>
                                <th>Question</th>
                                <th>Remark</th>
                                <th>Part</th>
                                <th>Problem</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $previousSubsectionTitle = ''; @endphp
                            @foreach ($data as $answer)
                                @if ($answer->questions->type != 'image')
                                    @if ($previousSubsectionTitle != $answer->questions->subsection->title)
                                        <tr>
                                            <td colspan="12" style="font-weight: bold;">
                                                {{ $answer->questions->subsection->title }}
                                            </td>
                                        </tr>
                                        @php $previousSubsectionTitle = $answer->questions->subsection->title; @endphp
                                    @endif
                                @endif
                                <tr @if ($answer->mark < 100) style="background-color: rgb(217, 89, 89);" @endif>
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{ $answer->questions->subsection->sections->id}}</td>
                                    <td>{{ $answer->questions->question }}</td>
                                    <td>
                                        @if ($answer->questions->type != 'image')
                                            {{ $answer->mark }}
                                        @else
                                            @if ($answer->image)
                                                <a href="{{ asset('storage/' . $answer->image) }}"
                                                    data-lightbox="answer-images">
                                                    <img src="{{ asset('storage/' . $answer->image) }}"
                                                        style="max-width: 95px; max-height: 95px; cursor: pointer;"
                                                        alt="Answer Image" class="img-fluid zoomable-image"
                                                        onmouseover="zoomIn(this)" onmouseout="zoomOut(this)">
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $answer->questions->subsection->sections->part->part_name }}</td>
                                    <td>{{ $answer->questions->subsection->sections->problem }}</td>
                                    <td style="width: 250px;">{{ $answer->notes ?? '-' }}</td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script>
        function zoomIn(image) {
            image.style.transform = "scale(3)";
            image.style.trasition = "transform 0.5s";
        }

        function zoomOut(image) {
            image.style.transform = "scale(1)";
            image.style.trasition = "transform 0.5s";
        }
    </script>
@endpush
