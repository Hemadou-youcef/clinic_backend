<?php

namespace Database\Seeders;

use App\Models\medicine;
use App\Models\patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'sami',
            'lastname' => 'bld',
            'username' => 'sami',
            'password' => Hash::make('samisamo'),
            'role' => 'doctor'
        ]);

        patient::factory()->count(30)->create();
        medicine::factory()->count(30)->create();
        // \App\Models\User::factory(10)->create();
    }
}
