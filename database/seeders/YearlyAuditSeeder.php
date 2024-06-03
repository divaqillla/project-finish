<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\FixAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class YearlyAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $auditorIds = [1, 2];
        $questions = Question::pluck('id')->toArray();

        // Menggunakan $startDate sebagai titik awal
        $currentDate = $startDate->copy();

        // Lakukan loop dari startDate hingga endDate
        while ($currentDate <= $endDate) {
            foreach ($auditorIds as $auditorId) {
                for ($i = 0; $i < 137; $i++) {
                    // Salin tanggal acak dari tanggal saat ini
                    $randomDate = $currentDate->copy()->addDays(rand(0, $currentDate->copy()->endOfMonth()->diffInDays($currentDate)));

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
            // Pindahkan ke bulan berikutnya
            $currentDate->addMonth()->startOfMonth();
        }

    }
}
