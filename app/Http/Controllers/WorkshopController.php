<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function index(){
        return view('workshop.index');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
