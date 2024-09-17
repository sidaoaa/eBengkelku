<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductSellerController extends Controller
{
    public function index() {
        return view('profile.dashboard.workshopSET.product.index');
    }
    public function create() {
        return view('profile.dashboard.workshopSET.product.create');
    }
}
