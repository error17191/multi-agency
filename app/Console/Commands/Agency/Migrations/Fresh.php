<?php

namespace App\Console\Commands\Agency;

use App\Agency;
use App\Travninja\Traits\Console\RunsForMultipleAgencyDB;
use Illuminate\Database\Console\Migrations\FreshCommand;
use Illuminate\Database\DatabaseManager;

class Fresh extends FreshCommand
{
    use RunsForMultipleAgencyDB;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh Agency Migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct();
        $this->setName('agency:fresh');
        $this->db = $db;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $agencies = Agency::all();

        $this->runForAgencies($agencies);

    }
}
