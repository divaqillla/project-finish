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
                            <table class="table table-primary table-bordered w-75">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Auditor Name</th>
                                        <th scope="col">Auditor Level</th>
                                        <th scope="col">Part Name</th>
                                        <th scope="col">Today audited</th>
                                        <th scope="col">Audit Score</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td>{{ Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</td>
                                        <td scope="row">{{ $auditor->name }}</td>
                                        <td>{{ $auditor->role }}</td>
                                        <td>{{ $auditor->supp_answers[0]->questions->subsection->sections->part->part_name }}
                                        </td>
                                        <td>{{ count($data->supp_answers) }}</td>
                                        <td>{{ round($auditor->supp_answers->sum('mark') / $totalQuestion, 1) }}</td>

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
                                <th>#</th>
                                <th>Question</th>
                                <th>Remark</th>
                                <th>Note</th>
                                <th>Line</th>
                                <th>Vendor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $previousSubsectionTitle = ''; @endphp
                            @foreach ($data->supp_answers as $supp_answers)
                                @if ($supp_answers->questions->type != 'image')
                                    @if ($previousSubsectionTitle != $supp_answers->questions->subsection->title)
                                        <tr>
                                            <td colspan="4" style="font-weight: bold;">
                                                {{ $supp_answers->questions->subsection->title }}
                                            </td>
                                        </tr>
                                        @php $previousSubsectionTitle = $supp_answers->questions->subsection->title; @endphp
                                    @endif
                                @endif
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $supp_answers->questions->question }}</td>
                                    <td>
                                        @if ($supp_answers->questions->type != 'image')
                                            {{ $supp_answers->mark }}
                                        @else
                                            @if ($supp_answers->image)
                                                <a href="{{ asset('storage/' . $supp_answers->image) }}"
                                                    data-lightbox="answer-images">
                                                    <img src="{{ asset('storage/' . $supp_answers->image) }}"
                                                        style="max-width: 95px; max-height: 95px; cursor: pointer;"
                                                        alt="Answer Image" class="img-fluid zoomable-image"
                                                        onmouseover="zoomIn(this)" onmouseout="zoomOut(this)">
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="width: 250px;">{{ $supp_answers->notes ?? '-' }}</td>
                                    <td>{{ $supp_answers->line ?? '-' }}</td>
                                    <td>{{ $supp_answers->vendor ?? '-' }}</td>
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

@endpush
<script src="path/to/lightbox.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'showImageNumberLabel': false,
        'showDownloadButton': true,
        'downloadButtonText': 'Download'
    });
</script>
<script>
    function zoomIn(image) {
        image.style.transform = "scale(3)";
        image.style.transition = "transform 0.5s";
    }

    function zoomOut(image){
        image.style.transform = "scale(1)";
        image.style.transition = "transform 0.5s";
    }
</script>
@endpush
