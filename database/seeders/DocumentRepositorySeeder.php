<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DocumentRepositorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('document_repositories')->insert([
            [
                'title' => 'The Impact of Online Learning on Student Performance',
                'abstract' => 'This study explores how online learning platforms influence the academic performance and engagement of students in higher education.',
                'student_id' => 1,
                'teacher_id' => 2,
                'approved_by' => null,
                'authors' => 'Juan Dela Cruz, Maria Santos',
                'citation' => 'Dela Cruz, J., & Santos, M. (2025). The Impact of Online Learning on Student Performance. University of Example Press.',
                'metadata' => json_encode([
                    'keywords' => ['online learning', 'academic performance', 'student engagement'],
                    'pages' => 45
                ]),
                'file' => null,
                'status' => 'pending',
                'date_submitted' => '2025-10-01 09:15:00',
                'date_reviewed' => null,
                'study_type' => 'Quantitative Research',
                'abandoned_date' => null,
                'recovered_date' => null,
                'lost_date' => null,
                'archived' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Sustainable Urban Farming Practices in Metro Manila',
                'abstract' => 'This research investigates urban farming methods that promote sustainability and food security in dense metropolitan areas.',
                'student_id' => 1,
                'teacher_id' => 2,
                'approved_by' => null,
                'authors' => 'Juan Dela Cruz, Maria Santos',
                'citation' => 'Dela Cruz, J., & Santos, M. (2025). Sustainable Urban Farming Practices in Metro Manila. Philippine Research Journal.',
                'metadata' => json_encode([
                    'keywords' => ['urban farming', 'sustainability', 'food security'],
                    'pages' => 52
                ]),
                'file' => null,
                'status' => 'approved',
                'date_submitted' => '2025-09-25 14:30:00',
                'date_reviewed' => '2025-09-27 10:00:00',
                'study_type' => 'Qualitative Research',
                'abandoned_date' => null,
                'recovered_date' => null,
                'lost_date' => null,
                'archived' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'The Role of AI in Modern Education Systems',
                'abstract' => 'An analytical study on how artificial intelligence tools reshape teaching methods and learning outcomes in universities.',
                'student_id' => 1,
                'teacher_id' => 2,
                'approved_by' => 2,
                'authors' => 'Juan Dela Cruz, Maria Santos',
                'citation' => 'Dela Cruz, J., & Santos, M. (2025). The Role of AI in Modern Education Systems. EduTech Journal.',
                'metadata' => json_encode([
                    'keywords' => ['AI', 'education', 'machine learning'],
                    'pages' => 40
                ]),
                'file' => null,
                'status' => 'approved',
                'date_submitted' => '2025-08-10 11:00:00',
                'date_reviewed' => '2025-08-12 16:45:00',
                'study_type' => 'Descriptive Research',
                'abandoned_date' => null,
                'recovered_date' => null,
                'lost_date' => null,
                'archived' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Analysis of Climate Change Awareness Among Filipino Youth',
                'abstract' => 'This paper analyzes the level of climate change awareness and proactive behaviors among students across the Philippines.',
                'student_id' => 1,
                'teacher_id' => 2,
                'approved_by' => null,
                'authors' => 'Juan Dela Cruz, Maria Santos',
                'citation' => 'Dela Cruz, J., & Santos, M. (2025). Analysis of Climate Change Awareness Among Filipino Youth. Environmental Studies Journal.',
                'metadata' => json_encode([
                    'keywords' => ['climate change', 'awareness', 'Filipino youth'],
                    'pages' => 60
                ]),
                'file' => null,
                'status' => 'rejected',
                'date_submitted' => '2025-07-15 10:30:00',
                'date_reviewed' => '2025-07-20 09:20:00',
                'study_type' => 'Survey Research',
                'abandoned_date' => null,
                'recovered_date' => null,
                'lost_date' => null,
                'archived' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
