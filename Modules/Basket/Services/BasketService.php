<?php

namespace Modules\Basket\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class BasketService
{
    protected $timeout = 360;
    
    /**
     * Add new item to cache or increase count of exist item
     * @param string $cacheName name of cache is set - this is useful for when we want have different type of items in basket
     * @param object $instance model of item
     * @param array $dataArray data of item info
     * @return bool
     */
    public function add($cacheName , $instance , $dataArray)
    {
        // sample : proruct for Model\App\Product

        if( key_exists('id' , $dataArray) && key_exists('instance' , $dataArray) && key_exists('title' , $dataArray) && key_exists('price' , $dataArray) && key_exists('count' , $dataArray) )
        {
            $data = $dataArray;
        }else{
            return false;
        }

        if( $items = $this->all($cacheName) ){
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
        }else{
            $items = array();
            array_push($items , $data);
            $serializedItems = serialize($items);
        }
        
        if( ! empty($items) ){
            cache()->set($cacheName , $serializedItems , $this->timeout);
        }else{
            cache()->forget($cacheName);
        }
 

        return true;        
    }

    public function all($cacheName)
    {
        return unserialize(cache()->get($cacheName));
    }

    public function addCount($cacheName , $id)
    {
        if( $items = $this->all($cacheName) ){
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
            $this->add($cacheName , $basketData['instance'] , $basketData);
        }
    }


    public function decreaseCount($cacheName , $id , $decCount = 1)
    {
        if( $items = $this->all($cacheName) ){
            $newItems   = array();

            foreach( $items as $key => $item )
            {
                if( $id == $item['id'] ){
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