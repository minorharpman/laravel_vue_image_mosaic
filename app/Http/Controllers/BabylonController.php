<?php

namespace App\Http\Controllers;

class BabylonController extends Controller
{
    public function index()
    {
        return view('babylon.index', ['workuri' => env('WORK_URL')]);
    }

    public function mine()
    {
        return view('babylon.mine', ['workuri' => env('WORK_URL')]);
    }

    public function sandbox()
    {
        return view('babylon.sandbox', ['workuri' => env('WORK_URL')]);
    }

    public function physics()
    {
        return view('babylon.physics', ['workuri' => env('WORK_URL')]);
    }

}
