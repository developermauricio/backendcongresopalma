<?php

namespace App\Console\Commands;

use App\Point;
use App\Services\GoogleSheet;
use App\Variable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando permite sincronizar la tabla de puntos con el libro de puntos de google sheet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(GoogleSheet $googleSheet)
    {
        $variable = Variable::query()
            ->where('name', 'LastPointsIDSync')
            ->first();

        $rows = Point::query()
            ->where('id', '>', $variable->value)
            ->with('user')
            ->orderBy('id')
            ->limit(10)
            ->get();

        if ($rows->count() === 0){
            return  true;
        }

        $finalData = collect();
        $lastId = 0;
        Log::debug($rows);
        foreach ($rows as $row){
            $finalData->push([
                $row->id,
                $row->user->name,
                $row->user->email,
                $row->points,
                $row->click_name,
                $row->created_at,
            ]);
            $lastId = $row->id;
        }
        Log::debug($finalData->toArray());
        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1VSokLQMjcBQ6-t8yjtUl91traLym6B5mcAF4-aUQTnI',
            'puntos'
        );
        $variable->value = $lastId;
        $variable->save();

        return true;
    }
}
