<?php

use App\Child;
use App\Checkin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ChildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Child::class, 20)->create()->each(function($child) {
            for ($i=0; $i <= 30; $i++) {
                $child->checkins()->create([
                    'created_at' => Carbon::now()->subDays($i)
                ]);
            }
            $child->addWeeklyTotal();
            $child->sluggable();
        });
    }
}
