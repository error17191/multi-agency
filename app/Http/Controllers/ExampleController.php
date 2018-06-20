<?php

namespace App\Http\Controllers;

use App\Agency;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index($agency)
    {
        dd(Agency::current());
    }
}
