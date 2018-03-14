<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Pais;

class PaisController extends Controller
{


    public function __construct()
    {

    }

    public function allAction()
    {
        return Pais::spainFirstList()->toJSON();
    }



}
