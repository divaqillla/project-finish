<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Section;
use App\Models\Question;
use App\Models\Supplier;
use App\Models\Subsection;
use App\Models\SuppAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SupplierInternalController extends Controller
{
    public function supplier(Request $request)
    {
        $judul = "DASHBOARD SUPPLIER";
        $sectionId = Section::with(['subsections'], ['parts'])->where('part_id', 1)->get()->pluck('id')->toArray();
        $subsectionId = Subsection::whereIn('section_id', $sectionId)->get()->pluck('id')->toArray();
        $questionId = Question::whereIn('subsection_id', $subsectionId)->get()->pluck('id')->toArray();
        $answerId = SuppAnswer::whereIn('question_id', $questionId)->get();

        $today = Carbon::now()->today();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();



        $monthlySupplier = SuppAnswer::with(['auditors', 'auditors.answers'])
            ->join('suppliers', 'supp_answer.auditor_id', '=', 'suppliers.id')
            ->join('questions', 'supp_answer.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('DATE(supp_answer.created_at) as audit_date, suppliers.pt')
            ->where('sections.area', 'Supplier')
            ->whereBetween('supp_answer.created_at', [$startDate, $endDate])
            ->groupBy('audit_date', 'suppliers.pt')
            ->get()
            ->groupBy('audit_date')
            ->map(function ($dailyData) {
                $auditCounts = $dailyData->groupBy('pt')->map->count();
                return [
                    'data' => $auditCounts,
                ];
            })->toArray();


        $auditorsSupplier = Supplier::whereHas('supp_answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->with('supp_answers.questions.subsection.sections')
            ->withCount(['supp_answers' => function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Supplier');
                    });
            }])
            ->whereHas('supp_answers', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Supplier');
                    });
                $query->whereDate('created_at', $today);
                // Tambahkan kondisi tambahan ke dalam relasi answers
            })
            ->get()
            ->groupBy('pt');




        $dataForView = [];

        foreach ($auditorsSupplier as $pt => $suppliers) {
            $sectionsScores = [];

            foreach ($suppliers as $supplier) {
                foreach ($supplier->supp_answers as $answer) {
                    $section = $answer->questions->subsection->sections;
                    // dd($section);
                    $sectionName = $section->id;


                    if (!isset($sectionsScores[$sectionName])) {
                        $sectionsScores[$sectionName] = [
                            'total_marks' => 0,
                            'questions_count' => 0,
                        ];
                    }

                    // dd($sectionsScores[$sectionName]);

                    $sectionsScores[$sectionName]['total_marks'] += $answer->mark;
                    $sectionsScores[$sectionName]['questions_count']++;
                }
            }

            $scores = [];
            foreach ($sectionsScores as $sectionName => $scoresData) {
                $averageScore = $scoresData['total_marks'] / $scoresData['questions_count'];
                $scores[$sectionName] = $averageScore;
            }





            $dataForView[] = [
                'pt' => $pt,
                'scores' => $scores,
            ];
        }



        $mark = DB::table('supp_answer')
            ->join('questions', 'supp_answer.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->join('suppliers', 'supp_answer.auditor_id', '=', 'suppliers.id') // Join the suppliers table
            ->select('suppliers.pt', DB::raw('SUM(supp_answer.mark) as total_mark')) // Select the pt column
            ->where('sections.area', 'Supplier')
            ->whereDate('supp_answer.created_at', $today)
            ->groupBy('suppliers.pt') // Group by the pt column
            ->get();

        // dd($mark);



        $totalQuestion5 = DB::table('supp_answer')
            ->join('questions', 'supp_answer.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->join('suppliers', 'supp_answer.auditor_id', '=', 'suppliers.id') // Join the suppliers table
            ->whereIn('questions.subsection_id', [37])
            ->whereDate('supp_answer.created_at', $today)
            ->select('suppliers.pt', DB::raw('COUNT(DISTINCT questions.id) as total')) // Select the pt column
            ->groupBy('suppliers.pt') // Group by the pt column
            ->get();

        // dd($totalQuestion5);

        $totalSection = count(Section::whereArea('Supplier')->get());
        // $totalQuestion = count(Question::whereIn('subsection_id', [23, 24])->get());
        $totalQuestion1 = count(Question::whereIn('subsection_id', [59])->get()); //oil pump part_id 9 : PT. GPU
        $totalQuestion2 = count(Question::whereIn('subsection_id', [25, 26])->get()); //basestator part_id 10 : PT DMI
        $totalQuestion3 = count(Question::whereIn('subsection_id', [30, 31, 32, 53, 33, 34, 35, 36, 38, 54, 55, 56, 57, 58])->get()); //cover side k2fa part_id 11 : PT KMS
        $totalQuestion4 = count(Question::whereIn('subsection_id', [27, 28, 29, 30, 31, 32, 53, 33, 34, 35, 36, 38, 54, 55, 56, 57, 58])->get()); //cover l side k1aa part_id : PT MAC

        $score = [];
        foreach ($mark as $markItem) {
            foreach ($totalQuestion5 as $questionItem) {
                if ($markItem->pt == $questionItem->pt) {
                    $score[$markItem->pt] = $markItem->total_mark / $questionItem->total;
                    break;
                }
            }
        }

        // dd($dataForView);


        return view('layouts.supplier-internal.internal-dashboardSupplier', compact('auditorsSupplier', 'sectionId',  'subsectionId', 'questionId', 'answerId', 'totalSection', 'totalQuestion1', 'totalQuestion2', 'totalQuestion3', 'totalQuestion4', 'totalQuestion5', 'judul', 'monthlySupplier', 'score', 'dataForView'));
    }


    public function detailSupplierToday($id)
    {
        $judul = "DETAIL HISTORY AUDIT Supplier";
        $today = Carbon::now()->today();
        $auditor = SuppAnswer::find($id);
        // $data = $auditor->answers()->whereDate('created_at',$today)->get();

        $data = SuppAnswer::with(['supp_answers' => function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereHas('questions.subsection.sections', function ($query) {
                    $query->where('area', 'Supplier');
                });
        }, 'supp_answers.questions.subsection.sections'])->find($id);



        $totalQuestion = count(Question::whereIn('subsection_id', [23, 24])->get());
        return view('layouts.supplier-internal.internal-detailSupplier', compact('judul', 'data', 'totalQuestion', 'auditor'));
    }

    public function SupplierHistory(Request $request)
    {
        $judul = "SUPPLIER HISTORY";

        $query = SuppAnswer::selectRaw('DATE(created_at) as date, auditor_id')
            ->whereHas('questions.subsection.sections', function ($query) use ($request) {
                $query->where('area', 'Supplier');
                if ($request->filled('part_id')) {
                    $query->where('part_id', $request->part_id);
                }
            });

        // Menambahkan kondisi tanggal jika ada
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $query->orderByDesc('created_at');
        $data = $query->get()->groupBy('date')->map(function ($items) {
            return [
                'date' => $items->first()->date,
                'auditors' => $items->pluck('auditors')->unique(), // Mengambil auditor_id yang unik
            ];
        });

        // dd($data);


        return view('layouts.supplier-internal.internal-SupplierHistory', compact('judul', 'data', 'request'));
    }


    public function detaillSupplierHistory($date, $id_user)
    {
        $judul = "DETAIL SUPPLIER HISTORY";
        $today = $date;
        // $today = Carbon::now();
        // dd($date);

        $sections = Section::whereHas('subsections.questions.supp_answers', function ($query) use ($today, $id_user) {
            $query->whereDate('created_at', $today)->whereAuditorId($id_user);
        })->with('subsections.questions.supp_answers.auditors')
            ->whereArea('Supplier')->get();

        $groupedByPT = $sections->flatMap(function ($section) use ($today) {
            return $section->subsections->flatMap(function ($subsection) use ($today) {
                return $subsection->questions->flatMap(function ($question) use ($today) {
                    return $question->supp_answers()
                        ->whereDate('created_at', $today)
                        ->get()
                        ->map(function ($answer) {
                            return [
                                'pt' => optional($answer->auditors)->pt, // Use optional to avoid errors if auditor is not present
                                'section' => $answer->questions->subsection->sections->id,
                                'mark' => $answer->mark,
                                'created_at' => $answer->created_at, // Include created_at
                            ];
                        });
                });
            });
        })->groupBy('pt');




        $dataForView = $groupedByPT->map(function ($answers, $pt) {
            $sectionsScores = [];

            foreach ($answers as $answer) {
                $sectionName = $answer['section'];
                $createdAt = $answer['created_at'];

                if (!isset($sectionsScores[$sectionName])) {
                    $sectionsScores[$sectionName] = [
                        'total_marks' => 0,
                        'questions_count' => 0,
                        'created_at' => $createdAt, // Initialize with the created_at value of the first answer
                    ];
                }

                $sectionsScores[$sectionName]['total_marks'] += $answer['mark'];
                $sectionsScores[$sectionName]['questions_count']++;

                // Update the created_at to ensure the latest date is captured (if needed)
                if ($answer['created_at'] > $sectionsScores[$sectionName]['created_at']) {
                    $sectionsScores[$sectionName]['created_at'] = $answer['created_at'];
                }
            }

            $scores = [];
            foreach ($sectionsScores as $sectionName => $scoresData) {
                $averageScore = $scoresData['total_marks'] / $scoresData['questions_count'];
                $scores[$sectionName] = [
                    'average_score' => $averageScore,
                    'created_at' => $scoresData['created_at'],
                ];
            }

            return [
                'pt' => $pt,
                'scores' => $scores,
            ];
        })->values();



        // dd($dataForView);




        // dd($auditor->supp_answers);
        $auditor = Supplier::find($id_user);

        $namaPt = $auditor->pt;

        $this->cekPt($namaPt);


        $subsectionId = $this->cekPt($namaPt);



        $subsectionIds = is_array($subsectionId) ? $subsectionId : [$subsectionId];
        $totalQuestion = Question::whereIn('subsection_id', $subsectionIds)->count();

        // dd($totalQuestion);

        $data = $auditor->supp_answers()->whereDate('created_at', $date)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Supplier');
            })->with('questions.subsection.sections')
            ->get();


        // $dataPerSect = [];
        // foreach($data as)
        //     dd($data);
        return view('layouts.supplier-internal.internal-detailSupplierHistory', compact(['judul', 'data', 'auditor', 'totalQuestion', 'dataForView']));
    }


    public function cekPt($ptName)
    {

        switch ($ptName) {

            case 'PT Kurnia Manunggal Sejahtera';


                $subsectionId = [30, 31, 32, 53, 33, 34, 35, 36, 38, 54, 55, 56, 57, 58];


                return $subsectionId;
                break;


            case 'PT Gpu';


                $subsectionId = [59];


                return $subsectionId;
                break;


            case 'PT Dm Indonesia';

                $subsectionId = [25, 26];


                return $subsectionId;


                break;

            case 'PT Menara Adi Cipta';

                $subsectionId = [27, 28, 29, 30, 31, 32, 53, 33, 34, 35, 36, 38, 54, 55, 56, 57, 58];


                return $subsectionId;

                break;

            case 'PT Rachmat Perdana Adhimetal';


                $subsectionId = [37];


                return $subsectionId;


                break;
        }
    }
}
