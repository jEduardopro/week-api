<?php

namespace Database\Seeders;

use App\Models\Proyect;
use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()
        //     ->count(5)
        //     ->has(
        //         Proyect::factory()->count(3)
        //             ->has(
        //                 Task::factory()->count(3)
        //                     ->hasDocuments(3)
        //                     ->has(Subtask::factory()->count(3)->hasDocuments(3))
        //             )
        //     )->hasDocuments(3)
        //     ->create();
        User::factory()->count(2)
            ->has(Proyect::factory()->count(10))
            ->has(Task::factory()->count(10)->has(Subtask::factory()->count(3)->hasDocuments(2))->hasDocuments(2))
            ->hasDocuments(5)
            ->create();
    }
}
