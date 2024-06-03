<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Question;
use App\Models\SuppAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuppAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $auditorIds = [1, 2];
        $questions = Question::pluck('id')->toArray();
        $LineProcess = ['Incoming Inspection NM', 'Vendor / Subcont'];
        $vendor = ['PT. Fulan Abdullah', ' PT.Budi', 'PT. Annisa'];

        foreach ($auditorIds as $auditorId) {
            for ($i = 0; $i < 137; $i++) {
                $randomDate = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)));
                $randomQuestionId = $questions[array_rand($questions)];

                SuppAnswer::create([
                    'line' => $LineProcess[array_rand($LineProcess)],
                    'vendor' => $vendor[array_rand($vendor)],
                    'auditor_id' => $auditorId,
                    'question_id' => $randomQuestionId,
                    'created_at' => $randomDate,
                    'mark' => 100,
                ]);
            }
        }
    }
}
