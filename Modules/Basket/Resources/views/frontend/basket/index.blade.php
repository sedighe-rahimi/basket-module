@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .card-b {
            margin: auto;
            /* max-width: 950px; */
            width: 100%;
            box-shadow: 0 6px 20px 0 rgb(0 0 0 / 19%);
            border-radius: 1rem;
            border: transparent;
        }
        .num-change{
            text-decoration: none;
        }
    </style>
@endsection

@section('scripts')

@endsection

@section('content')
    <div>
        <!--start of cart page-->
        <div class="card card-b">
            <div class="row">
                <!--poducts-->
                <div class="col-md-8 cart">
                    <div class="title">
                        <div class="row">
                            <div class="col">
                                <h4><b>سبد خرید</b></h4>
                            </div>
                            {{-- <div class="col align-self-center text-right text-muted">3 محصول</div> --}}
                        </div>
                    </div>
                    
                    <div class="row border-top border-bottom">
                        <div class="row main align-items-center text-center">
                            <div class="col-2"></div>
                            <div class="col">
                                <div class="row text-muted">عنوان</div>
                            </div>
                            <div class="col">تعداد</div>
                            <div class="col">قیمت</div>
                            <div class="col">قیمت کل</div>
                        </div>
                    </div>
                    @foreach( $basketItems as $item )
                        <div class="row border-top border-bottom">
                            <div class="row main align-items-center text-center">
                                <div class="col-2"><img class="img-fluid" src="/images/bird.jpg"></div>
                                <div class="col">
                                    <div class="row text-muted">{{ $item['title'] }}</div>
                                </div>
                                <div class="col">
                                    <a class="num-change" href="{{ route('basket.addCount' , ['cacheName' => $cacheName , 'id' => $item['id']] ) }}">+</a>
                                    <a href="#" class="border num-change">{{ $item['count'] }}</a>
                                    <a class="num-change" href="{{ route('basket.decCount' , ['cacheName' => $cacheName , 'id' => $item['id'] , 'decCount' => 1] ) }}">-</a> 
                                </div>
                                <div class="col"> {{ $item['price'] }}  تومان</div>
                                <div class="col"> {{ $item['price'] * $item['count'] }}  تومان
                                    <a class="close pr-4" href="{{ route('basket.decCount' , ['cacheName' => $cacheName , 'id' => $item['id'] , 'decCount' => $item['count']] ) }}">حذف</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="back-to-shop"><a href="{{ url('/') }}">&leftarrow;</a><span class="text-muted">برگشت به فروشگاه</span></div>
                </div>
                <!--Side bar-->
                <div class="col-md-4 summary">
                    <div>
                        <h5><b>خلاصه</b></h5>
                    </div>
                    <hr>
                    <div class="row">
                        {{-- <div class="col" style=" border-bottom: 1px solid rgba(0,0,0,.1); padding: 0 0 2vh 0">
                            <span>3</span>
                            محصول
                        </div> --}}
                        <div class="row" style=" padding: 2vh 0;">
                            <div class="col">قیمت کل</div>
                            <div class="col text-right"> {{ $totalPrice }} تومان</div>
                        </div>
                        {{-- <div class="row" style="padding: 2vh 0;">
                            <div class="col"> درصد تخفیف</div>
                            <div class="col text-right">&euro; 2.00</div>
                        </div> --}}
                    </div>
                    {{-- <form>
                        کد تخفیف
                        <p>GIVE CODE</p> <input id="code" placeholder="Enter your code">
                    </form> --}}

                    {{-- <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                        <div class="col"> قیمت کل</div>
                        <div class="col text-right">&euro; 137.00</div>
                    </div> --}}
                    <button class="btn">پرداخت</button>
                </div>
            </div>
        </div>
        <!-- end of cart page-->
    </div>
@endsection