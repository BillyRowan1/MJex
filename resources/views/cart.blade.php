@extends('master')

@section('main')
<section id="ShoppingCart" class="container">
	<div class="row">
        @if($seller->header)
            <img class="img-header" src="{{ url($seller->header) }}" alt="header">
        @endif
		<div class="col-md-7">
            @include('inc.msg')
			<div class="welcome">

                <div class="header">Welcome to {{ $seller->community_name }} Store
                </div>

                <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified" role="tablist" id="welcomeTab">
                    <li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab">Information</a></li>
                    <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="information">
                        <ul>
                            <li>Email: <a href="mailto:{{ $seller->community_name }}@mjex.co">{{ $seller->community_name }}@mjex.co</a></li>
                            @if($seller->accepted_payment)
                            <li>PAYMENT METHODS: {{ $seller->accepted_payment }}</li>
                            @endif
                            <li>LOCATION: {{ $seller->state }}, {{ $seller->country }}</li>
                            <li>AREAS SERVED: {{ $seller->zipcode }}</li>
                            
                            @if(has_purpose('grower',$seller))
                            <li>Available Patient Slots: {{ $seller->patients_available }}</li>
                                @if(auth()->user() && auth()->user()->type == 'seeker')
                                    <form style="display: inline-block;" action="{{ route('cart.select.as.grower') }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="seeker_id" value="{{ auth()->user()->id }}">
                                        <input type="hidden" name="grower_id" value="{{ $seller->id }}">
                                        <button type="submit" class="btn green-gradient"><i class="icon-star"></i> Select as your Grower</button>
                                    </form>

                                    @endif
                            @endif
                            <button id="btnChatNow" class="btn green-gradient"><i class="icon-comment"></i> Chat now</button>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="reviews">
                        <ul style="height: 170px; overflow: auto;">
                            @foreach($seller->reviews as $review)
                            <li>
                                <strong>REVIEW DATE: {{ $review->created_at }}</strong>
                                <p>{{ $review->content }}</p>
                                <span class="reviewer">- <i>{{ $review->reviewer }}</i></span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <ul class="content">
                            @if(!is_null($chats) && auth()->user())
                                @foreach($chats as $chat)
                                    @if(auth()->user()->id==$chat->sender_id)
                                        <li class="you">
                                            {!! $chat->message !!}
                                        </li>
                                    @else
                                        <li>
                                            {!! $chat->message !!}
                                        </li>
                                    @endif
                                
                                @endforeach
                            @endif
                        </ul>
                        <li class="last">
                            @if(!auth()->user() || (auth()->user() && $seller->id != auth()->user()->id))
                                <input type="text" name="message" placeholder="Enter message">
                                @if(auth()->user())
                                    <button id="sendChatBtn">SEND</button>
                                @else
                                    <button id="sendChatBtn">LOGIN TO CHAT</button>
                                @endif
                            @endif
                        </li>
                    </div>
                </div>
            </div>

			</div>
		</div>
		<div class="col-md-5">
			<div class="cart">
				<div class="header">Your Cart</div>
				<ul class="items nicescroll">
                    @include('inc.carts')
				</ul>
				<div class="footer clearfix">
					@if(auth()->user() && auth()->user()->type == 'seeker')
                    <button class="btn green-gradient" id="cartCheckout">CHECKOUT</button>
                    @else
                        <a href="{{ url('login') }}"><button class="btn green-gradient">LOGIN AS SEEKER TO CHECKOUT</button></a>
                    @endif
					<button class="btn green-gradient clear-cart">CLEAR</button>
					<p>Subtotal: <span class="subtotal">${{ Cart::total() }}</span></p>
				</div>
			</div>
		</div>
	</div>

	
	<ul class="ads">
        @foreach($ads as $ad)
		<li class="row">
			<div class="col-md-12">
                <div class="row">
                    @if(!empty($ad->thumb))
                    <div class="col-md-2">
                        <img src="{{ url($ad->thumb) }}" width="100px" style="margin-bottom: 10px;">
                    </div>
                    @endif
                    <div class="col-md-10">
                        <ul>
                            <li><strong>Type of product: </strong>{{ $ad->type_of_product }}</li>
                            <li><strong>Description: </strong>{{ $ad->description }}</li>
                            <li><strong>Price: </strong>${{ $ad->price_per_unit }}</li>
                            <li>{!! $ad->content !!}</li>
                        </ul>
                        <button class="btn green-gradient add-to-cart"
                            data-product="{{ $ad->type_of_product }}"
                            data-ad_id="{{ $ad->id }}"
                            data-strain="{{ $ad->description }}"
                            data-price_per_unit="{{ $ad->price_per_unit }}"
                            data-price_per_quantity="{{ $ad->price_per_quantity }}">ADD TO CART</button>
                    </div>
                </div>
                <?php $gallery = !empty($ad->gallery)?json_decode($ad->gallery):[]; ?>

                <div style="margin-bottom: 15px;"></div>
            </div>

            <ul class="gallery">
                @foreach($gallery as $image)
                    <li style="background-image: url('{{ asset($image) }}')"></li>
                @endforeach
            </ul>
		</li>
        @endforeach
	</ul>
</section>
@endsection

@section('page-js')
<script>
    jQuery(document).ready(function($) {
        // Go to specific welcome tab
        var tabId = location.hash;
        if(tabId) $('a[href='+tabId+']').tab('show');

        // Chat now
        $('#btnChatNow').click(function(){
            $('a[href="#messages"]').tab('show');
        });

        // Chat functions
        var Chat = (function () {
            $('#sendChatBtn').click(function(event) {
                var message = $('#messages input').val();
                if(message != '') {
                    Mjex.showLoading(true);
                    $.ajax({
                        url: '{{ route("chat.store") }}',
                        type: 'POST',
                        data: {
                            message: message,
                            seller_id: {{ $seller->id }}
                        }
                    })
                    .done(function(res) {
                        console.log(res);
                        if(res.status == 'ok') {
                            addMessage(message);
                            $('#messages input').val('');
                        }
                    })
                    .always(function() {
                        Mjex.showLoading(false);
                    });
                        
                }else{
                    alert('Please enter message');
                }
            });

            function addMessage(message) {
                var item = '<li class="you">'+message+'</li>';
                $('#messages .content').prepend(item);
            }
        })();

        var Cart = (function () {
            function clear() {
                Mjex.showLoading(true);
                $.ajax({
                    url: '{{ route("cart.clear") }}',
                    type: 'POST',
                })
                .done(function() {
                    $('.cart .items li').remove();
                    updateSubtotal();
                })
                .fail(function() {
                    alert('Can not clear cart');
                })
                .always(function() {
                    Mjex.showLoading(false);
                });
            }
            function add(product, strain, price, qty, ad_id) {
                Mjex.showLoading(true);
                $.ajax({
                    url: '{{ route("cart.add") }}',
                    type: 'POST',
                    data: {
                        product: product,
                        strain: strain,
                        price: price,
                        qty: qty,
                        id: ad_id
                    },
                })
                .done(function(res) {
                    $('.cart .items').html(res);
                    updateSubtotal();
                })
                .fail(function() {
                    alert('Can not add to cart');
                })
                .always(function() {
                    Mjex.showLoading(false);
                });
            }

            function updateSubtotal() {
                var subtotal = 0;
                $('.cart .items .price').each(function(index, el) {
                    var quantity = $(this).parent().find('.quantity').val();
                    if(isNaN(quantity)) {
                        alert("Wrong number format");
                        return;
                    }
                    var price = $(this).text().split('$')[1];
                    price = parseInt(price);
                    subtotal += price * quantity;
                });
                $('.cart .subtotal').text('$' + subtotal);
            }

            function updateCartQty(rowId, qty) {
                Mjex.showLoading(true);
                $.ajax({
                    url: '{{ route("cart.update.qty") }}',
                    type: 'POST',
                    data: {
                        rowId: rowId,
                        qty: qty
                    }
                })
                .done(function(res) {
                    $('.cart .items').html(res);
                })
                .fail(function() {
                    alert('Can not update cart');
                })
                .always(function() {
                     Mjex.showLoading(false);
                });
            }

            function removeItem(rowId) {
                Mjex.showLoading(true);
                $.ajax({
                    url: '{{ route("cart.delete") }}',
                    type: 'POST',
                    data: {
                        rowId: rowId,
                    }
                })
                .done(function(res) {
                    $('.cart .items').html(res);
                })
                .fail(function() {
                    alert('Can not update cart');
                })
                .always(function() {
                     Mjex.showLoading(false);
                });
            }

            $('#cartCheckout').click(function(event) {
                if ($('li[data-rowid]').length == 0) {
                    alert('Can not checkout. Your cart is empty');
                    return false;
                }

                Mjex.showLoading(true);
                $.ajax({
                    url: '{{ route("cart.send.order") }}',
                    type: 'POST',
                    data: {
                        seller_id: {{ $seller->id }}
                    }
                })
                .done(function() {
                    alert('Your order has been sent');
                    clear();
                })
                .fail(function() {
                    alert('Can not send order');
                })
                .always(function() {
                    Mjex.showLoading(false);
                });
            });

            // When quantity changed
            $('body').delegate('.quantity', 'change', function(event) {
                var rowId = $(this).parents('li').data('rowid'),
                    qty = $(this).val();
                updateCartQty(rowId, qty);
                updateSubtotal();
            });

            $('.clear-cart').click(function(event) {
                clear();
            });

            $('body').delegate('.cart .delete', 'click', function(event) {
                event.preventDefault();
                var rowId = $(this).parents('li').data('rowid');
                removeItem(rowId);
                $(this).parent().remove();
            });

            $('.add-to-cart.btn').click(function(event) {
                var product = $(this).data('product'),
                    strain = $(this).data('strain'),
                    ad_id = $(this).data('ad_id'),
                    price_per_unit = $(this).data('price_per_unit'),
                    price_per_quantity = $(this).data('price_per_quantity'),
                    price = 0,
                    qty = 1;

                if(price_per_unit) {
                    price = price_per_unit;
                }else{
                    for(var i in price_per_quantity){
                        var obj = price_per_quantity[i];
                        for(var j in obj){
                            if(obj[j]!='') {
                                price += parseInt(obj[j]);
                            }
                        }
                    }
                }
                add(product, strain, price, qty, ad_id);
            });
        })();

        $('.welcome .tab').not('#tab-general').hide();
    });
</script>
@endsection