<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    protected $roles = [
        ['Admin', '[*]'],
        ['Employee', '[]'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $key => $role) {
            [$name, $permissions] = $role;
            Role::forceCreate([
                'name' => $name,
                'permissions' => $permissions,
            ]);
        }
    }
}
