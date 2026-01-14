<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'company' => 'Tech Solutions Inc.',
                'phone' => '+1234567890',
                'service' => 'Custom Software Development',
                'message' => 'We are looking to develop a custom CRM system for our sales team.',
                'language' => 'en',
                'status' => 'new',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'company' => 'Digital Marketing Agency',
                'phone' => '+1987654321',
                'service' => 'UI/UX Design',
                'message' => 'Need a complete redesign of our website to improve user experience.',
                'language' => 'en',
                'status' => 'read',
            ],
            [
                'name' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@example.com',
                'company' => 'PT. Teknologi Masa Depan',
                'phone' => '+628123456789',
                'service' => 'Mobile App Development',
                'message' => 'Kami membutuhkan aplikasi mobile untuk layanan e-commerce kami.',
                'language' => 'id',
                'status' => 'new',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'company' => 'Retail Chain Corp',
                'phone' => '+1555123456',
                'service' => 'Cloud Migration',
                'message' => 'Looking to migrate our on-premise systems to AWS cloud infrastructure.',
                'language' => 'en',
                'status' => 'responded',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'company' => 'CV. Maju Jaya',
                'phone' => '+628987654321',
                'service' => 'Web Development',
                'message' => 'Butuh website untuk toko online dengan sistem pembayaran terintegrasi.',
                'language' => 'id',
                'status' => 'archived',
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
