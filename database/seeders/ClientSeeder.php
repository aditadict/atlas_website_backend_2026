<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['name' => 'TechCorp Industries', 'order' => 1],
            ['name' => 'Global Retail Group', 'order' => 2],
            ['name' => 'Manufacturing Plus', 'order' => 3],
            ['name' => 'Logistics Pro', 'order' => 4],
            ['name' => 'Service Excellence', 'order' => 5],
            ['name' => 'Retail Solutions', 'order' => 6],
        ];

        foreach ($clients as $client) {
            Client::create($client + ['is_active' => true]);
        }
    }
}
