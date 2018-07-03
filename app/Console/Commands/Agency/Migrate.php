<?php

namespace App\Console\Commands\Agency;

use App\Agency;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\DatabaseManager;

class Migrate extends MigrateCommand
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct(app('migrator'));
        $this->db = $db;
        $this->setName('agency:migrate');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->input->setOption('database', 'agency');

        $agencies = Agency::all();
        if ($agencies->count() == 0) {
            $this->info("No Agencies Yet");
            return;
        }
        foreach ($agencies as $agency) {
            $this->info('Migrating Agency - ' . $agency->uid);
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
