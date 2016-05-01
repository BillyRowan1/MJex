@extends('master')
@section('main')
    <section id="AdNetwork" class="container page">
        <div class="panel panel-default">
            <div class="panel-heading">
                Advertising
            </div>
            <div class="panel-body">
                @include('inc.msg')
                {!! Form::open(['method'=>'post','files'=>true]) !!}

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
                        @foreach($bannerTypes as $type)
                        <tr>
                            <td>{!!  $type->title  !!}</td>
                            <td>{{ $type->price_title }}</td>
                            <td>{{ $type->slot }}</td>
                            <td>{!! Form::file('image[]') !!}</td>
                            <td>
                                @if(auth()->user() && auth()->user()->type == 'seller')
                                    <button class="stripeCheckoutBtn btn green-gradient" type="button" data-type="{{ $type->placement }}">Buy</button>
                                    <input type="hidden" name="banner_type" value="home_header">
                                @else
                                    <a href="{{ url('login') }}" class="btn green-gradient">Login as seller to purchase</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        <input type="hidden" name="banner_type">
                    </tbody>
                </table>
                {!! Form::close() !!}
            </div>
        </div>

    </section>
@endsection

@section('page-js')
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
        var handler = StripeCheckout.configure({
            key: 'pk_test_u4oPjGiJ2fCtkuat5LY1cIjG',
            image: '/img/logo-stripe.png',
            locale: 'auto',
            token: function(token) {
                console.log(token);
                // You can access the token ID with `token.id`
                $('form').submit();
            }
        });

        $('.stripeCheckoutBtn').on('click', function(e) {
            e.preventDefault();
            var bannerType = $(this).data('type');
            $('[name=banner_type]').val(bannerType); //set ad type to hidden input

            var amount = 3000;
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