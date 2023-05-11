<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

    public function __invoke(User $user)
    {
        $user = Auth::user();
        dd($user);
        if ((Auth()->user()->email  == "erentin@outlook.com")) {
            abort(403, "ADMİN PANELE ERİŞİM İZNİNİZ YOK!");
        };
    }
    

    public function index(User $user)
    {
        $user = Auth::user();
        

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

    public function create()
    {
        return view("admin.create");
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'live_at' => now(),
        ]);

        return back();
    }

    public function storeVariation(Request $request)
    {
        $variation = Variation::create([
            'product_id' => $request->input('productId'),
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'type' => $request->input('type'),
            'sku' => $request->input('sku'),
            'parent_id' => $request->input('parentId'),
            'order' => $request->input('order'),
            'created_at' => now(),
        ]);

        return back();
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
