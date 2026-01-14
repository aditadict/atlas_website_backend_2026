<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'industry' => [
                    'en' => 'E-Commerce',
                    'id' => 'E-Commerce',
                ],
                'system_type' => [
                    'en' => 'Web Application',
                    'id' => 'Aplikasi Web',
                ],
                'title' => [
                    'en' => 'Multi-Vendor Marketplace Platform',
                    'id' => 'Platform Marketplace Multi-Vendor',
                ],
                'scope' => [
                    'en' => 'Developed a comprehensive marketplace platform connecting multiple vendors with customers. Features include vendor management, product catalog, order processing, payment gateway integration, and real-time analytics dashboard.',
                    'id' => 'Mengembangkan platform marketplace komprehensif yang menghubungkan berbagai vendor dengan pelanggan. Fitur mencakup manajemen vendor, katalog produk, pemrosesan pesanan, integrasi payment gateway, dan dashboard analitik real-time.',
                ],
                'outcome' => [
                    'en' => 'Successfully launched with 50+ vendors and 10,000+ active users in the first quarter. Achieved 99.9% uptime and processed over $1M in transactions.',
                    'id' => 'Berhasil diluncurkan dengan 50+ vendor dan 10.000+ pengguna aktif di kuartal pertama. Mencapai uptime 99,9% dan memproses lebih dari $1M dalam transaksi.',
                ],
                'featured' => true,
                'order' => 1,
            ],
            [
                'industry' => [
                    'en' => 'Healthcare',
                    'id' => 'Kesehatan',
                ],
                'system_type' => [
                    'en' => 'Mobile Application',
                    'id' => 'Aplikasi Mobile',
                ],
                'title' => [
                    'en' => 'Telemedicine & Appointment System',
                    'id' => 'Sistem Telemedicine & Janji Temu',
                ],
                'scope' => [
                    'en' => 'Built a HIPAA-compliant telemedicine platform enabling video consultations, electronic health records, prescription management, and appointment scheduling. Available on iOS and Android.',
                    'id' => 'Membangun platform telemedicine yang sesuai dengan HIPAA yang memungkinkan konsultasi video, rekam kesehatan elektronik, manajemen resep, dan penjadwalan janji temu. Tersedia di iOS dan Android.',
                ],
                'outcome' => [
                    'en' => 'Deployed across 25 healthcare facilities. Reduced patient wait times by 40% and increased doctor availability by 60%. Over 50,000 consultations conducted in the first year.',
                    'id' => 'Diterapkan di 25 fasilitas kesehatan. Mengurangi waktu tunggu pasien sebesar 40% dan meningkatkan ketersediaan dokter sebesar 60%. Lebih dari 50.000 konsultasi dilakukan di tahun pertama.',
                ],
                'featured' => true,
                'order' => 2,
            ],
            [
                'industry' => [
                    'en' => 'Finance',
                    'id' => 'Keuangan',
                ],
                'system_type' => [
                    'en' => 'Web Application',
                    'id' => 'Aplikasi Web',
                ],
                'title' => [
                    'en' => 'AI-Powered Investment Platform',
                    'id' => 'Platform Investasi Berbasis AI',
                ],
                'scope' => [
                    'en' => 'Developed an intelligent investment platform with robo-advisory features, portfolio management, real-time market data integration, risk assessment, and automated rebalancing.',
                    'id' => 'Mengembangkan platform investasi cerdas dengan fitur robo-advisory, manajemen portofolio, integrasi data pasar real-time, penilaian risiko, dan penyeimbangan otomatis.',
                ],
                'outcome' => [
                    'en' => 'Managed assets worth $500M+ with 15,000+ active investors. Average portfolio return of 12% annually with 95% customer satisfaction rate.',
                    'id' => 'Mengelola aset senilai $500M+ dengan 15.000+ investor aktif. Rata-rata return portofolio 12% per tahun dengan tingkat kepuasan pelanggan 95%.',
                ],
                'featured' => true,
                'order' => 3,
            ],
            [
                'industry' => [
                    'en' => 'Manufacturing',
                    'id' => 'Manufaktur',
                ],
                'system_type' => [
                    'en' => 'Enterprise System',
                    'id' => 'Sistem Enterprise',
                ],
                'title' => [
                    'en' => 'Smart Factory Management System',
                    'id' => 'Sistem Manajemen Pabrik Pintar',
                ],
                'scope' => [
                    'en' => 'Implemented IoT-enabled factory management system with real-time monitoring, predictive maintenance, inventory tracking, quality control, and production optimization.',
                    'id' => 'Mengimplementasikan sistem manajemen pabrik berbasis IoT dengan pemantauan real-time, pemeliharaan prediktif, pelacakan inventaris, kontrol kualitas, dan optimisasi produksi.',
                ],
                'outcome' => [
                    'en' => 'Increased production efficiency by 35%, reduced equipment downtime by 50%, and decreased waste by 25%. ROI achieved within 18 months.',
                    'id' => 'Meningkatkan efisiensi produksi sebesar 35%, mengurangi downtime peralatan sebesar 50%, dan mengurangi limbah sebesar 25%. ROI tercapai dalam 18 bulan.',
                ],
                'featured' => false,
                'order' => 4,
            ],
            [
                'industry' => [
                    'en' => 'Education',
                    'id' => 'Pendidikan',
                ],
                'system_type' => [
                    'en' => 'Learning Management System',
                    'id' => 'Sistem Manajemen Pembelajaran',
                ],
                'title' => [
                    'en' => 'Interactive E-Learning Platform',
                    'id' => 'Platform E-Learning Interaktif',
                ],
                'scope' => [
                    'en' => 'Created a comprehensive LMS with live classes, recorded lectures, interactive quizzes, progress tracking, certification, and AI-powered personalized learning paths.',
                    'id' => 'Menciptakan LMS komprehensif dengan kelas live, rekaman kuliah, kuis interaktif, pelacakan progress, sertifikasi, dan jalur pembelajaran personal berbasis AI.',
                ],
                'outcome' => [
                    'en' => 'Adopted by 100+ educational institutions serving 200,000+ students. 90% course completion rate with 4.8/5 average rating. 50,000+ certificates issued.',
                    'id' => 'Diadopsi oleh 100+ institusi pendidikan melayani 200.000+ siswa. Tingkat penyelesaian kursus 90% dengan rating rata-rata 4,8/5. 50.000+ sertifikat diterbitkan.',
                ],
                'featured' => false,
                'order' => 5,
            ],
            [
                'industry' => [
                    'en' => 'Logistics',
                    'id' => 'Logistik',
                ],
                'system_type' => [
                    'en' => 'Mobile & Web Application',
                    'id' => 'Aplikasi Mobile & Web',
                ],
                'title' => [
                    'en' => 'Real-Time Fleet Management System',
                    'id' => 'Sistem Manajemen Armada Real-Time',
                ],
                'scope' => [
                    'en' => 'Developed an end-to-end fleet management solution with GPS tracking, route optimization, driver management, fuel monitoring, and automated reporting.',
                    'id' => 'Mengembangkan solusi manajemen armada end-to-end dengan pelacakan GPS, optimisasi rute, manajemen pengemudi, pemantauan bahan bakar, dan pelaporan otomatis.',
                ],
                'outcome' => [
                    'en' => 'Managing 500+ vehicles across 5 countries. Reduced fuel costs by 20%, improved delivery times by 30%, and increased fleet utilization by 40%.',
                    'id' => 'Mengelola 500+ kendaraan di 5 negara. Mengurangi biaya bahan bakar sebesar 20%, meningkatkan waktu pengiriman sebesar 30%, dan meningkatkan pemanfaatan armada sebesar 40%.',
                ],
                'featured' => false,
                'order' => 6,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
