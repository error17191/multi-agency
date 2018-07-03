<?php

namespace App\Console\Commands\Agency\Migrations;

use App\Agency;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Database\DatabaseManager;

class Rollback extends RollbackCommand
{

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rolls back agency migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct(app('migrator'));
        $this->setName('agency:rollback');
        $this->db = $db;
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
            $this->info('Rolling back Agency - ' . $agency->uid);
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
