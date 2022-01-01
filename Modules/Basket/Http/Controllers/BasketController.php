<?php

namespace Modules\Basket\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Basket\Facades\Basket;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function all($cacheName)
    {
        $basketItems = Basket::all($cacheName);
        
        if( ! $basketItems ) return back();

        $totalPrice = 0;

        foreach($basketItems as $item){
            $totalPrice += $item['price'] * $item['count'];
        }

        return view('basket::frontend.basket.index' , compact('basketItems' , 'cacheName' , 'totalPrice'));
    }
    
    public function addCount($cacheName , $id)
    {
        Basket::addCount($cacheName , $id);

        return back();
    }

    
    
    public function decreaseCount($decCount , $cacheName , $id)
    {
        Basket::decreaseCount($cacheName , $id , $decCount);

        if( ! Basket::all($cacheName) ){
            return redirect('/');
        }

        return back();
    }
}
