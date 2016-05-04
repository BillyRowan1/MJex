@extends('master')
@section('main')
    <section id="AdNetwork" class="container page">
        <div class="panel panel-default">
            <div class="panel-heading">
                Advertising
            </div>
            <div class="panel-body">
                @include('inc.msg')


                <table class="table">
                    <thead>
                    <tr>
                        <th>Position</th>
                        <th>Price</th>
                        <th>Slot</th>
                        <th>Submit banner image</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($bannerPlacements as $bannerPlacement)
                        <tr>
                            {!! Form::open(['method'=>'post','files'=>true,'id'=> 'form'.$bannerPlacement->id]) !!}
                            <td>{!!  $bannerPlacement->title  !!}</td>
                            <td>${{ $bannerPlacement->price }} / month</td>
                            <td>{{ $bannerPlacement->slot }}</td>
                            <td>{!! Form::file('image',['accept' =>"image/*"]) !!}</td>
                            <td>
                                @if(auth()->user() && auth()->user()->type == 'seller')
                                    @if($bannerPlacement->slot > 0)
                                        <input type="hidden" name="placement_id" value="{{ $bannerPlacement->id }}">
                                        <button class="stripeCheckoutBtn btn green-gradient" type="submit" data-price="{{ $bannerPlacement->price }}">Buy</button>
                                    @endif
                                @else
                                    <a href="{{ url('login') }}" class="btn green-gradient">Login as seller to purchase</a>
                                @endif
                            </td>
                            {!! Form::close() !!}
                        </tr>
                        @endforeach

                        <input type="hidden" name="banner_type">
                    </tbody>
                </table>

            </div>
        </div>

    </section>
@endsection

@section('page-js')
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
        var currentFormId = -1;
        var handler = StripeCheckout.configure({
            key: 'pk_test_u4oPjGiJ2fCtkuat5LY1cIjG',
            image: '/img/logo-stripe.png',
            locale: 'auto',
            token: function(token) {
                console.log(token);
                // You can access the token ID with `token.id`
                $('#form'+currentFormId).submit();
            }
        });

        $('.stripeCheckoutBtn').on('click', function(e) {
            currentFormId = $(this).parents('tr').find('[name=placement_id]').val();
            if($(this).parents('tr').find('input[name=image]').val() == '') {
                alert('You must upload a banner image');

                return false;
            }
            e.preventDefault();

            var amount = $(this).data('price');
            amount *= 100;
            var description = '';

            // Open Checkout with further options
            handler.open({
                name: 'Mjex',
                description: description,
                amount: amount,
                {!!  auth()->user()?'email: "'.auth()->user()->email . '"':'' !!}
            });
        });

        // Close Checkout on page navigation
        $(window).on('popstate', function() {
            handler.close();
        });
    </script>
@endsection