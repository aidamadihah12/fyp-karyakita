<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Customer']);
        Role::create(['name' => 'Freelance']);
    }
}

