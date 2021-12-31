<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Modules\Basket\Facades\Basket;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $basketItems = unserialize(cache()->get('products'));
        
        $basketItemsCount = $basketItems ? count($basketItems) : 0;

        $products = Product::all();
        return view('home' , compact('products' , 'basketItemsCount'));
    }

    public function addToBasket(Product $product)
    {
        $basketData = [
            'id'        => $product->id,
            'title'     => $product->title,
            'count'     => 1,
            'price'     => $product->price,
            'instance'  => get_class($product)
        ];
        
        Basket::add('products' , get_class($product) , $basketData);
        
        return back();
        
    }
}
