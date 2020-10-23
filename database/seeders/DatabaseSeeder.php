<?php

namespace Database\Seeders;

use App\Models\Department;
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
        Department::factory()->count(5)->create();
        User::factory()->count(2)
            ->has(Proyect::factory()->count(5))
            ->has(Task::factory()->count(5)->hasLikes(2)->has(Subtask::factory()->count(3)->hasDocuments(2)->hasLikes(2))->hasDocuments(2))
            ->hasDocuments(5)
            ->create();
    }
}
