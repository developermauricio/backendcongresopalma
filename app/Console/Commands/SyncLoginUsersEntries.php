<?php

namespace App\Console\Commands;

use App\LoginUser;
use App\Services\GoogleSheet;
use App\Variable;
use Illuminate\Console\Command;

class SyncLoginUsersEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:loginuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando permite sincronizar la tabla de loginUser con el libro de Usuarios Libros de google sheet';

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
            ->where('name', 'LastLoginUsersEntriesIDSync')
            ->first();

        $rows = LoginUser::query()
            ->where('id', '>', $variable->value)
            ->orderBy('id')
            ->limit(100)
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
                $row->created_at,
            ]);

            $lastId = $row->id;
        }

        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            "1hTqFNCSxy2KHiGL0BiFv1S3X2-6CjydW74U6gpSHzAI",
            'UsuariosAuth'
        );
        $variable->value = $lastId;
        $variable->save();

        return true;
    }
}
