<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name' => config('site.role.admin'),
                'guard_name' => 'web'
            ],
            [
                'name' => config('site.role.hr'),
                'guard_name' => 'web'
            ],
            [
                'name' => config('site.role.manager'),
                'guard_name' => 'web'
            ]
        ]);
    }
}
