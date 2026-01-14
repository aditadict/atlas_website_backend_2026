<?php

namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InsightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insights = [
            [
                'slug' => 'digital-transformation-guide-2026',
                'title' => [
                    'en' => 'Complete Guide to Digital Transformation in 2026',
                    'id' => 'Panduan Lengkap Transformasi Digital di 2026',
                ],
                'excerpt' => [
                    'en' => 'Learn how businesses are leveraging technology to transform their operations and stay competitive in the digital age.',
                    'id' => 'Pelajari bagaimana bisnis memanfaatkan teknologi untuk mengubah operasi mereka dan tetap kompetitif di era digital.',
                ],
                'content' => [
                    'en' => 'Digital transformation is no longer optional for businesses. In 2026, companies must embrace cloud computing, AI, and data analytics to remain competitive. This comprehensive guide explores the key strategies and technologies driving successful digital transformation initiatives.',
                    'id' => 'Transformasi digital bukan lagi pilihan untuk bisnis. Di tahun 2026, perusahaan harus mengadopsi komputasi awan, AI, dan analitik data untuk tetap kompetitif. Panduan komprehensif ini mengeksplorasi strategi dan teknologi kunci yang mendorong inisiatif transformasi digital yang sukses.',
                ],
                'category' => [
                    'en' => 'Technology Trends',
                    'id' => 'Tren Teknologi',
                ],
                'published' => true,
            ],
            [
                'slug' => 'ai-powered-business-automation',
                'title' => [
                    'en' => 'AI-Powered Business Automation: The Future is Now',
                    'id' => 'Otomasi Bisnis Berbasis AI: Masa Depan adalah Sekarang',
                ],
                'excerpt' => [
                    'en' => 'Discover how artificial intelligence is revolutionizing business processes and creating new opportunities for efficiency.',
                    'id' => 'Temukan bagaimana kecerdasan buatan merevolusi proses bisnis dan menciptakan peluang baru untuk efisiensi.',
                ],
                'content' => [
                    'en' => 'Artificial Intelligence is transforming how businesses operate. From automated customer service to predictive analytics, AI enables companies to work smarter, not harder. This article explores practical applications of AI in modern business automation.',
                    'id' => 'Kecerdasan Buatan mengubah cara bisnis beroperasi. Dari layanan pelanggan otomatis hingga analitik prediktif, AI memungkinkan perusahaan bekerja lebih cerdas, bukan lebih keras. Artikel ini mengeksplorasi aplikasi praktis AI dalam otomasi bisnis modern.',
                ],
                'category' => [
                    'en' => 'Artificial Intelligence',
                    'id' => 'Kecerdasan Buatan',
                ],
                'published' => true,
            ],
            [
                'slug' => 'cloud-migration-best-practices',
                'title' => [
                    'en' => 'Cloud Migration Best Practices for Enterprise',
                    'id' => 'Praktik Terbaik Migrasi Cloud untuk Perusahaan',
                ],
                'excerpt' => [
                    'en' => 'A step-by-step guide to successfully migrating your enterprise infrastructure to the cloud.',
                    'id' => 'Panduan langkah demi langkah untuk berhasil memigrasikan infrastruktur perusahaan Anda ke cloud.',
                ],
                'content' => [
                    'en' => 'Migrating to the cloud requires careful planning and execution. This guide covers assessment, migration strategies, security considerations, and post-migration optimization to ensure a smooth transition to cloud infrastructure.',
                    'id' => 'Migrasi ke cloud memerlukan perencanaan dan eksekusi yang cermat. Panduan ini mencakup penilaian, strategi migrasi, pertimbangan keamanan, dan optimisasi pasca-migrasi untuk memastikan transisi yang lancar ke infrastruktur cloud.',
                ],
                'category' => [
                    'en' => 'Cloud Computing',
                    'id' => 'Komputasi Awan',
                ],
                'published' => true,
            ],
            [
                'slug' => 'mobile-first-development-approach',
                'title' => [
                    'en' => 'Why Mobile-First Development Matters in 2026',
                    'id' => 'Mengapa Pengembangan Mobile-First Penting di 2026',
                ],
                'excerpt' => [
                    'en' => 'Understanding the importance of mobile-first approach in modern application development.',
                    'id' => 'Memahami pentingnya pendekatan mobile-first dalam pengembangan aplikasi modern.',
                ],
                'content' => [
                    'en' => 'With mobile devices accounting for over 70% of web traffic, adopting a mobile-first development approach is crucial. This article explains why starting with mobile design leads to better user experiences and more successful applications.',
                    'id' => 'Dengan perangkat mobile menyumbang lebih dari 70% lalu lintas web, mengadopsi pendekatan pengembangan mobile-first sangat penting. Artikel ini menjelaskan mengapa memulai dengan desain mobile menghasilkan pengalaman pengguna yang lebih baik dan aplikasi yang lebih sukses.',
                ],
                'category' => [
                    'en' => 'Mobile Development',
                    'id' => 'Pengembangan Mobile',
                ],
                'published' => true,
            ],
            [
                'slug' => 'cybersecurity-essentials-draft',
                'title' => [
                    'en' => 'Cybersecurity Essentials for Modern Businesses',
                    'id' => 'Dasar-Dasar Keamanan Siber untuk Bisnis Modern',
                ],
                'excerpt' => [
                    'en' => 'Essential cybersecurity practices every business should implement to protect their digital assets.',
                    'id' => 'Praktik keamanan siber penting yang harus diterapkan setiap bisnis untuk melindungi aset digital mereka.',
                ],
                'content' => [
                    'en' => 'As cyber threats evolve, businesses must stay vigilant. This draft article covers fundamental security practices including encryption, access control, regular audits, and incident response planning.',
                    'id' => 'Seiring ancaman siber berkembang, bisnis harus tetap waspada. Artikel draft ini mencakup praktik keamanan fundamental termasuk enkripsi, kontrol akses, audit reguler, dan perencanaan respons insiden.',
                ],
                'category' => [
                    'en' => 'Security',
                    'id' => 'Keamanan',
                ],
                'published' => false,
            ],
        ];

        foreach ($insights as $insight) {
            Insight::create($insight);
        }
    }
}
