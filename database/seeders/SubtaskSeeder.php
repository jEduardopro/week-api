<?php

namespace Database\Seeders;

use App\Models\Subtask;
use Illuminate\Database\Seeder;

class SubtaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subtask::factory()->count(25)->hasDocuments(3)->create();
    }
}
