<?php

namespace App\Http\Controllers;

class SinglePageController extends Controller
{
    public function __invoke()
    {
        return view('app');
    }
}
