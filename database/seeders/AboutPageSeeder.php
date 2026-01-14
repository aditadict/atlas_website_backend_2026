<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPage::create([
            'years_experience' => 5,
            'systems_delivered' => 50,
            'industries_served' => 4,
            'headline' => [
                'en' => 'IT Consulting & Custom Software That Runs Your Business — Not the Other Way Around',
                'id' => 'Konsultan IT & Software Kustom yang Menjalankan Bisnis Anda — Bukan Sebaliknya',
            ],
            'subheadline' => [
                'en' => 'We help companies digitalize their business through consulting-first strategy, business process analysis, and custom-built systems — designed to fit how organizations actually operate.',
                'id' => 'Kami membantu perusahaan mendigitalisasi bisnis mereka melalui strategi konsultan-pertama, analisis proses bisnis, dan sistem yang dibangun khusus — dirancang sesuai dengan cara organisasi benar-benar beroperasi.',
            ],
            'story' => [
                'en' => "Founded with a vision to bridge the gap between business needs and technology solutions, Atlas Digitalize has grown to become a trusted partner for companies seeking digital transformation.\n\nWe don't believe in one-size-fits-all solutions. Every business is unique, and so should be its systems. That's why we start every engagement with deep business analysis and consulting.\n\nOur team combines industry expertise with technical excellence to deliver systems that truly fit how your organization operates.",
                'id' => "Didirikan dengan visi untuk menjembatani kesenjangan antara kebutuhan bisnis dan solusi teknologi, Atlas Digitalize telah berkembang menjadi mitra terpercaya bagi perusahaan yang mencari transformasi digital.\n\nKami tidak percaya pada solusi satu ukuran untuk semua. Setiap bisnis unik, begitu juga sistemnya. Itulah mengapa kami memulai setiap keterlibatan dengan analisis bisnis dan konsultasi mendalam.\n\nTim kami menggabungkan keahlian industri dengan keunggulan teknis untuk memberikan sistem yang benar-benar sesuai dengan cara organisasi Anda beroperasi.",
            ],
            'mission' => [
                'en' => 'Our mission is to empower businesses with technology that truly serves their needs, not force them to adapt to rigid systems. We believe in understanding your business first, then building solutions that enhance your operations.',
                'id' => 'Misi kami adalah memberdayakan bisnis dengan teknologi yang benar-benar melayani kebutuhan mereka, bukan memaksa mereka untuk beradaptasi dengan sistem yang kaku. Kami percaya dalam memahami bisnis Anda terlebih dahulu, kemudian membangun solusi yang meningkatkan operasi Anda.',
            ],
            'vision' => [
                'en' => 'To be the trusted technology partner for businesses across Indonesia, known for delivering custom solutions that drive real digital transformation and business growth.',
                'id' => 'Menjadi mitra teknologi terpercaya untuk bisnis di seluruh Indonesia, dikenal karena memberikan solusi kustom yang mendorong transformasi digital nyata dan pertumbuhan bisnis.',
            ],
            'is_active' => true,
        ]);
    }
}
