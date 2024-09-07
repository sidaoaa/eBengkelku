<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SparePartSellerController extends Controller
{
    public function index() {
        return view('profile.dashboard.workshopSET.spare_part.index');
    }
    public function create(){
        return view('profile.dashboard.workshopSET.spare_part.create');
    }
}
