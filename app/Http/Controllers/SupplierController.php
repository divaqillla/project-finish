<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use App\Models\SuppAnswer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
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

        $auth = Auth::guard('suppliers')->user();
        // dd($auth);


        $monthlySupplier = SuppAnswer::with(['auditors', 'auditors.answers'])
            ->join('suppliers', 'supp_answer.auditor_id', '=', 'suppliers.id')
            ->join('questions', 'supp_answer.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('DATE(supp_answer.created_at) as audit_date, suppliers.pt')
            ->where('sections.area', 'Supplier')
            ->whereBetween('supp_answer.created_at', [$startDate, $endDate])
            ->groupBy('audit_date','suppliers.pt')
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
            ->where('id',$auth->id)
            ->get()
            ->groupBy('pt');

            // dd($auditorsSupplier);


            $dataForView = [];

            foreach ($auditorsSupplier as $pt => $suppliers) {
                $sectionsScores = [];
            
                foreach ($suppliers as $supplier) {
                    foreach ($supplier->supp_answers as $answer) {
                        // Assuming $answer has a date attribute to check
                        if ($answer->created_at->isSameDay($today)) {
                            $section = $answer->questions->subsection->sections;
                            $sectionName = $section->id;
            
                            if (!isset($sectionsScores[$sectionName])) {
                                $sectionsScores[$sectionName] = [
                                    'total_marks' => 0,
                                    'questions_count' => 0,
                                ];
                            }
            
                            $sectionsScores[$sectionName]['total_marks'] += $answer->mark;
                            $sectionsScores[$sectionName]['questions_count']++;
                        }
                    }
                }
            
                $scores = [];
                foreach ($sectionsScores as $sectionName => $scoresData) {
                    $averageScore = $scoresData['total_marks'] / $scoresData['questions_count'];
                    $scores[$sectionName] = $averageScore;
                }
            
                if (!empty($scores)) {  // Ensure that only non-empty scores are added
                    $dataForView[] = [
                        'pt' => $pt,
                        'scores' => $scores,
                    ];
                }
            }

        

        


        return view('layouts.supplier.dashboardSupplier', compact('auditorsSupplier', 'sectionId',  'subsectionId', 'questionId', 'answerId', 'judul', 'monthlySupplier', 'dataForView'));
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
        return view('layouts.supplier.detailSupplier', compact('judul', 'data', 'totalQuestion', 'auditor'));
    }

    public function SupplierHistory(Request $request)
    {
        $judul = "SUPPLIER HISTORY";
        $auth = Auth::guard('suppliers')->user();

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

        $query->whereAuditorId($auth->id)->orderByDesc('created_at');
        $data = $query->get()->groupBy('date')->map(function ($items) {
            return [
                'date' => $items->first()->date,
                'auditors' => $items->pluck('auditors')->unique(), // Mengambil auditor_id yang unik
            ];
        });

        // dd($data);


        return view('layouts.supplier.SupplierHistory', compact('judul', 'data', 'request'));
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
            // dd($sectionsScores);

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
        return view('layouts.supplier.detailSupplierHistory', compact(['judul', 'data', 'auditor', 'totalQuestion', 'dataForView']));
    }


    // Supplier PT. DMI
    public function createBasetator()
    {
        $judul = "CHECKSHEET SUPPLIER-PT DM INDONESIA";
        $sections = Section::with(['subsections'], ['parts'])->whereIn('id', [12])->get();
        $today = Carbon::today();

        $auth = Auth::guard('suppliers')->user();
        $auditorIds = $auth->id; // Ganti dengan daftar ID auditor yang Anda inginkan
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $auditors = Supplier::withCount(['supp_answers as answers_count' => function ($query) {
            $query->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Supplier');
            });
        }])
            ->find($auditorIds);

        $auditors = $this->auditorsAudit($auditorIds);



        // dd($sections);
        return view('basestator', compact('judul', 'sections', 'auditors'));
    }

    // Supplier PT. Menara Adi Cipta
    public function createK1aa()
    {

        $judul = "CHECKSHEET SUPPLIER - PT MENARA ADI CIPTA";

        $sections = Section::with(['subsections'], ['parts'])->whereIn('id', [13, 14, 23, 15, 24, 25, 26])->get();
        $today = Carbon::today();

        $auth = Auth::guard('suppliers')->user();
        $auditorIds = $auth->id; // Ganti dengan daftar ID auditor yang Anda inginkan
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $auditors = Supplier::withCount(['supp_answers as answers_count' => function ($query) {
            $query->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Supplier');
            });
        }])
            ->find($auditorIds);

        $auditors = $this->auditorsAudit($auditorIds);




        return view('k1aa', compact('judul', 'sections', 'auditors'));
    }



    // Supplier PT. Kurnia ManunggalSejahera
    public function createK2fa()
    {

        $judul = "CHECKSHEET SUPPLIER - PT KURNIA MANUNGGAL SEJAHTERA";
        $sections = Section::with(['subsections'], ['parts'])->whereIn('id', [14, 23, 15, 24, 25, 26])->get();
        $today = Carbon::today();

        $auth = Auth::guard('suppliers')->user();
        $auditorIds = $auth->id; // Ganti dengan daftar ID auditor yang Anda inginkan
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $auditors = $this->auditorsAudit($auditorIds);



        return view('k2fa', compact('judul', 'sections', 'auditors'));
    }

    // Supplier PT. RPA
    public function createRailRear()
    {
        $judul = "CHECKSHEET SUPPLIER - PT RACHMAT PERDANA ADHIMETAL";
        $sections = Section::with(['subsections'], ['parts'])->whereIn('id', [16])->get();
        $jsonSections = json_encode($sections->toArray());
        // dd($jsonSections);
        $today = Carbon::today();

        $auth = Auth::guard('suppliers')->user();
        $auditorIds = $auth->id; // Ganti dengan daftar ID auditor yang Anda inginkan
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $auditors = $this->auditorsAudit($auditorIds);




        return view('railrear', compact('judul', 'sections', 'auditors', 'jsonSections'));
    }

    // Supplier PT. GPU
    public function createOilpump()
    {
        $judul = "CHECKSHEET SUPPLIER - PT GPU";
        $sections = Section::with(['subsections.questions'], ['parts'])->whereIn('id', [27])->get();

        // dd($sections);
        $today = Carbon::today();

        $auth = Auth::guard('suppliers')->user();
        $username = $auth->username;
        // $auditorIds = $auth->id; // Ganti dengan daftar ID auditor yang Anda inginkan
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        // $auditors = $this->auditorsAudit($auditorIds);


        return view('oilpump', compact('judul', 'sections', 'username'));
    }



    public function auditorsAudit($auditorIds)
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();



        $auditors = Supplier::withCount(['supp_answers as answers_count' => function ($query) use ($today) {
            $query->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Supplier');
            })->whereDate('created_at', $today);
        }])
            ->find($auditorIds);

        // dd($auditors);

        if ($auditors->answers_count == 0) {
            $auditors = [
                'status' => 1,
                'auditors' => $auditors,
                'keterangan' => 'You\'re able to do this Audit'
            ];
        } else {
            $auditors = [
                'status' => 2,
                'auditors' => $auditors,
                'keterangan' => 'You\'ve audited ' . $auditors->supp_answers->first()->questions->subsection->sections->area . ' Today (' . Carbon::now()->toDateString() . ')'
            ];
        }

        // if()




        return $auditors;
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

    public function showForm()
    {
        $user = Auth::guard('suppliers')->user();

        if ($user->pt !== 'PT DM Indonesia') {
            // Redirect or abort with a 403 Forbidden response
            return redirect()->route('checksheetsupp')->with('error', 'You are not authorized to access this form.');
        }

        return view('checksheetsupp');
    }
}
