<?php

namespace App\Console\Commands\Agency;

use App\Agency;
use Illuminate\Database\Console\Migrations\MigrateCommand;

class Migrate extends MigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'm {--database= : The database connection to use.}
                {--force : Force the operation to run when in production.}
                {--path= : The path to the migrations files to be executed.}
                {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths.}
                {--pretend : Dump the SQL queries that would be run.}
                {--seed : Indicates if the seed task should be re-run.}
                {--step : Force the migrations to be run so they can be rolled back individually.}';

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
    public function __construct()
    {
        parent::__construct(app('migrator'));
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
        foreach ($agencies as $agency) {
            $this->info('Migrating Agency - ' . $agency->uid);
            Agency::current($agency);
            parent::handle();

        }
    }

    protected function getMigrationPaths()
    {
        return [database_path('migrations/agencies/')];
    }

}
