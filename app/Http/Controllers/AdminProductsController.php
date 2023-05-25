<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(24);

        return view("adminProducts.index",[
            'products' => $products,
        ]);
    }
}
