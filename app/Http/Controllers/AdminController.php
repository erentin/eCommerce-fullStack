<?php

namespace App\Http\Controllers;


use App\Models\Variation;
use App\Models\User;
use App\Models\Stock;
use App\Models\Cart;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminController extends Controller
{       

    // public function __construct(User $user)
    // {
        

    //     if (!($user && $user->email  == "admin@ecommerce.test")) {
    //         abort(403, "ADMİN PANELE ERİŞİM İZNİNİZ YOK!");
    //     };
    // }
    

    public function index()
    {
        $date = Carbon::today()->subDays(30);
        $carts = Cart::where('created_at','>=',$date)->get();
        $orders = Order::where('created_at','>=',$date)->latest()->get();
        $ordersTotalCount = $orders->count();
        $orders = Order::where('created_at','>=',$date)->latest()->paginate(10);


        return  view("admin.index", [
            'users' => User::latest()->get(),
            'carts' => $carts,
            'orders' => $orders,
            'ordersTotalCount' => $ordersTotalCount,
            'stocks' =>  Stock::select('variation_id')
            ->groupBy('variation_id')
            ->get(),
        ]);
    }

    public function showOrder(Order $order)
    {
        $order = Order::find($order)->first();


        return view("admin.order", [
            
            'order' => $order,
            
        ]);
    }

    public function orders()
    {
        $orders = Order::latest()->paginate(20);

        return view("admin.products", [
            
            'orders' => $orders,
            
        ]);
    }
}
