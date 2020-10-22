<?php

namespace Database\Seeders;

use App\Models\Proyect;
use Illuminate\Database\Seeder;

class ProyectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proyect::factory()->count(5)->create();
    }
}
