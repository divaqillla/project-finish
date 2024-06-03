<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CastingController extends Controller
{



    public function casting(Request $request)
    {

        $judul = "DASHBOARD CASTING";
        $subJudul = "Casting";
        $sectionId = Section::with(['subsections'], ['parts'])->where('part_id', 1)->get()->pluck('id')->toArray();
        $subsectionId = Subsection::whereIn('section_id', $sectionId)->get()->pluck('id')->toArray();
        $questionId = Question::whereIn('subsection_id', $subsectionId)->get()->pluck('id')->toArray();
        $answerId = FixAnswer::whereIn('question_id', $questionId)->get();

        $today = Carbon::now()->today();

        $monthlyCasting = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('users', 'fix_answers.auditor_id', '=', 'users.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('users.name, sections.area, COUNT(DISTINCT DATE(fix_answers.created_at)) as total_days_with_audit')
            ->where('sections.area', 'Casting HPDC ')
            ->groupBy('users.name', 'sections.area')
            ->get();




        $auditorsCasting = User::whereHas('answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->with(['answers' => function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Casting HPDC');
                    });
            }])
            ->whereHas('answers', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Casting HPDC');
                    });
                $query->whereDate('created_at', $today);

                // Tambahkan kondisi tambahan ke dalam relasi answers
            })
            ->get();

        
            $mark = DB::table('fix_answers')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->select('sections.id as section_id', DB::raw('SUM(fix_answers.mark) as total_mark'))
            ->where('sections.area', 'Casting HPDC')
            ->whereDate('fix_answers.created_at', $today)
            ->groupBy('sections.id')
            ->get();
        // dd($mark);

        $totalQuestion = DB::table('fix_answers')
        ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
        ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
        ->join('sections', 'subsections.section_id', '=', 'sections.id')
        ->whereIn('questions.subsection_id', [1, 2, 3, 4, 5, 7, 8, 39])
        ->whereDate('fix_answers.created_at', $today)
        ->select('sections.id as section_id', DB::raw('COUNT(DISTINCT questions.id) as total'))
        ->groupBy('sections.id')
        ->get();

        // dd($totalQuestion);

        $score = [];
    foreach ($mark as $markItem) {
        foreach ($totalQuestion as $questionItem) {
            if ($markItem->section_id == $questionItem->section_id) {
                $score[$markItem->section_id] = $markItem->total_mark / $questionItem->total;
                break;
            }
        }
    }


        return view('layouts.casting.dashboardcasting', compact('sectionId', 'auditorsCasting', 'subsectionId', 'questionId', 'answerId', 'mark', 'score', 'totalQuestion', 'judul', 'monthlyCasting','today'));
    }




    public function detailCastingToday($id)
    {

        $judul = "DETAIL AUDIT CASTING";
        $today = Carbon::now()->today();
        $auditor = User::find($id);
        // $data = $auditor->answers()->whereDate('created_at',$today)->get();

        $data = User::with(['answers' => function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereHas('questions.subsection.sections', function ($query) {
                    $query->where('area', 'Casting HPDC');
                });
        }, 'answers.questions.subsection.sections'])->find($id);
        $mark = DB::table('fix_answers')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->select('sections.id as section_id', DB::raw('SUM(fix_answers.mark) as total_mark'))
            ->where('sections.area', 'Casting HPDC')
            ->whereDate('fix_answers.created_at', $today)
            ->groupBy('sections.id')
            ->get();
        // dd($mark);

        $totalQuestion = DB::table('fix_answers')
        ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
        ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
        ->join('sections', 'subsections.section_id', '=', 'sections.id')
        ->whereIn('questions.subsection_id', [1, 2, 3, 4, 5, 7, 8, 39])
        ->whereDate('fix_answers.created_at', $today)
        ->select('sections.id as section_id', DB::raw('COUNT(DISTINCT questions.id) as total'))
        ->groupBy('sections.id')
        ->get();

        // dd($totalQuestion);

        $score = [];
    foreach ($mark as $markItem) {
        foreach ($totalQuestion as $questionItem) {
            if ($markItem->section_id == $questionItem->section_id) {
                $score[$markItem->section_id] = $markItem->total_mark / $questionItem->total;
                break;
            }
        }
    }

        // $totalQuestion = count(Question::whereIn('subsection_id', [1, 2, 3, 4, 5, 7, 8,39])->get());

        return view('layouts.casting.detailcasting', compact('judul', 'data', 'totalQuestion', 'auditor','score', 'mark'));
    }
    public function castingHistory(Request $request)
    {
        $judul = "CHECKSHEET CASTING HISTORY";
        $query = FixAnswer::selectRaw('DATE(created_at) as date, auditor_id')
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Casting HPDC ');
            });
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
                'auditors' => $items->pluck('auditors')->unique(),
            ];
        });

        $mark = DB::table('fix_answers')
        ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
        ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
        ->join('sections', 'subsections.section_id', '=', 'sections.id')
        ->select(
            'sections.id as section_id',
            DB::raw('DATE(fix_answers.created_at) as date'),
            DB::raw('SUM(fix_answers.mark) as total_mark')
        )
        ->where('sections.area', 'Casting HPDC')
        ->groupBy('section_id', 'date')
        ->get();
            // dd($mark);
        
            // Query untuk mendapatkan total pertanyaan per section yang memiliki jawaban pada hari ini
            $totalQuestion = DB::table('fix_answers')
        ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
        ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
        ->join('sections', 'subsections.section_id', '=', 'sections.id')
        ->whereIn('questions.subsection_id', [1, 2, 3, 4, 5, 7, 8, 39])
        ->select(
            'sections.id as section_id',
            DB::raw('DATE(fix_answers.created_at) as date'),
            DB::raw('COUNT(DISTINCT questions.id) as total')
        )
        ->groupBy('section_id', 'date')
        ->get();
                // dd($totalQuestion);
            
            // Menghitung skor
            $score = [];
            foreach ($mark as $markItem) {
                foreach ($totalQuestion as $questionItem) {
                    if ($markItem->section_id == $questionItem->section_id && $markItem->date == $questionItem->date) {
                        $score[$markItem->date][$markItem->section_id] = $markItem->total_mark / $questionItem->total;
                        break;
                    }
                }
            }

        return view('layouts.casting.castinghistory', compact('judul', 'data', 'request', 'mark', 'score', 'totalQuestion'));
    }


    public function detailCastingHistory($date, $id_user)
    {
        $judul = "DETAIL CASTING HISTORY";

        // dd([$date,$id_user]);
        $auditor = User::find($id_user);
        $data = $auditor->answers()->whereDate('created_at', $date)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Casting HPDC');
            })->with('questions.subsection.sections')
            ->get();

            $mark = DB::table('fix_answers')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->select(
                'sections.id as section_id',
                DB::raw('DATE(fix_answers.created_at) as date'),
                DB::raw('SUM(fix_answers.mark) as total_mark')
            )
            ->where('sections.area', 'Casting HPDC')
            ->groupBy('section_id', 'date')
            ->get();
            // dd($mark);
        
            $totalQuestion = DB::table('fix_answers')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->whereIn('questions.subsection_id', [1, 2, 3, 4, 5, 7, 8, 39])
            ->select(
                'sections.id as section_id',
                DB::raw('DATE(fix_answers.created_at) as date'),
                DB::raw('COUNT(DISTINCT questions.id) as total')
            )
            ->groupBy('section_id', 'date')
            ->get();
        
            // dd($totalQuestion);
        
            $score = [];
            foreach ($mark as $markItem) {
                foreach ($totalQuestion as $questionItem) {
                    if ($markItem->section_id == $questionItem->section_id && $markItem->date == $questionItem->date) {
                        $score[$markItem->date][$markItem->section_id] = $markItem->total_mark / $questionItem->total;
                        break;
                    }
                }
            }
        // $totalQuestion = count(Question::whereIn('subsection_id', [1, 2, 3, 4, 5, 7, 8, 39])->get());



        // dd($data);
        return view('layouts.casting.detailCastingHistory', compact(['judul', 'data', 'auditor', 'totalQuestion', 'score', 'mark']));
    }



    public function createCasting()
    {
        $judul = "CHECKSHEET CASTING";
        $today = Carbon::today();
        $sections = Section::with(['subsections'], ['parts'])->where('area', 'Casting HPDC')->get();
        $auth = Auth::user();
        $auditorIds = $auth->id; // Ganti dengan daftar ID auditor yang Anda inginkan

        // Method untuk cek sebelum input berdasar Role
        $auditors = $this->auditorsAudit($auditorIds);


        // dd($auditors);


        return view('layouts.casting.checksheetcasting', compact('judul', 'sections', 'auditors'));
    }



    public function auditorsAudit($auditorIds)
    {



        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $auditors = User::withCount(['answers as answers_count' => function ($query) {
            $query->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Casting HPDC');
            });
        }])
            ->find($auditorIds);




        switch ($auditors->role) {

                ////// Keterangan
                // 1 = Bisa melakukan audit di area ini
                // 2 = Anda sudah melakukan audit sesuai dengan Area dan durasi anda
                // 3 = Keterangan jika anda telah melakukan audit area yang sedang anda buka
                // 4 = Area yang ingin di audit sudah diselesaikan oleh auditor lain

            case 4;

                $auditors =
                    User::with('answers.questions.subsection.sections')
                    ->where('role', 4)
                    ->withCount(['answers as answers_count' => function ($query) use ($today) {
                        $query->whereDate('created_at', $today);
                    }])

                    ->find($auditorIds);

                $queryAuditedAreaBy = Section::where('area', 'Casting HPDC')
                    ->whereHas('subsections.questions.answers', function ($query) use ($today) {
                        $query->whereDate('created_at', $today);
                    })->get();




                // Jika tidak auditor yang sedang login tidak melakukan audit hari ini
                if ($auditors->answers_count == 0) {


                    $queryAuditedAreaBy = Section::where('area', 'Casting HPDC')->whereHas('subsections.questions.answers', function ($query) use ($today) {
                        $query->whereDate('created_at', $today);
                    })->get();


                    // dd(count($queryAuditedAreaBy) == 0);
                    if (count($queryAuditedAreaBy) > 0) {
                        $auditors = [

                            'status' => 4,
                            'auditors' => $auditors,
                            'keterangan' => 'This Casting audit has been done by another Auditor'
                        ];
                    } else {
                        $auditors = [
                            'status' => 1,
                            'auditors' => $auditors,
                            'keterangan' => 'You\'re able to do this Audit'
                        ];
                    }


                    // JIka sudah melakukan audit apapun
                } else if ($auditors->whereHas('answers', function ($query) use ($today) {
                    $query->whereDate('created_at', $today);
                })->whereHas('answers.questions.subsection.sections', function ($query) {
                    $query->where('area', 'Casting HPDC');
                })) {

                    // dd($auditors->answers->first()->questions->subsection->sections->area);
                    $auditors = [
                        // Anda sudah melakukan audit sesuai dengan Area dan durasi anda
                        'status' => 2,
                        'auditors' => $auditors,
                        'keterangan' => 'You\'ve audited' .' Today (' . Carbon::now()->toDateString() . ')'
                    ];
                } else {
                    $auditors = User::whereHas('answers', function ($query) use ($today) {
                        $query->whereDate('created_at', $today);
                    })->find($auditorIds);
                    $auditors = [
                        // Keterangan jika anda telah melakukan audit area yang sedang anda buka
                        'status' => 3,
                        'auditors' => $auditors,
                        'keterangan' => 'You\'ve done audited this audit '
                    ];
                }



                break;
            case 5;



                $auditors =
                    User::with('answers.questions.subsection.sections')->where('role', 5)

                    ->withCount(['answers as answers_count' => function ($query) use ($startOfWeek, $endOfWeek) {
                        $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    }])
                    ->find($auditorIds);

                $queryAuditedAreaBy = Section::where('area', 'Casting HPDC')
                    ->whereHas('subsections.questions.answers', function ($query) use ($startOfWeek, $endOfWeek) {
                        $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    })->whereHas('subsections.questions.answers.auditors', function ($query) {
                        $query->where('role', 5);
                    })
                    ->get();
                // ->whereHas('answers.questions.subsection.sections', function ($query) {
                //     $query->where('area', 'Assy');
                // })


                if ($auditors->answers_count == 0) {

                    $queryAuditedAreaBy = Section::where('area', 'Casting HPDC')->whereHas('subsections.questions.answers', function ($query) use ($startOfWeek, $endOfWeek) {
                        $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    })->whereHas('subsections.questions.answers.auditors', function ($query) {
                        $query->where('role', 5);
                    })
                        ->get();
                    // dd(count($queryAuditedAreaBy) == 0);
                    if (count($queryAuditedAreaBy) > 0) {
                        $auditors = [

                            'status' => 4,
                            'auditors' => $auditors,
                            'keterangan' => 'This Casting HPDC audit has been done by another Auditor'
                        ];
                    } else {
                        $auditors = [
                            'status' => 1,
                            'auditors' => $auditors,
                            'keterangan' => 'You\'re able to do this Audit'
                        ];
                    }


                    // JIka sudah melakukan audit apapun
                } else if ($auditors->whereHas('answers', function ($query) use ($startOfWeek, $endOfWeek) {
                    $query->whereDate('created_at', [$startOfWeek, $endOfWeek]);
                })->whereHas('answers.questions.subsection.sections', function ($query) {
                    $query->where('area', 'Casting HPDC');
                })) {

                    // dd($auditors->answers->first()->questions->subsection->sections->area);
                    $auditors = [
                        // Anda sudah melakukan audit sesuai dengan Area dan durasi anda
                        'status' => 2,
                        'auditors' => $auditors,
                        'keterangan' => 'You\'ve audited ' . $auditors->answers->first()->questions->subsection->sections->area . ' This weeks (' . $startOfWeek->toFormattedDateString() . ' - ' . $endOfWeek->toFormattedDateString() . ') and cannot do another audit'
                    ];
                } else {
                    $auditors = User::whereHas('answers', function ($query) use ($startOfWeek, $endOfWeek) {
                        $query->whereDate('created_at', [$startOfWeek, $endOfWeek]);
                    })->find($auditorIds);
                    $auditors = [
                        // Keterangan jika anda telah melakukan audit area yang sedang anda buka
                        'status' => 3,
                        'auditors' => $auditors,
                        'keterangan' => 'You\'ve done audited this audit '
                    ];
                }


                break;

            case 6;
                $auditors =
                    User::with('answers.questions.subsection.sections')

                    ->withCount(['answers as answers_count' => function ($query) use ($today) {
                        $query->whereMonth('created_at', $today->format('L'));
                    }])
                    ->where('role', 6)
                    ->whereHas('answers.questions.subsection.sections', function ($query) {
                        $query->where('area', 'Casting HPDC');
                    })

                    ->find($auditorIds);
                if ($auditors == null) {
                    $auditors = User::find($auditorIds);
                    $auditors = [
                        'auditors' => $auditors,
                        'keterangan' => 'You\'re able to do this Audit'
                    ];
                } else {
                    $auditors = [
                        'auditors' => $auditors,
                        'keterangan' => 'This audit has done by ' . $auditors->auditor_name . ' (' . $auditors->role . '). Please do re-audit next Month.'
                    ];
                }


                break;



            default:
                return 'Terdapat kesalahan pada data Auditor';
        }


        return $auditors;
    }


    public function addEmptyDateCasting()
    {
        $judul = "CHECKSHEET EMPTY DAY CASTING";

        $today = Carbon::today();
        $sections = Section::with(['subsections'], ['parts'])->where('area', 'Casting HPDC')->get();
        $auth = Auth::user();
        $auditorIds = $auth->id; // Ganti dengan daftar ID auditor yang Anda inginkan

        $auditors = $this->auditorsAudit($auditorIds);

        $month = Carbon::now()->format('m');

        $datesAudited = FixAnswer::whereHas('questions.subsection.sections', function ($query) use ($month) {
            $query->where('area', 'Casting HPDC');
        })->whereMonth('created_at', $month)
            ->get()
            ->unique('created_at')
            ->values()
            ->map(function ($dates) {
                return [
                    'dates' => $dates->created_at->toDateString()
                ];
            });

        $missingDates = [];
        $currentDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now();




        // Iterasi melalui setiap tanggal dari Senin hingga Jumat dalam rentang minggu ini
        while ($currentDate->lte($endDate)) {
            // Periksa apakah tanggal tersebut merupakan hari kerja (Senin hingga Jumat)
            if ($currentDate->isWeekday()) {
                $formattedDate = $currentDate->toDateString();
                // Jika tanggal tersebut belum diaudit, tambahkan ke dalam array missingDates
                if (!$datesAudited->contains('dates', $formattedDate)) {
                    $missingDates[] = ['dates' => $formattedDate];
                }
            }


            // Lanjutkan ke tanggal berikutnya
            $currentDate->addDay();
        }



        // Gabungkan tanggal-tanggal yang telah diaudit dengan tanggal-tanggal yang belum diaudit
        $data['allDates'] = $missingDates;



        // dd($data['allDates']);

        return view('layouts.casting.addCastingAuditPreviousDay', $data, compact('judul', 'auditors', 'sections'));
    }



    public function answerEmptyCasting(Request $request)
    {


        $name = 'Casting';

        foreach ($request->answer as $question_id => $value) {
            if (isset($value['image'])) {
                // Load the uploaded image
                $uploadedImage = $value['image']; // Get the uploaded image file object
            
                // Validate that the file is a JPEG, JPG, or PNG image
                $allowedExtensions = ['jpeg', 'jpg', 'png'];
                $extension = strtolower($uploadedImage->getClientOriginalExtension());
            
                if (in_array($extension, $allowedExtensions)) {
                    // Get the original image path
                    $imagePath = $uploadedImage->path(); // Get the path of the uploaded image
            
                    // Load the original image based on the extension
                    switch ($extension) {
                        case 'jpeg':
                        case 'jpg':
                            $image = imagecreatefromjpeg($imagePath);
                            break;
                        case 'png':
                            $image = imagecreatefrompng($imagePath);
                            break;
                    }
            
                    // Generate the WebP file name
                    $imageName = $name . '-' . now()->format('Y-m-d_H-i-s') . '-' . $uploadedImage->getClientOriginalName();
                    $webpNameImage = pathinfo($imageName, PATHINFO_FILENAME) . '.webp'; // Change the file extension to .webp
            
                    // Convert the image to WebP format
                    imagewebp($image, public_path('images/' . $webpNameImage));
            
                    // Free up memory
                    imagedestroy($image);
            
                    // Store the WebP image file
                    $uploadedImage->storeAs('images', $webpNameImage, 'public');
            
                // dd($value['image']->storeAs('images', $imageName, 'public'));
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => 'images/' . $webpNameImage, // Simpan nama file gambar di database
                    'created_at' => $request->previous_day
                ]);
            } else {
                // Handle the case where the uploaded file is not a valid image type
                throw new \Exception('The uploaded file must be a JPEG, JPG, or PNG image.');
            }
            } else {
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                    'created_at' => $request->previous_day
                ]);
            }
        }

        return redirect()->to('castinghistory');
    }


    // Jika tidak auditor yang sedang login tidak melakukan audit hari ini
    // if ($auditors->answers_count == 0) {
    //     $auditors = [
    //         'status' => 1,
    //         'auditors' => $auditors,
    //         'keterangan' => 'You\'re able to do this Audit'
    //     ];

    //     // JIka sudah melakukan audit apapun
    // } else if ($auditors->whereHas('answers', function ($query) use ($today) {
    //     $query->whereDate('created_at', $today);
    // })->whereHas('answers.questions.subsection.sections', function ($query) {
    //     $query->where('area', 'Painting');
    // })) {
    //     $auditors = [
    //         'status' => 2,
    //         'auditors' => $auditors,
    //         'keterangan' => 'You\'ve audited ' . $auditors->answers->first()->questions->first()->subsection->sections->area
    //     ];
    // } else {

    //     $auditors = User::whereHas('answers', function ($query) use ($today) {
    //         $query->whereDate('created_at', $today);
    //     })->find($auditorIds);
    //     $auditors = [
    //         'status' => 3,
    //         'auditors' => $auditors,
    //         'keterangan' => 'You\'ve done audited this audit '
    //     ];
    // }



}
