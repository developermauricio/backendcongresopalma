<?php

namespace App\Console\Commands;

use App\Services\GoogleSheet;
use App\User;
use App\Variable;
use Illuminate\Console\Command;

class SyncUsersEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:usersentries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando permite sincronizar la tabla de usuarios con el libro de usuarios de google sheet';

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
            ->where('name', 'LastUserEntriesIDSync')
            ->first();

        $rows = User::query()
            ->where('id', '>', $variable->value)
            ->orderBy('id')
            ->limit(10)
            ->get();

        if ($rows->count() === 0){
            return  true;
        }

        $finalData = collect();
        $lastId = 0;

        foreach ($rows as $row){
            $finalData->push([
                $row->id,
                $row->name,
                $row->email,
            ]);

            $lastId = $row->id;
        }

        $googleSheet->saveDataToSheet($finalData->toArray(), env('USUARIOS_REGISTRADOS_LIBRO'));
        $variable->value = $lastId;
        $variable->save();

        return true;

    }
}