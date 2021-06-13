<?php

use Illuminate\Database\Seeder;
use \App\Click;

class ClickTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $click = new Click;
        $click->name = 'Vanue';
        $click->description = 'Es la primera excena, es aquella que tiene la flecha blanca';
        $click->save();
    }
}
