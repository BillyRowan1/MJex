@extends('master')

@section('main')
<section id="ShoppingCart" class="container">
	<div class="row">
		<div class="col-md-7">
            @include('inc.msg')
			<div class="welcome">
				<div class="header">Welcome to {{ $seller->community_name }} Store
                    <a tab-target="#tab-reviews" href="#">Reviews</a>
                    <a tab-target="#tab-general" href="#" style="display: none;">Go back</a>
                </div>
                <div class="tab" id="tab-general">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>PAYMENT METHODS:</h4>
                                <p>{{ $seller->accepted_payment }}</p>
                                <h4>LOCATION: {{ $seller->state }}, {{ $seller->country }}</h4>
                                <h4>AREAS SERVED: {{ $seller->zipcode }}</h4>

                            </div>
                            @if(in_array('grower', $seller->purpose))
                            <div class="col-md-6">
                                {!! Form::open(['route'=>'cart.send.to.grower','method'=>'post','id'=>'emailThisGrowerForm']) !!}
                                <input type="hidden" name="grower_email" value="{{ $seller->email }}">
                                <textarea name="msg" class="form-control" cols="30" rows="5" placeholder="Enter your message"></textarea>
                                <br>
                                <button type="submit" class="btn green-gradient">SEND</button>
                                <button type="button" class="btn close-form">CLOSE</button>
                                {!! Form::close() !!}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="footer ">
                        @if(auth()->user() && auth()->user()->type == 'seeker')
                            <button id="openChatBtn" class="btn">Open chat window</button>

                            @if(in_array('grower', $seller->purpose))
                                <button id="emailThisGrowerBtn" class="btn">Email This Grower</button>
                            @endif
                                
                            @else
                            <button class="btn">You must login as Seeker to chat</button>
                        @endif
                    </div>
                </div>
                <div class="tab" id="tab-reviews">
                    <ul class="content" style="height: 200px; overflow: auto;">
                        @foreach($seller->reviews as $review)
                        <li>
                            <strong>REVIEW DATE: {{ $review->created_at }}</strong>
                            <p>{{ $review->content }}</p>
                            <span class="reviewer">- <i>{{ $review->reviewer }}</i></span>
                        </li>
                        @endforeach
                    </ul>

                    <form class="footer" style="padding: 10px;" id="reviewForm" method="post" action="{{ route('review.store') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <input type="text" class="form-control" name="content" placeholder="Your review">
                        </div>
                        <input type="text" class="form-control" value="{{ auth()->user()->type=='seeker'?auth()->user()->community_name:'' }}" placeholder="Your name" name="reviewer">
                        <input type="hidden" name="seller_id" value="{{ $seller->id }}" >
                        <input type="submit" style="margin-left: 0;" class="btn btn-default" value="Send">
                    </form>
                </div>
                <div class="tab" id="tab-chat">
                    <ul class="content" style="height: 200px; overflow: auto;">
                        @if(!is_null($chats) && auth()->user())
                            @foreach($chats as $chat)
                            <li class="{{ auth()->user()->id==$chat->sender_id?'you':'' }}">
                                <strong>{{ auth()->user()->id==$chat->sender_id?'YOU':'' }}</strong><br>
                                {{ $chat->message }}
                            </li>
                            @endforeach
                        @endif
                    </ul>
                    <li class="last">
                        <input type="text" name="message" placeholder="Enter message">
                    </li>
                    <div class="footer">
                        <button id="sendChatBtn" class="btn green-gradient">SEND CHAT</button>
                        <button id="closeChatBtn" class="btn">CLOSE CHAT WINDOW</button>
                    </div>
                </div>
			</div>
		</div>
		<div class="col-md-5">
            @if(auth()->user()->type == 'seeker')
			<div class="cart">
				<div class="header">Your Cart</div>
				<ul class="items nicescroll">
                    @include('inc.carts')
				</ul>
				<div class="footer clearfix">
					<button class="btn green-gradient" id="cartCheckout">CHECKOUT</button>
					<button class="btn green-gradient clear-cart">CLEAR</button>
					<p>Subtotal: <span class="subtotal">${{ Cart::total() }}</span></p>
				</div>
			</div>
            @endif
		</div>
	</div>

	
	<ul class="ads">
        @foreach($ads as $ad)
		<li class="row">
			{{--<div class="col-md-4 quantity">--}}
				{{--<h4>SELECT QUANTITY</h4>--}}
			{{--</div>--}}
			<div class="col-md-12">
                <ul>
                    <li><strong>Type of product: </strong>{{ $ad->type_of_product }}</li>
                    <li><strong>Type or strain: </strong>{{ $ad->type_of_strain }}</li>
                    <li>{!! $ad->content !!}</li>
                </ul>
                <?php $gallery = !empty($ad->gallery)?json_decode($ad->gallery):[]; ?>

                @if(auth()->user()->type == 'seeker')
                <button class="btn green-gradient add-to-cart"
                        data-product="{{ $ad->type_of_product }}"
                        data-ad_id="{{ $ad->id }}"
                        data-strain="{{ $ad->type_of_strain }}"
                        data-price_per_unit="{{ $ad->price_per_unit }}"
                        data-price_per_quantity="{{ $ad->price_per_quantity }}"
                        >ADD TO CART</button>
                @endif

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
        // Email grower
        $('#emailThisGrowerForm').hide();
        $('#emailThisGrowerBtn').click(function(){
            $('#emailThisGrowerForm').show();
        });
        $('#emailThisGrowerForm .close-form').click(function(){
            $('#emailThisGrowerForm').hide();
        });
        //////
        var Chat = (function () {
            $('#sendChatBtn').click(function(event) {
                var message = $('#tab-chat [name=message]').val();
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
                            $('#tab-chat [name=message]').val('');
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
                var item = '<li class="you"><strong>YOU</strong><br>'+message+'</li>';
                $('#tab-chat .content').prepend(item);
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

        $('[tab-target]').click(function(event) {
            $(this).hide();
            $(this).siblings('[tab-target]').show();
            var target = $(this).attr('tab-target');
            showTab(target);
        });

        $('#openChatBtn').click(function(event) {
            showTab('#tab-chat');
        });

        $('#closeChatBtn').click(function(event) {
            showTab('#tab-general');
        });

        function showTab(id) {
            $('.welcome .tab').hide();
            $(id).show();
        }
    });
</script>
@endsection