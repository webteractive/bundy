<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    protected $users = [
        ['marge@eetech.com', 'Margelyn Espina'],
        ['glen@eetechmedia.com', 'Glen Bangkila'],
        ['mark@eetechmedia.com', 'Mark Tacatani'],
        ['goper@eetechmedia.com', 'Goper Zosa'],
        ['jeremy@eetechmedia.com', 'Jeremy Paculio'],
        ['philip@eetechmedia.com', 'Philip Candole'],
        ['sheena@eetechmedia.com', 'Sheena Catacutan'],
        ['isiah@eetechmedia.com', 'Isiah Domingo'],
        ['reynand@eetechmedia.com', 'Reynand Collado']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $key => $user) {
            [$email, $name] = $user;
            User::forceCreate([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('secret'),
                'email_verified_at' => now()
            ]);
        }
    }
}
