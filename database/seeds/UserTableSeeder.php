<?php

use Illuminate\Database\Seeder;
use \App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        User::truncate();

        $user = new User;
        $user->name = 'admin';
        $user->email = 'kevingonzalez.developer@gmail.com';
        $user->password = 'comoquesi';
        $user->save();

        $user = new User;
        $user->name = 'juan';
        $user->email = 'tek16576@cuoly.com';
        $user->password = 'comoquesi';
        $user->save();

        $user = new User;
        $user->name = 'susan';
        $user->email = 'susan@gmail.com';
        $user->password = 'comoquesi';
        $user->save();


    }
}
