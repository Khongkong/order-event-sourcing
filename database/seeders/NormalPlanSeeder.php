<?php

namespace Database\Seeders;

use App\Models\NormalPlan;
use Illuminate\Database\Seeder;

class NormalPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([7, 30])
            ->each(function (int $term) {
                NormalPlan::factory()->create([
                    'term' => $term,
                ]);
            });

    }
}
