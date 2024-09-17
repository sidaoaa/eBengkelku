<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceSellerController extends Controller
{
    public function index() {
        return view('profile.dashboard.workshopSET.service.index');
    }

    public function create() {
        return view('profile.dashboard.workshopSET.service.create');
    }
}
