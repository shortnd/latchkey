<?php

use App\User;
use Illuminate\Database\Seeder;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::first()->assign('superuser');
    }
}
