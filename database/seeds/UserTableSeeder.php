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
        $user->name = 'Mauricio';
        $user->email = 'mao@gmail.com';
        $user->password = 'comoquesi';
        $user->save();


    }
}
