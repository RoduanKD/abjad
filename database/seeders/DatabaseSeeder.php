<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admin = User::factory([
            'name'  => 'Admin',
            'email' => 'admin@abjad.test',
        ])->create();

        $admin->is_admin = true;
        $admin->save();
    }
}
