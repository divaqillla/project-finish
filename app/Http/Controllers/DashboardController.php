<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Part;
use App\Models\Answer;
use App\Models\User;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


    public function index()
    {
        $judul = 'Dashboard';
        // Masih salah

        $today = Carbon::now()->today();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $monthlyCasting = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('users', 'fix_answers.auditor_id', '=', 'users.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('DATE(fix_answers.created_at) as audit_date, sections.area')
            ->where('users.role', 4)
            ->groupBy('audit_date', 'sections.area') // Group by audit_date dan area
            ->get()
            ->groupBy('audit_date') // Group by audit_date untuk membentuk struktur data yang sesuai
            ->map(function ($dailyData) {
                $auditCounts = $dailyData->groupBy('area')->map->count(); // Hitung jumlah audit per area
                return [
                    'data' => $auditCounts,
                ];
            })->toArray();

        // dd($monthlyCasting);

        $dailyCasting = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('auditors', 'fix_answers.auditor_id', '=', 'auditors.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('auditors.auditor_name, sections.area, COUNT(DISTINCT DATE(fix_answers.created_at)) as total_days_with_audit')
            ->where('sections.area', 'Casting HPDC')
            ->groupBy('auditors.auditor_name', 'sections.area')
            ->get();

        $weeklyCasting = Section::with(['subsections'])
            ->join('subsections', 'sections.id', '=', 'subsections.section_id')
            ->join('questions', 'subsections.id', '=', 'questions.subsection_id')
            ->join('fix_answers', 'questions.id', '=', 'fix_answers.question_id')
            ->selectRaw('sections.area, DATE(fix_answers.created_at) as audit_date')
            ->whereBetween('fix_answers.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->distinct()
            ->get();





        $weeklyResult = [
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday' => 0,
            'friday' => 0,
            'saturday' => 0,
            'sunday' => 0
        ];

        foreach ($weeklyCasting as $record) {
            $dayOfWeek = Carbon::parse($record->audit_date)->format('l'); // Mengambil nama hari dalam bahasa Indonesia


            $dayOfWeekLowercase = strtolower($dayOfWeek);
            $weeklyResult[$dayOfWeekLowercase]++;
        }


        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();


        $weeksData = [
            'Week 1' => null,
            'Week 2' => null,
            'Week 3' => null,
            'Week 4' => null,
            'Week 5' => null
        ];

        // $currentDate = $startDate->copy();

        $firstDayOfMonth = Carbon::now()->firstOfMonth();
        $tempDate = $firstDayOfMonth;
        for ($i=1; $i <= $firstDayOfMonth->weekOfMonth ; $i++) {
            // $weeksData['Week ' . $i] = $tempDate->copy();
            $endDate = $tempDate->copy()->addDays(6);
            // if end date month is not equal to current date month
            if ($endDate->month != $firstDayOfMonth->month) {
                $endDate = $tempDate->copy()->endOfMonth();
            }
            $weeksData['Week ' . $i] = [
                'start' => $tempDate->copy(),
                'end' => $endDate->endOfDay(),
            ];
            $tempDate = $tempDate->addDays(7);
        }

        $auditsPerWeek = [];
        foreach ($weeksData as $week => $dates) {


            $weekStart = $dates['start'];
            $weekEnd = $dates['end'];
            // dd($weekStart, $weekEnd);



            // dd($weekStart);
            $auditsPerWeek[$week] = Section::with(['subsections.questions.answers.auditors'])
                ->whereHas('subsections.questions.answers.auditors', function ($query) {
                    $query->where('role', 5);
                })
                ->whereHas('subsections.questions.answers', function ($query) use ($weekStart, $weekEnd) {
                    $query->whereBetween('created_at', [$weekStart, $weekEnd]);
                })

                ->get()
                ->groupBy(function ($section) {
                    return $section->area;
                })
                ->map(function ($sections) {
                    return $sections->flatMap(function ($section) {
                        return $section->subsections->flatMap(function ($subsection) {
                            return $subsection->questions->flatMap(function ($question) {
                                return $question->answers;
                            });
                        });
                    })->pluck('auditor_id')->unique('auditor_id')->count();
                });



        }



        // Yearly Audit

        $yearlyAudit = Section::with(['subsections.questions.answers'])
            ->whereHas('subsections.questions.answers.auditors', function ($query) {
                $query->where('role', 6);
            })
            ->get()
            ->flatMap(function ($section) {
                return $section->subsections->flatMap(function ($subsection) {
                    return $subsection->questions->flatMap(function ($question) use ($subsection) {
                        // Periksa apakah subsection tersedia
                        if ($subsection) {
                            return $question->answers->map(function ($answer) use ($subsection) {
                                return [
                                    'area' => $subsection->sections->area, // mengakses area dari relasi section
                                    'audit_month' => $answer->created_at->format('F'), // mengakses created_at langsung dari answer
                                ];
                            });
                        }
                        return [];
                    });
                });
            })
            ->unique(function ($item) {
                return $item['area'] . $item['audit_month'];
            })
            ->groupBy('audit_month')
            ->map(function ($audits) {
                return $audits->groupBy('area')->map->count();
            })
            ->sortBy(function ($value, $key) {
                return \DateTime::createFromFormat('F', $key)->format('m');
            });




        $dataAnswer = FixAnswer::with(['questions.subsection.sections'])->get();
        // Ambil semua data dan kelompokkan berdasarkan area
        $dataGroupedByArea = Section::with('subsections.questions.answers.auditors')
            ->get()
            ->groupBy('area');



        // Iterasi melalui setiap area

        $areaStatistics = [];


        foreach ($dataGroupedByArea as $area => $data) {
            $questionsCounts = $data->flatMap->subsections->flatMap->questions->count();

            $uniqueAuditors = $data->flatMap->subsections->flatMap->questions->flatMap->answers
                ->groupBy(function ($answer) {
                    return $answer->created_at->toDateString();
                });
            // ->count();


            // dd($uniqueAuditors);

            $passedCounts = 0;
            $notPassedCounts = 0;

            foreach ($uniqueAuditors as $created_at => $auditorCount) {

                $totalMarkPerAuditor = $auditorCount->groupBy(function ($auditor) {
                    return $auditor->auditor_id;
                })->map(function ($sum) {
                    return $sum->sum('mark');
                })->values();

                foreach ($totalMarkPerAuditor as $perAuditorCount) {

                    // dd($questionsCounts);


                    $averageScore = $perAuditorCount / $questionsCounts;


                    if ($averageScore >= 100) {
                        $passedCounts++;
                    } else {
                        $notPassedCounts++;
                    }
                }
            }



            $areaStatistics[] = [
                'area' => $area,
                'questions_count' => $questionsCounts,
                'total_passed' => $passedCounts,
                'total_not_passed' => $notPassedCounts,
            ];
        }
        // dd($areaStatistics);


        // dd($areaStatistics);




        // Outputkan atau gunakan $areaStatistics sesuai kebutuhan Anda
        return view('layouts.dashboard.dashboard-index', compact('judul', 'monthlyCasting', 'weeklyResult', 'yearlyAudit', 'auditsPerWeek', 'areaStatistics'));
    }
    public function getMonthlyAchievement(Request $request)
    {
        // Ambil parameter dari request
        $month = $request->input('monthFilter');

        // Query untuk mendapatkan pencapaian bulanan berdasarkan bulan yang dipilih
        $monthlyAchievement = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('auditors', 'fix_answers.auditor_id', '=', 'users.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('DATE(fix_answers.created_at) as audit_date, sections.area')
            ->where('users.role', 4)
            ->whereMonth('fix_answers.created_at', Carbon::parse($month)->month) // Filter berdasarkan bulan yang dipilih
            ->groupBy('audit_date', 'sections.area') // Group by audit_date dan area
            ->get()
            ->groupBy('audit_date') // Group by audit_date untuk membentuk struktur data yang sesuai
            ->map(function ($dailyData) {
                $auditCounts = $dailyData->groupBy('area')->map->count(); // Hitung jumlah audit per area
                return [
                    'data' => $auditCounts,
                ];
            })->toArray();

        // Outputkan atau gunakan $monthlyAchievement sesuai kebutuhan Anda
        return response()->json($monthlyAchievement);
    }

}







// $passedCounts = $scoreAuditors->filter(function ($sum) {
            //     return $sum == 100; // Mengambil nilai yang lebih besar atau sama dengan 100
            // });

            // $notPassedCounts = $scoreAuditors->filter(function ($sum) {
            //     return $sum < 100; // Mengambil nilai yang kurang dari 100
            // });


            // dd(count($notPassedCounts));
            // }
            // dd($scoreAuditors);













// $passedCounts = $scoreAuditors->filter(function ($sum) {
//     return $sum == 100; // Mengambil nilai yang lebih besar atau sama dengan 100
// });

// $notPassedCounts = $scoreAuditors->filter(function ($sum) {
//     return $sum < 100; // Mengambil nilai yang kurang dari 100
// });


            // // Hitung jumlah yang mendapatkan nilai akhir 100 dan di bawah 100
            // $totalPerfectScore = $data->filter(function ($section) {
            //     return $section->subsections->count(function ($subsection) {
            //         return $subsection->questions->count(function ($questions) {
            //             return $questions;
            //         });
            //     });
            // });



            // $totalBelowHundred = $data->sum(function ($section) {
            //     return $section->subsections->sum(function ($subsection) {
            //         return $subsection->questions->filter(function ($question) {
            //             return $question->answers;
            //         })->count();
            //     });
            // });
