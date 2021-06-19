<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(ClickTableSeeder::class);
         $this->call(VariableTableSeeder::class);


//         factory(\App\User::class, 500)->create();

//         factory(\App\Point::class, 200)->create(
//             [
//                 'points' => 25,
//                 'click_name' => 'Auditorio',
//                 'click_id' => 1
//             ]
//         );
//
//        factory(\App\Point::class, 150)->create(
//            [
//                'points' => 25,
//                'click_name' => 'Rendición de Cuentas',
//                'click_id' => 2
//            ]
//        );
//
//        factory(\App\Point::class, 150)->create(
//            [
//                'points' => 50,
//                'click_name' => 'Pabellon',
//                'click_id' => 11
//            ]
//        );
    }
}
