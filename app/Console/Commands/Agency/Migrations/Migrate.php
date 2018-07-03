<?php

namespace App\Console\Commands\Agency\Migrations;

use App\Agency;
use App\Travninja\Traits\Console\RunsForMultipleAgencyDB;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\DatabaseManager;

class Migrate extends MigrateCommand
{
    use RunsForMultipleAgencyDB;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates Agency Tables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(app('migrator'));
//        $this->prepare('agency:migrate');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->runForAgencies();
    }

}
