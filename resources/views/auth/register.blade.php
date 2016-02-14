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
                            <label for="">Email*</label>
                            <input type="email" name="email" value="{{ old('_type')=='seeker'?old('email'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password*</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Your Community Name*</label>
                            <input type="text" name="community_name" value="{{ old('_type')=='seeker'?old('community_name'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Zipcode*</label>
                            <input type="text" name="zipcode" value="{{ old('_type')=='seeker'?old('zipcode'):'' }}" class="form-control">
                        </div>
                        <label for="">Select as many as apply</label>
                        <div class="form-group checkbox-group circle-checkboxes clearfix">
                            <input type="checkbox" id="for-medical" value="medical" name="purpose[]">
                            <label for="for-medical">Medical</label>

                            <input type="checkbox" id="for-grower" value="grower" name="purpose[]">
                            <label for="for-grower">Grower</label>

                            <input type="checkbox" id="for-doctor" value="doctor" name="purpose[]">
                            <label for="for-doctor">Doctor</label>

                            <input type="checkbox" id="for-adult" value="adult_use" name="purpose[]">
                            <label for="for-adult">Adult use</label>
                        </div>
                        <button type="submit" class="btn green-gradient">SIGN UP</button>
                        <br>
                        <span style="text-align: center; display: block;">Already have account?</span>
                        <a href="{{ url('login') }}" class="btn btn-default">SIGN IN</a>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block business">
                    <h3 class="title">SIGN UP AS A BUSINESS</h3>
                    <form action="{{ url('register') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_type" value="seller">
                        <div class="form-group">
                            <label for="">Email*</label>
                            <input type="email" name="email" value="{{ old('_type')=='seller'?old('email'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password*</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Your Community Name*</label>
                            <input type="text" name="community_name" value="{{ old('_type')=='seller'?old('community_name'):'' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Zipcode*</label>
                            <input type="text" name="zipcode" value="{{ old('_type')=='seller'?old('zipcode'):'' }}" class="form-control">
                            <div class="form-group">
                            </div>
                            <label for="">Delivery</label>
                            <select name="delivery" class="form-control">
                                <option value="">-Select-</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <label for="">Select as many as apply</label>
                        <div class="form-group checkbox-group circle-checkboxes clearfix">
                            <input type="checkbox" id="bsn-for-grower" value="grower" name="purpose[]">
                            <label for="bsn-for-grower">Grower</label>

                            <input type="checkbox" id="bsn-for-doctor" value="doctor" name="purpose[]">
                            <label for="bsn-for-doctor">Doctor</label>

                            <input type="checkbox" id="bsn-for-dispensary" value="dispensary" name="purpose[]">
                            <label for="bsn-for-dispensary">Dispensary</label>

                            <input type="checkbox" id="bsn-for-wholesaler" value="wholesaler" name="purpose[]">
                            <label for="bsn-for-wholesaler">Wholesaler</label>

                            <input type="checkbox" id="bsn-for-lab" value="lab" name="purpose[]">
                            <label for="bsn-for-lab">Lab</label>

                            <input type="checkbox" id="for-manufacturer" value="manufacturer" name="purpose[]">
                            <label for="for-manufacturer">Manufacturer</label>
                        </div>
                        <label for="">Choose ad package</label>
                        <div class="form-group checkbox-group circle-checkboxes clearfix">
                            <input type="checkbox" id="package-1" {{ (!empty($package)&&$package=='free')?'checked':'' }} value="free" name="package">
                            <label for="package-1">Free</label>

                            <input type="checkbox" id="package-2" {{ (!empty($package)&&$package=='monthly')?'checked':'' }} value="monthly" name="package">
                            <label for="package-2">$5.00 per month</label>

                            <input type="checkbox" id="package-3" {{ (!empty($package)&&$package=='monthly_pro')?'checked':'' }} value="monthly_pro" name="package">
                            <label for="package-3">$10.00 per month</label>
                        </div>
                        <button type="submit" class="btn green-gradient">CONTINUE TO PAYMENTS</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection