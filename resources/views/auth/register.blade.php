@extends('master')

@section('main')
    <section id="Signup" class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="img/signup-banner.png" alt="banner" class="banner">
                @include('inc.msg')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="block seeker">
                    <h3 class="title">SIGN UP AS SEEKER</h3>
                    <form action="{{ url('register') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_type" value="seeker">
                        <div class="form-group">
                            <label for="">Select a MJex username*</label>
                            <input type="text" name="community_name" value="{{ old('_type')=='seeker'?old('community_name'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Enter Email*</label>
                            <input type="email" name="email" value="{{ old('_type')=='seeker'?old('email'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Enter Password*</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">City / State</label>
                            <input type="text" name="state" value="{{ old('_type')=='seeker'?old('state'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Country</label>
                            @include('inc.country_select')
                        </div>
                        <div class="form-group">
                            <label for="">Zipcode*</label>
                            <input type="text" name="zipcode" value="{{ old('_type')=='seeker'?old('zipcode'):'' }}" class="form-control">
                        </div>
                        <label for="">Select as many as apply</label>
                        <div class="form-group checkbox-group circle-checkboxes clearfix">
                            <input type="checkbox" id="for-adult" value="adult_use" name="purpose[]">
                            <label for="for-adult">Adult use +21</label>

                            <input type="checkbox" id="for-medical" value="medical" name="purpose[]">
                            <label for="for-medical">Medical</label>
                        </div>
                        <div class="form-group" ng-show="medical">
                            <label for="">Medical card number</label>
                            <input type="text" name="medical_card_number" class="form-control">
                            <br>
                            <label for="">Disired alotment</label>
                            <input type="text" name="desired_alotment" class="form-control">
                        </div>
                        <button type="submit" class="btn green-gradient">SIGN UP</button>
                        <br>
                        <span style="text-align: center; display: block;">Already have account?</span>
                        <a href="{{ url('login') }}" class="btn btn-default">SIGN IN</a>

                        <br>
                        <span style="text-align: center; display: block;">Lost your password? <a href="{{ url('password/email') }}">Reset</a></span>

                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block business">
                    <h3 class="title">SIGN UP AS A BUSINESS</h3>
                    <form id="seller-signup" action="{{ url('register') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_type" value="seller">
                        <div class="form-group">
                            <label for="">Select a MJex username*</label>
                            <input type="text" name="community_name" value="{{ old('_type')=='seller'?old('community_name'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Email*</label>
                            <input type="email" name="email" value="{{ old('_type')=='seller'?old('email'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password*</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Zipcode* (can add more than one, separate by commas)</label>
                            <input type="text" name="zipcode" value="{{ old('_type')=='seller'?old('zipcode'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">City / State</label>
                            <input type="text" name="state" value="{{ old('_type')=='seller'?old('state'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Delivery</label>
                            <select name="delivery" class="form-control">
                                <option value="">-Select-</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <label for="">Select as many as apply</label>
                        <div class="form-group checkbox-group circle-checkboxes clearfix">
                            <input type="checkbox" id="bsn-for-adult" value="adult_use" name="purpose[]">
                            <label for="bsn-for-adult">Adult use +21</label>

                            <input type="checkbox" id="bsn-for-medical" value="medical" name="purpose[]">
                            <label for="bsn-for-medical">Medical</label>

                            {{--<input type="checkbox" id="bsn-for-grower" value="grower" name="purpose[]">--}}
                            {{--<label for="bsn-for-grower">Grower</label>--}}

                            <input type="checkbox" id="bsn-for-other" value="other" name="purpose[]">
                            <label for="bsn-for-other">Other business</label>
                        </div>
                        <div id="growerPatientsAvailable">
                            <div class="form-group">
                                <label for="">Number of patients available</label>
                                <select name="patients_available" class="form-control">
                                    <option value="">-Select-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Are you Grower?</label>
                                <select name="purpose[]" class="form-control">
                                    <option value="">No</option>
                                    <option value="grower">Yes</option>
                                </select>
                            </div>
                        </div>
                        <label for="">Choose ad package</label>
                        <div class="form-group checkbox-group circle-checkboxes clearfix ad-package">
                            <input type="radio" id="package-1" {{ (!empty($package)&&$package=='free')?'checked':'' }} value="free" name="package">
                            <label for="package-1">Free</label>

                            <input type="radio" id="package-2" {{ (!empty($package)&&$package=='weekly')?'checked':'' }} value="weekly" name="package">
                            <label for="package-2">$5.00 per ad per week</label>

                            <input type="radio" id="package-3" {{ (!empty($package)&&$package=='weekly_pro')?'checked':'' }} value="weekly_pro" name="package">
                            <label for="package-3">$10.00 per ad per week</label>
                            <input type="hidden" name="stripeToken">
                        </div>
                        <script src="https://checkout.stripe.com/checkout.js"></script>
                        <button id="stripeCheckoutBtn" class="btn green-gradient">CONTINUE TO PAYMENTS</button>

                        <br>
                        <span style="text-align: center; display: block;">Already have account?</span>
                        <a href="{{ url('login') }}" class="btn btn-default">SIGN IN</a>

                        <br>
                        <span style="text-align: center; display: block;">Lost your password? <a href="{{ url('password/email') }}">Reset</a></span>
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
    // Display "Number of patients available" field when sign up as Seller and have 'grower' purpose
    $('#growerPatientsAvailable').hide();
    $('.business [name="purpose[]"]').click(function(event) {
        var isGrower = false;
        $('.business [name="purpose[]"]').each(function(event) {
            if ($(this).is(':checked') && $(this).val() == 'medical') {
                isGrower = true;
            }
        });

        if(isGrower) {
            $('#growerPatientsAvailable').show();
        }else{
            $('#growerPatientsAvailable').hide();
        }
    });

    $('[ng-show=medical]').hide();
    $('.seeker [name="purpose[]"]').click(function(event) {
        var isMedical = false;
        $('.seeker [name="purpose[]"]').each(function(event) {
            if ($(this).is(':checked') && $(this).val() == 'medical') {
                isMedical = true;
            }
        });

        if(isMedical) {
            $('[ng-show=medical]').show();
        }else{
            $('[ng-show=medical]').hide();
        }
    });

    // CLick checkout
    $('#stripeCheckoutBtn').on('click', function(e) {
        var package = $('[name=package]:checked').val();
        if(package != 'free') {
            e.preventDefault();

            var amount = 0;
            var description = '';
            switch (package) {
                case 'free':
                    amount = 0;
                    description = 'Free';
                    break;
                case 'weekly':
                    description = 'Weekly ($5.00)';
                    amount = 500;
                    break;
                case 'weekly_pro':
                    description = 'Weekly pro ($10.00)';
                    amount = 1000;
                    break;
            }
            // Open Checkout with further options
            handler.open({
                name: 'Mjex',
                description: description,
                amount: amount,
                email: $('#seller-signup [name=email]').val()
            });
        }
    });

    // Close Checkout on page navigation
    $(window).on('popstate', function() {
        handler.close();
    });
});

</script>
@endsection