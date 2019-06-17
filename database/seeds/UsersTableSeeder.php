<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    protected $users = [
        ['marge@eetech.com', ['Margelyn', 'Espina'], 'marge', 2],
        ['glen@eetechmedia.com', ['Glen', 'Bangkila'], 'glen', 1],
        ['mark@eetechmedia.com', ['Mark', 'Tacatani'], 'marky', 2],
        ['goper@eetechmedia.com', ['Goper', 'Zosa'], 'goper', 2],
        ['jeremy@eetechmedia.com', ['Jeremy', 'Paculio'], 'poy', 2],
        ['philip@eetechmedia.com', ['Philip', 'Candole'], 'philipp', 2],
        ['sheena@eetechmedia.com', ['Sheena', 'Catacutan'], 'sheena', 2],
        ['isiah@eetechmedia.com', ['Isiah', 'Domingo'], 'isiah', 2],
        ['reynand@eetechmedia.com', ['Reynand', 'Collado'], 'reynand', 2]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $key => $user) {
            [$email, [$firstName, $lastName], $username, $role] = $user;
            User::forceCreate([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'role_id' => $role,
                'username' => $username,
                'password' => bcrypt('secret'),
                'email_verified_at' => now()
            ]);
        }
    }
}
