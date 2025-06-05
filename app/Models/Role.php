<?php

use Spatie\Permission\Models\Role;

$roles = ['Admin', 'Staff', 'Freelance', 'Customer'];

foreach ($roles as $roleName) {
    $role = Role::where('name', $roleName)->first();
    if ($role) {
        echo "Role '$roleName' exists, skipping.\n";
    } else {
        Role::create(['name' => $roleName]);
        echo "Role '$roleName' created.\n";
    }
}
