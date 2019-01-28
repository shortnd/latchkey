<?php

use App\Child;
use App\Checkin;
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
            $child->addCheckin();
            $child->addWeeklyTotal();
            $child->sluggable();
        });
    }
}
