<?php

namespace App\Travninja\Traits\Console;


use Illuminate\Database\Eloquent\Collection;
use App\Agency;

trait RunsForMultipleAgencyDB
{
    protected function runForAgencies(Collection $agencies)
    {

        if (!$this->confirmToProceed()) {
            return;
        }

        $this->input->setOption('database', 'agency');
        $this->input->setOption('path', realpath(database_path('migrations/agencies')));

        if ($agencies->count() == 0) {
            $this->warn("No Agencies Yet");
            return;
        }

        foreach ($agencies as $agency) {
            $this->output->title('Running Command For Agency:  ' . $agency->uid);
            Agency::current($agency);

            $this->db->reconnect();
            parent::handle();
            $this->db->purge();
        }


    }

}