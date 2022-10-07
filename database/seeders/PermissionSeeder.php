<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_access',
            ],
            [
                'id'    => 2,
                'title' => 'client_access',
            ],
            [
                'id'    => 3,
                'title' => 'role_access',
            ],
            [
                'id'    => 4,
                'title' => 'permission_access',
            ],
            [
                'id'    => 5,
                'title' => 'ticket_access',
            ],
            [
                'id'    => 6,
                'title' => 'product_access',
            ],
            [
                'id'    => 7,
                'title' => 'service_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
