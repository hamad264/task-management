<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the number of tasks you want to create
        $numberOfTasks = 10;

        // Seed the tasks table with dummy data
        for ($i = 0; $i < $numberOfTasks; $i++) {
            DB::table('tasks')->insert([
                'title' => $this->generateRandomString(),
                'description' => $this->generateRandomString(),
                'priority' => rand(1, 5),
                'due_date' => Carbon::now()->addDays(rand(1, 30))->toDateString(),
                'completed' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate a random string for titles and descriptions.
     *
     * @param int $length
     * @return string
     */
    private function generateRandomString($length = 10)
    {
        return Str::random($length);
    }
}
