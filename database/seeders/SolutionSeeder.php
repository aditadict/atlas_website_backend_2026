<?php

namespace Database\Seeders;

use App\Models\Solution;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $solutions = [
            [
                'slug' => 'digitalization',
                'title' => [
                    'en' => 'Business Digitalization & Transformation',
                    'id' => 'Digitalisasi & Transformasi Bisnis',
                ],
                'description' => [
                    'en' => 'Consulting-led digitalization aligning people, processes, and technology into a clear digital roadmap.',
                    'id' => 'Digitalisasi berbasis konsultasi yang menyelaraskan orang, proses, dan teknologi ke dalam peta jalan digital yang jelas.',
                ],
                'icon' => 'Layers',
                'order' => 1,
            ],
            [
                'slug' => 'custom-erp-development',
                'title' => [
                    'en' => 'Custom ERP Development',
                    'id' => 'Pengembangan ERP Kustom',
                ],
                'description' => [
                    'en' => 'Integrated finance, operations, inventory, and reporting systems tailored to organizational structure.',
                    'id' => 'Sistem keuangan, operasi, inventaris, dan pelaporan terintegrasi yang disesuaikan dengan struktur organisasi.',
                ],
                'icon' => 'Database',
                'order' => 2,
            ],
            [
                'slug' => 'hris-solutions',
                'title' => [
                    'en' => 'HRIS',
                    'id' => 'HRIS',
                ],
                'description' => [
                    'en' => 'Attendance, payroll logic, approvals, and compliance-aligned HR workflows.',
                    'id' => 'Kehadiran, logika penggajian, persetujuan, dan alur kerja HR yang sesuai kepatuhan.',
                ],
                'icon' => 'Users',
                'order' => 3,
            ],
            [
                'slug' => 'point-of-sale',
                'title' => [
                    'en' => 'Point of Sale (POS)',
                    'id' => 'Point of Sale (POS)',
                ],
                'description' => [
                    'en' => 'Real-time sales, inventory synchronization, and multi-outlet management.',
                    'id' => 'Penjualan real-time, sinkronisasi inventaris, dan manajemen multi-outlet.',
                ],
                'icon' => 'ShoppingCart',
                'order' => 4,
            ],
            [
                'slug' => 'warehouse-management',
                'title' => [
                    'en' => 'Warehouse Management System (WMS)',
                    'id' => 'Warehouse Management System (WMS)',
                ],
                'description' => [
                    'en' => 'Inventory accuracy, picking optimization, logistics coordination, and ERP integration.',
                    'id' => 'Akurasi inventaris, optimisasi picking, koordinasi logistik, dan integrasi ERP.',
                ],
                'icon' => 'Package',
                'order' => 5,
            ],
            [
                'slug' => 'document-management',
                'title' => [
                    'en' => 'Document Management System (DMS)',
                    'id' => 'Document Management System (DMS)',
                ],
                'description' => [
                    'en' => 'Centralized documents, approval workflows, version control, and audit trails.',
                    'id' => 'Dokumen terpusat, alur kerja persetujuan, kontrol versi, dan jejak audit.',
                ],
                'icon' => 'FileText',
                'order' => 6,
            ],
            [
                'slug' => 'system-integration',
                'title' => [
                    'en' => 'System Integration & Automation',
                    'id' => 'Integrasi Sistem & Otomasi',
                ],
                'description' => [
                    'en' => 'API-based integration between internal systems, third-party platforms, and legacy applications.',
                    'id' => 'Integrasi berbasis API antara sistem internal, platform pihak ketiga, dan aplikasi legacy.',
                ],
                'icon' => 'GitMerge',
                'order' => 7,
            ],
            [
                'slug' => 'strategic-website',
                'title' => [
                    'en' => 'Strategic Website Development',
                    'id' => 'Pengembangan Website Strategis',
                ],
                'description' => [
                    'en' => 'Corporate and business websites designed as part of a broader digital strategy and system ecosystem.',
                    'id' => 'Website korporat dan bisnis yang dirancang sebagai bagian dari strategi digital dan ekosistem sistem yang lebih luas.',
                ],
                'icon' => 'Globe',
                'order' => 8,
            ],
        ];

        foreach ($solutions as $solution) {
            Solution::create($solution + ['is_active' => true]);
        }
    }
}
