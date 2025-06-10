<?php

namespace Database\Seeders;

use App\Models\Submission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Submission::create([
            'user_id' => 1,
            'title' => 'tugas harian',
            'content' => 'Tugas harian hari ke-5',
        ]);
    }
}
