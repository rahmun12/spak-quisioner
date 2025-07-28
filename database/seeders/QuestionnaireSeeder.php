<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuestionnaireSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            'Apakah menurut saudara terdapat budaya dan praktik-praktik korupsi, kolusi, dan nepotisme di lingkungan Anda?',
            'Menurut pengalaman, apakah Saudara memberikan tanda terima kasih ats pelayanan yang telah di selesaikan (meskipun tidak diminta), baik dalam bentuk barang maupun uang?',
            'Aapakah Saudara pernah ditawari oleh petugas untuk memperoleh pelayanan yang lebih cepat dan mudah tanpa melalui prosedur yang telah ditetapkan dengan meminta imbalan (uang atau barang) tertentu oleh petugas?(Tidak Sesuai Prosedur)',
            'Apakah Saudara pernah mengalami diskriminasi (dibeda-bedakan) dari petugas pelayanan? (Diskriminasi)',
            'Apakah saudara diminta untuk membayar tidak sesuai tarif resmi atau ada biaya tambahan? (PUNGLI)',
            'Apakah saudara mengetahui adanya praktek percaloan dalam mengurus pelayanan?(PERCALOAN)',
        ];

        $options = [
            'Tidak Pernah',
            'Kadang-kadang',
            'Sering',
            'Selalu',
        ];

        foreach ($questions as $qText) {
            $questionId = DB::table('questions')->insertGetId([
                'text' => $qText,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            foreach ($options as $optText) {
                DB::table('question_options')->insert([
                    'question_id' => $questionId,
                    'option_text' => $optText,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
