@extends('master')

@section('main')
    <div class="container" id="Dispensaries">
        <div class="col-md-8 col-sm-8">
            @foreach($products as $product)
                <div class="row block">
                    <div class="col-md-3">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                    </div>
                    <div class="col-md-9">
                        <h4><strong>{{ $product['name'] }}</strong></h4>
                        <h5>from <strong>{{ $product['producer']['name'] }}</strong></h5>
                        <ul>
                            <li><i class="icon-beaker"></i> CBD: {{ $product['cbd'] }}</li>
                            <li><i style="color: red;" class="icon-beaker"></i> THC: {{ $product['thc'] }}</li>
                        </ul>

                        <button class="btn green-gradient add-to-cart" data-id="{{ $product['ucpc'] }}" data-name="{{ $product['name'].' from '.$product['producer']['name'] }}">ADD TO CART</button>
                    </div>
                </div>
            @endforeach

            @if(count($products))
                @if($nextPage - 2 > 0)
                    <a href="{{ url('products') }}?page={{ $nextPage - 2 }}"><button class="btn green-gradient">Previous page</button></a>
                @endif
                <a href="{{ url('products') }}?page={{ $nextPage }}"><button class="btn green-gradient">Next page</button></a>
            @endif
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="cart">
                <div class="header">Your Cart</div>
                <ul class="items nicescroll">
                    @include('partials.product_cart')
                </ul>
                <div class="footer clearfix">
                    @if(auth()->user() && auth()->user()->type == 'seeker')
                        <button class="btn green-gradient" id="cartCheckout">CHECKOUT</button>
                    @else
                        <a href="{{ url('login') }}"><button class="btn green-gradient">LOGIN TO CHECKOUT</button></a>
                    @endif
                    <button class="btn green-gradient clear-cart">CLEAR</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var SITE_URL = '{{ url("/") }}';
    </script>
<script src="{{ asset('js/products.cart.js') }}"></script>
@endsection