@extends('master')

@section('main')
    <section id="Signup" class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @include('inc.msg')

                <div class="block business">
                    <h3 class="title text-center"><span class="glyphicon glyphicon-fire"></span> UPGRADE YOUR ACCOUNT</h3>
                    <form id="seller-signup" action="{{ url('account/upgrade') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <label class="text-center">Choose ad package</label>
                        <div class="form-group checkbox-group circle-checkboxes clearfix">
                            @if(auth()->user()->package == 'free')
                            <input type="radio" id="package-2" value="monthly" name="package">
                            <label for="package-2">$5.00 per month</label>
                            @endif

                            @if(auth()->user()->package == 'free' || auth()->user()->package == 'monthly')
                            <input type="radio" id="package-3" value="monthly_pro" name="package">
                            <label for="package-3">$10.00 per month</label>
                            @endif
                            <input type="hidden" name="stripeToken">
                        </div>
                        <script src="https://checkout.stripe.com/checkout.js"></script>
                        <button id="stripeCheckoutBtn" class="btn green-gradient">CONTINUE TO PAYMENTS</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
<script>
  var handler = StripeCheckout.configure({
    key: 'pk_test_u4oPjGiJ2fCtkuat5LY1cIjG',
    image: '/img/logo-stripe.png',
    locale: 'auto',
    token: function(token) {
        console.log(token);
        // You can access the token ID with `token.id`
        $('[name=stripeToken]').val(token.id);
        $('#seller-signup').submit();
    }
});

jQuery(document).ready(function($) {
    $('#stripeCheckoutBtn').on('click', function(e) {
        if($('[name=package]').is(':checked') == false) return false;

        var package = $('[name=package]:checked').val();
        e.preventDefault();

        var amount = 0;
        var description = '';
        switch (package) {
            case 'monthly':
                description = 'Monthly ($5.00)';
                amount = 500;
                break;
            case 'monthly_pro':
                description = 'Monthly ($10.00)';
                amount = 1000;
                break;
        }
        // Open Checkout with further options
        handler.open({
            name: 'Mjex',
            description: description,
            amount: amount,
            email: "{{ auth()->user()->email }}"
        });
    });

    // Close Checkout on page navigation
    $(window).on('popstate', function() {
        handler.close();
    });
});

</script>
@endsection