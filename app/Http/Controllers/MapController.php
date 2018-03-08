<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function showInitialMapPage()
    {
        return view('publicarea.mapa');
    }
}
