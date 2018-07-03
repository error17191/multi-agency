<?php

namespace App\Console\Commands\Agency\Migrations;

use Illuminate\Database\Console\Migrations\RefreshCommand;
use App\Agency;
use Illuminate\Database\DatabaseManager;

class Refresh extends RefreshCommand
{

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Running Refresh Command for Agency Databases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct();
        $this->db = $db;
        $this->setName('agency:refresh');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->input->setOption('database', 'agency');

        $agencies = Agency::all();

        if ($agencies->count() == 0) {
            $this->info("No Agencies Yet");
            return;
        }

        foreach ($agencies as $agency) {
            $this->info('Refreshing Agency - ' . $agency->uid);
            Agency::current($agency);

            $this->db->reconnect();
            parent::handle();
            $this->db->purge();
        }
    }

    protected function getMigrationPaths()
    {
        return [database_path('migrations/agencies/')];
    }

}
