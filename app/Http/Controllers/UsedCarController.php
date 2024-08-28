<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsedCarController extends Controller
{
    public function index(){
        return view('used_car.index');
    }

}
