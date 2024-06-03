<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Question;
use App\Models\FixAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FixAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $auditorIds = User::pluck('id');
        $questions = Question::pluck('id')->toArray();

        foreach ($auditorIds as $auditorId) {
            for ($i = 0; $i < 137; $i++) {
                $randomDate = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)));

                while ($randomDate->isWeekend()) {
                    $randomDate->addDay(); // Move to next day
                }

                $randomQuestionId = $questions[array_rand($questions)];

                FixAnswer::create([
                    'auditor_id' => $auditorId,
                    'question_id' => $randomQuestionId,
                    'created_at' => $randomDate,
                    'mark' => 100,
                ]);
            }
        }
    }
}
