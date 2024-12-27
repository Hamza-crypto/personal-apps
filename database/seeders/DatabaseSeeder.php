<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\LastBilledReading;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $names = LastBilledReading::getMeters();
        foreach ($names as $key => $name) {
            LastBilledReading::factory([
                'meter_name' => $key
            ])->create();
        }
    
        $this->call(MeterReadingSeeder::class);
    }
}
