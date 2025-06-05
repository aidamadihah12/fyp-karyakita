<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateRolesCommand extends Command
{
    protected $signature = 'roles:create';
    protected $description = 'Create default roles for the system';

    public function handle()
    {
        $roles = ['Admin', 'Staff', 'Freelance', 'Customer'];

        foreach ($roles as $roleName) {
            if (!Role::where('name', $roleName)->exists()) {
                Role::create(['name' => $roleName]);
                $this->info("✅ Role '{$roleName}' created.");
            } else {
                $this->warn("⚠️ Role '{$roleName}' already exists.");
            }
        }

        return Command::SUCCESS;
    }
}
