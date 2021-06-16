<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class VariableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variable = new \App\Variable;
        $variable->name = 'LastUserEntriesIDSync';
        $variable->value = 0;
        $variable->save();

        $variable = new \App\Variable;
        $variable->name = 'LastLoginUsersEntriesIDSync';
        $variable->value = 0;
        $variable->save();
    }
}

