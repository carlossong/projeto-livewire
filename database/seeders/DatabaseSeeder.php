<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory()->create([
            'name' => 'José Carlos',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Master10')
        ]);

        \App\Models\User::factory(150)->create();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            PermissionRoleTableSeeder::class,
            RoleUserTableSeeder::class,
        ]);
    }
}
