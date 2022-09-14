<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
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
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Reza Hartono',
            'email' => 'admin@my-todo.dev',
            'password' => Hash::make('admin'),
            'email_verified_at' => Date::now(),
            'role' => 'admin',
        ]);

        State::create([
            'name' => 'Draft'
        ]);
        State::create([
            'name' => 'In Progress'
        ]);
        State::create([
            'name' => 'Completed'
        ]);
        State::create([
            'name' => 'Closed'
        ]);
    }
}
