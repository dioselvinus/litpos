<?php

namespace Database\Seeders;

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
        $this->call([
            RoleSeeder::class,
        ]);
        \App\Models\User::factory(1)->create()->each(function ($user) {
            $user->assignRole('employee');
        });
        \App\Models\User::factory(1)->create()->each(function ($user) {
            $user->assignRole('admin');
        });
        \App\Models\User::factory(1)->create()->each(function ($user) {
            $user->assignRole('manager');
        });
        \App\Models\Product::factory(100)->create();
    }
}
