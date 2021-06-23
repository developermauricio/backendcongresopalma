<?php

namespace App\Console\Commands;

use App\GoConference;
use App\Conference;
use App\Services\GoogleSheet;
use App\Variable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncConference extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:conference';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando permite sincronizar la tabla de conferencia con el libro de conferencia de google sheet';

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
            ->where('name', 'LastConferenceIDSync')
            ->first();

        /* $rows = GoConference::query()
            ->where('id', '>', $variable->value)
            ->with('user')
            ->orderBy('id')
            ->limit(100)
            ->get(); */
        $rows = Conference::query()
            ->where('id', '>', $variable->value)
            ->orderBy('id')
            ->limit(100)
            ->get();

        if ($rows->count() === 0){
            return  true;
        }

        $finalData = collect();
        $lastId = 0;

        Log::debug($rows);
        foreach ($rows as $row){
            $finalData->push([
                $row->name,
                $row->email,
                $row->created_at,
            ]);
            $lastId = $row->id;
        }
        Log::debug($finalData->toArray());
        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1sPv2qoHbVy3EL-K6RfrQjtAuPYI2ia3lsL6OjZq-sqA',
            'goConferences'
        );
        $variable->value = $lastId;
        $variable->save();

        return true;
    }
}
