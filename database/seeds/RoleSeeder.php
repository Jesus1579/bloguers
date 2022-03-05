<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesArray=[
            ['name' => 'admin'],
            ['name' => 'blogled'],
        ];
        foreach ($rolesArray as $role) {
            Role::firstOrCreate(['name' => $role['name']]);
        }
    }
}
