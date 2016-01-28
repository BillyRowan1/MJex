@extends('master')

@section('main')
    <section id="Signup" class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="img/signup-banner.png" alt="banner" class="banner">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="block seeker">
                    <h3 class="title">SIGN UP AS SEEKER</h3>
                    <div class="form-group">
                        <label for="">Email*</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Password*</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Your Community Name*</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Zipcode*</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <label for="">Select as many as apply</label>
                    <div class="form-group checkbox-group circle-checkboxes clearfix">
                        <input type="checkbox" id="for-medical" name="use-for[]">
                        <label for="for-medical">Medical</label>

                        <input type="checkbox" id="for-grower" name="use-for[]">
                        <label for="for-grower">Grower</label>

                        <input type="checkbox" id="for-doctor" name="use-for[]">
                        <label for="for-doctor">Doctor</label>

                        <input type="checkbox" id="for-adult" name="use-for[]">
                        <label for="for-adult">Adult use</label>
                    </div>
                    <button type="submit" class="btn green-gradient">SIGN UP</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block business">
                    <h3 class="title">SIGN UP AS A BUSINESS</h3>
                    <div class="form-group">
                        <label for="">Email*</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Password*</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Your Community Name*</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Zipcode*</label>
                        <input type="text" name="name" class="form-control">
                        <div class="form-group">
                        </div>
                        <label for="">Delivery</label>
                        <select name="delivery" class="form-control">
                            <option value="">-Select-</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <label for="">Select as many as apply</label>
                    <div class="form-group checkbox-group circle-checkboxes clearfix">
                        <input type="checkbox" id="bsn-for-grower" name="use-for[]">
                        <label for="bsn-for-grower">Grower</label>

                        <input type="checkbox" id="bsn-for-doctor" name="use-for[]">
                        <label for="bsn-for-doctor">Doctor</label>

                        <input type="checkbox" id="bsn-for-dispensary" name="use-for[]">
                        <label for="bsn-for-dispensary">Dispensary</label>

                        <input type="checkbox" id="bsn-for-wholesaler" name="use-for[]">
                        <label for="bsn-for-wholesaler">Wholesaler</label>

                        <input type="checkbox" id="bsn-for-lab" name="use-for[]">
                        <label for="bsn-for-lab">Lab</label>

                        <input type="checkbox" id="for-manufacturer" name="use-for[]">
                        <label for="for-manufacturer">Manufacturer</label>
                    </div>
                    <label for="">Choose ad package</label>
                    <div class="form-group checkbox-group circle-checkboxes clearfix">
                        <input type="checkbox" id="ad-package-1" {{ $package=='free'?'checked':'' }} value="free" name="ad-package[]">
                        <label for="ad-package-1">Free</label>

                        <input type="checkbox" id="ad-package-2" {{ $package=='monthly'?'checked':'' }} value="monthly" name="ad-package[]">
                        <label for="ad-package-2">$5.00 per month</label>

                        <input type="checkbox" id="ad-package-3" {{ $package=='monthly_pro'?'checked':'' }} value="monthly_pro" name="ad-package[]">
                        <label for="ad-package-3">$10.00 per month</label>
                    </div>
                    <button type="submit" class="btn green-gradient">CONTINUE TO PAYMENTS</button>
                </div>
            </div>
        </div>
    </section>
@endsection