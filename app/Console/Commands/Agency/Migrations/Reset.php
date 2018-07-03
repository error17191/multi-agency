<?php

namespace App\Console\Commands\Agency\Migrations;

use Illuminate\Database\Console\Migrations\ResetCommand;
use App\Agency;
use Illuminate\Database\DatabaseManager;

class Reset extends ResetCommand
{

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets Agency Migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct(app('migrator'));
        $this->db = $db;
        $this->setName('agency:reset');
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
