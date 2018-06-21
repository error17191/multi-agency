<?php

namespace App\Http\Controllers;

use App\Agency;

class ExampleController extends Controller
{
    public function index($agency)
    {
        dd(Agency::current());
    }
}
