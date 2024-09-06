<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        // Logic to fetch and display spare parts
        return view('product.spareparts');
    }
}
