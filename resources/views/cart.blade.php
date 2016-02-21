@extends('master')

@section('main')
<section id="ShoppingCart" class="container">
	<div class="row">
		<div class="col-md-7">
			<div class="welcome">
				<div class="header">Welcome to {{ $seller->community_name }} Store
                    <a href="#">Reviews</a></div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>PAYMENT METHODS</h4>
                            <p>{{ $seller->payment }}</p>
                            <h4>LOCATION</h4>

                        </div>
                        <div class="col-md-6">
                            <h4>SELECT AS YOUR  GROWER</h4>
                            <p>Click the green button below to
                                a email this grower</p>
                            <button class="btn green-gradient">SELECT AS MY GROWER</button>
                        </div>
                    </div>
                </div>
                <div class="footer ">
                    <button class="btn">Open chat window</button>
                    <button class="btn">Send an email</button>
                </div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="cart">
				<div class="header">Your Cart</div>
				<ul class="items">
					<li>
						<input type="text" name="item[][quality]" value="2">
						<span class="name">Dark star</span>
						<span class="price">$30</span>
					</li>
					<li>
						<input type="text" name="item[][quality]" value="2">
						<span class="name">Dark star</span>
						<span class="price">$30</span>
					</li>
				</ul>
				<div class="footer clearfix">
					<button class="btn green-gradient">CHECKOUT</button>
					<p>Subtotal: <span class="subtotal">$202</span></p>
				</div>
			</div>
		</div>
	</div>

	
	<ul class="ads">
        @foreach($ads as $ad)
		<li class="row">
			<div class="col-md-4 quantity">
				<h4>SELECT QUANTITY</h4>
			</div>
			<div class="col-md-8">
                <ul>
                    <li><strong>Type of product: </strong>{{ $ad->type_of_product }}</li>
                    <li><strong>Type or strain: </strong>{{ $ad->type_of_strain }}</li>
                    <li>{!! $ad->content !!}</li>
                </ul>

                <?php $gallery = !empty($ad->gallery)?json_decode($ad->gallery):[]; ?>
                <ul class="gallery">
                    @foreach($gallery as $image)
                        <li style="background-image: url('{{ $image }}')"></li>
                    @endforeach
                </ul>

                <button class="btn green-gradient">CLEAR</button>
                <button class="btn green-gradient">ADD TO CART</button>
            </div>
		</li>
        @endforeach
	</ul>
</section>
@endsection