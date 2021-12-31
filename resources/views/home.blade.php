@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
        <div class="container">
            @if(unserialize(cache()->get('products')))
                <a class="navbar-brand" href="{{ route('basket.index' , ['cacheName' => 'products']) }}">
                    سبد خرید
                    <span class="badge badge-pill btn-info p-1">{{ $basketItemsCount }}</span>
                </a>
            @else
                <span class="navbar-brand">
                    سبد خرید
                    <span class="badge badge-pill btn-info p-1">{{ $basketItemsCount }}</span>
                </span>
            @endif
        </div>
    </nav>
    <div class="row">
        @if($products->count())
            @foreach( $products as $product )
                <div class="card col-4">
                    <img class="card-img-top" src="/images/bird.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="text-muted"><small class="">{{ substr($product->description ,0 , 200) }} ...</small></p>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-info" href="{{ route('add.to.basket' , $product->id) }}">افزودن به سبد</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card col-4 p-4 text-center h3">
                لطفا به جدول products محصولاتی اضافه کنید.
            </div>
        @endif
    </div>
@endsection