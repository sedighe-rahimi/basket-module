<?php

namespace Modules\Basket\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class BasketService
{
    protected $timeout = 360;

    public function add($cacheName , $instance , $dataArray)
    {
        // sample : proruct for Model\App\Product
        // $itemsModelName = strtolower(last(explode('\\' , get_class($instance))));

        if( key_exists('id' , $dataArray) && key_exists('instance' , $dataArray) && key_exists('title' , $dataArray) && key_exists('price' , $dataArray) && key_exists('count' , $dataArray) )
        {
            $data = $dataArray;
        }else{
            return false;
        }

        $items = cache()->remember($cacheName , $this->timeout , function() use ($data) {
            $items = array();
            array_push($items , $data);
            return serialize($items);
        });

        if( ! is_null( $items = cache()->get($cacheName) ) ){
            $items      = unserialize($items);
            $newItems   = array();
            $existItem  = false;

            foreach( $items as $key => $item )
            {
                if( $dataArray['id'] == $item['id'] ){
                    $existItem = true;
                    $dbItem = $instance::find($item['id']);
                    if( ! $dbItem )  abort(404);
                    
                    if($dbItem->count > $item['count']){
                        $item['count'] = $item['count'] + 1;
                    }else{
                        return false;
                    }
                }
                array_push($newItems , $item);
            }

            if($existItem){
                $items = $newItems;
            }else{
                array_push($items , $data);
            }

            $serializedItems = serialize($items);
        }
        
        
        // if( ! is_null($items) ){
        //     cache()->set($cacheName , $items , $this->timeout);
        // }else{
        //     cache()->forget($cacheName);
        //     return redirect(route('basket.index' , ['cacheName' => $cacheName]));
        // }
           
        if( ! empty($items) ){
            cache()->set($cacheName , $serializedItems , $this->timeout);
        }else{
            cache()->forget($cacheName);
        }
 

        return true;        
    }

    

    public function decreaseCount($cacheName , $decCount = 1 , $dataArray)
    {
        if( key_exists('id' , $dataArray))
        {
            $data = $dataArray;
        }else{
            return false;
        }

        if( ! is_null( $items = cache()->get($cacheName) ) ){
            $items      = unserialize($items);
            $newItems   = array();

            foreach( $items as $key => $item )
            {
                if( $dataArray['id'] == $item['id'] ){
                    $newCount = $item['count'] - $decCount;
                    if( $newCount > 0 ){
                        $item['count'] = $newCount;
                        array_push($newItems , $item);
                    }
                }else{
                    array_push($newItems , $item);
                }
            }

            $items = $newItems;

            $serializedItems = serialize($items);
            
        }
        
        
        if( ! empty($items) ){
            cache()->set($cacheName , $serializedItems , $this->timeout);
        }else{
            cache()->forget($cacheName);
        }

        return redirect(route('basket.index' , ['cacheName' => $cacheName]));        
    }

}