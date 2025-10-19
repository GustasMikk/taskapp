<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'example',
            'email' => 'example@example.com',
            'password' => bcrypt('example'),
        ]);

        $user2 = User::factory()->create([
            'name' => 'example2',
            'email' => 'example2@example.com',
            'password' => bcrypt('example2'),
        ]);

        Task::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        Task::factory()->count(7)->create([
            'user_id' => $user2->id,
        ]);
    }
}
