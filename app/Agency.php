<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agency extends Model
{
    protected $fillable = ['uid'];

    protected static $currentAgency;

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($agency) {
            DB::statement("
                CREATE DATABASE `{$agency->dbName()}`
            ");
        });

        self::deleting(function ($agency) {
            DB::statement("
                DROP DATABASE `{$agency->dbName()}`
            ");
        });
    }

    public static function findByUid($uid)
    {
        return self::where('uid', $uid)->first();
    }

    public static function findByUidOrFail($uid)
    {
        return self::findByUid($uid) ?: abort(404);
    }

    public static function current($agency = null)
    {
        if (is_null($agency)) {
            return self::$currentAgency;
        }
        self::$currentAgency = $agency;
        app('url')->defaults([
            'agency' => $agency->uid
        ]);
        $agencyConnection = config('database.connections.mysql');
        $agencyConnection['database'] = $agency->dbName();
        config()->set('database.connections.agency', $agencyConnection);
        config()->set('database.default', 'agency');

    }

    public function dbName()
    {
        return "agency-{$this->uid}";
    }

}
