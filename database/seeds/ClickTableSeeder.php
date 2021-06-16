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
        $click->name = 'Auditorio';
        $click->description = '';
        $click->points = 25;
        $click->save();

        $click = new Click;
        $click->name = 'Rendición de Cuentas';
        $click->points = 25;
        $click->save();

        $click = new Click;
        $click->name = 'TV On Deman';
        $click->points = 50;
        $click->save();

        $click = new Click;
        $click->name = 'Pabellon';
        $click->points = 50;
        $click->save();

        $click = new Click;
        $click->name = 'Stand';
        $click->points = 100;
        $click->save();

        $click = new Click;
        $click->name = 'Chat';
        $click->points = 100;
        $click->save();
    }
}
