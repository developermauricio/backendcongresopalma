<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncTimeEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:entries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite ejecutar cambios en la DB y guardar en google Sheet';

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
    public function handle()
    {
        // Verificar la ultima vez que se guardo
        // Consultar la DB para ver si hay nuevas entredas

    }
}
