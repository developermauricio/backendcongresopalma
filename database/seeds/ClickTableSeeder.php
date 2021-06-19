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

        $tvOnDeman = ['TV On Deman No. 1', 'TV On Deman No. 2', 'TV On Deman No. 3', 'TV On Deman No. 4', 'TV On Deman No. 5', 'TV On Deman No. 6', 'TV On Deman No. 7', 'TV On Deman No. 8'];
        foreach($tvOnDeman as $tv) {
            $click = new Click;
            $click->name = $tv;
            $click->points = 50;
            $click->save();
        }        

        $click = new Click;
        $click->name = 'Pabellon';
        $click->points = 50;
        $click->save();

        $listStands = [
            'Expositor No. 1', 'Expositor No. 2', 'Expositor No. 3', 'Expositor No. 4', 'Expositor No. 5 CID PALMERO', 'Expositor No. 6', 'Expositor No. 7 SOLUXIONAR', 'Expositor No. 8 FEDEPALMA', 'Expositor No. 9 SEPALM',
            'Patrocinador bronce No. 1', 'Patrocinador oro No. 1 RSPO', 'Patrocinador bronce No. 2 Tienda Palmera',
            'Patrocinador plata No. 1 MONÓMEROS', 'Patrocinador plata No. 2 METALTECO',
            'Expositor No. 10', 'Expositor No. 11', 'Expositor No. 12', 'Expositor No. 13', 'Expositor No. 14', 'Expositor No. 15', 'Expositor No. 16 SUPLEMENTOS AGROPULI', 'Expositor No. 17 CENIPALMA', 'Expositor No. 18 BIOTEC',
            'Patrocinador plata No. 3 INDUSTRIAS ACUÑA', 'Patrocinador bronce No. 3 BIOD S.A.', 'Patrocinador bronce No. 4 FEDEBIO COMBUSTIBLES',
            'Patrocinador plata No. 4 YARA', 'Patrocinador oro No. 2 BONANZA', 'Patrocinador plata No. 5 POLCO',
        ];
        foreach($listStands as $stand) {
            $click = new Click;            
            $click->name = $stand;
            $click->points = 100;
            $click->save();
        }   

        $click = new Click;            
        $click->name = 'Patrocinador esmeralda TECNOPALMA'     ;
        $click->points = 200;
        $click->save();        

        /* $click = new Click;
        $click->name = 'Stand Tecno Palma';
        $click->points = 200;
        $click->save(); */

        $click = new Click;
        $click->name = 'Chat';
        $click->points = 100;
        $click->save();
    }
}
