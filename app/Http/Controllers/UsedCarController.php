<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsedCarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $priceRange = $request->input('price', '');
        $brand = $request->input('brand', '');

        $query = DB::table('tb_mobil')
            ->where('delete_mobil', 'N')
            ->where('status_mobil', 'Available');

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('jenis_mobil', 'like', '%' . $search . '%')
                  ->orWhere('nama_mobil', 'like', '%' . $search . '%');
            });
        }

        // Apply price range filter
        if (!empty($priceRange)) {
            switch ($priceRange) {
                case '<100':
                    $query->where('harga_mobil', '<', 100000000);
                    break;
                case '100-150':
                    $query->whereBetween('harga_mobil', [100000000, 150000000]);
                    break;
                case '150-200':
                    $query->whereBetween('harga_mobil', [150000000, 200000000]);
                    break;
                case '200-250':
                    $query->whereBetween('harga_mobil', [200000000, 250000000]);
                    break;
                case '>250':
                    $query->where('harga_mobil', '>', 250000000);
                    break;
            }
        }

        // Apply brand filter
        if (!empty($brand)) {
            $query->where('jenis_mobil', $brand);
        }

        $usedCars = $query->get();

        $harga = [
            '<100' => '< 100 Juta',
            '100-150' => '100 - 150 Juta',
            '150-200' => '150 - 200 Juta',
            '200-250' => '200 - 250 Juta',
            '>250' => '> 250 Juta',
        ];

        $brands = [
            'toyota' => 'Toyota',
            'suzuki' => 'Suzuki',
            'honda' => 'Honda',
            'daihatsu' => 'Daihatsu',
            'mitsubishi' => 'Mitsubishi',
            'nissan' => 'Nissan',
            'mercy' => 'Mercedes Benz',
            'bmw' => 'BMW',
        ];

        return view('used_car.index', compact('usedCars', 'harga', 'brands', 'search', 'priceRange', 'brand'));
    }

    public function itemCar($id)
    {
        $used_car = DB::table('tb_mobil')
            ->where('id_mobil', $id)
            ->where('delete_mobil', 'N')
            ->firstOrFail();

        return view('used_car.itemcar', ['used_car' => $used_car]);
    }

    public function owner($id)
    {
        $used_car_available = DB::table('tb_mobil')
            ->where('delete_mobil', 'N')
            ->where('id_pelanggan', $id)
            ->where('status_mobil', 'Available')
            ->get();

        $used_car_soldout = DB::table('tb_mobil')
            ->where('delete_mobil', 'N')
            ->where('id_pelanggan', $id)
            ->where('status_mobil', 'Soldout')
            ->get();

        return view('used_car.owner', compact('used_car_available', 'used_car_soldout'));
    }
}    
