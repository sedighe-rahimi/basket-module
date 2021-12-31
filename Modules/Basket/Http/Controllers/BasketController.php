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
        $basketItems = unserialize(cache()->get($cacheName));
        
        if( ! $basketItems ) return back();

        $totalPrice = 0;

        foreach($basketItems as $item){
            $totalPrice += $item['price'] * $item['count'];
        }

        return view('basket::frontend.basket.index' , compact('basketItems' , 'cacheName' , 'totalPrice'));
    }
    
    public function addCount($cacheName , $id)
    {
        if( ! is_null( $items = cache()->get($cacheName) ) ){
            $items      = unserialize($items);
            
            foreach( $items as $key => $item )
            {
                if( $id == $item['id'] ){
                    $existItem = true;

                    $basketData = [
                        'id'        => $item['id'],
                        'title'     => $item['title'],
                        'count'     => 1,
                        'price'     => $item['price'],
                        'instance'  => $item['instance']
                    ];
                    
                }
            }
        }

        if( isset($basketData) ){
            Basket::add($cacheName , $basketData['instance'] , $basketData);
        }

        return back();
    }

    
    
    public function decreaseCount($decCount , $cacheName , $id)
    {
        if( ! is_null( $items = cache()->get($cacheName) ) ){
            $items      = unserialize($items);
            
            foreach( $items as $key => $item )
            {
                if( $id == $item['id'] ){
                    $existItem = true;

                    $basketData = [
                        'id'        => $item['id'],
                    ];
                    
                }
            }
        }

        if( isset($basketData) ){
            Basket::decreaseCount($cacheName , $decCount , $basketData);
            if( is_null( $items = cache()->get($cacheName) ) ){
                return redirect('/');
            }
        }

        return back();
    }
}
