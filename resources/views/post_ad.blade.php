@extends('master')

@section('main')
    <section id="PostAds" class="container">
        <div class="btn-group">
            <a href="#" class="btn green-gradient">post a free ad</a>
            <a href="#" class="btn green-gradient">post a paid ad</a>
        </div>

        <div id="step1">
            <div class="box">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Type of Product</label>
                            <select name="type-of-product" class="form-control">
                                <option value="Flowers">Flowers</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Unit Description</label>
                            <select name="unit-desc" class="form-control">
                                <option value="Ounce">Ounce</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" class="form-control" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="">Header color</label>
                            <select name="header-color" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" class="form-control" name="location">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Type of Strain</label>
                            <input type="text" class="form-control" name="type-of-strain">
                        </div>
                        <div class="form-group">
                            <label for="">Price per Unit in USD</label>
                            <input type="text" class="form-control" name="type-of-strain">
                        </div>
                        <div class="form-group">
                            <label>Price per Quantity in USD</label>
                            <div class="clearfix">
                                <div class="input-box">
                                    <span>Gram</span>
                                    <input type="text" name="ppq-gram">
                                </div>
                                <div class="input-box">
                                    <span>Eighth</span>
                                    <input type="text" name="ppq-eighth">
                                </div>
                                <div class="input-box">
                                    <span>Quarter</span>
                                    <input type="text" name="ppq-quarter">
                                </div>
                                <div class="input-box">
                                    <span>Half</span>
                                    <input type="text" name="ppq-half">
                                </div>
                                <div class="input-box">
                                    <span>Ounce</span>
                                    <input type="text" name="ppq-ounce">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Upload Logo/Product for Thumbnnail</label>
                            <input type="file" name="thumb">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="dropzone">
                <label for="">Upload up to 4 Photos</label>
            </div>
        </div>
        <!-- /#step1 -->

        <div class="row" id="step2">
            <header>
                <div class="col-md-12">
                    <h3 class="title">Welcome to the ad payment page</h3>
                    <hr>
                </div>
            </header>
            <div class="col-md-12">
                <h2>CHOOSE PAYMENT TYPE</h2>
                <div class="row">
                    <div class="col-md-6">
                        <a href=""><img src="img/card.png" alt=""></a>
                        <a href=""><img src="img/paypal.png" alt=""></a>
                    </div>
                    <div class="col-md-6">
                        <a href=""><img src="img/savepay.png" alt=""></a>
                        <a href=""><img src="img/bitcoin.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#step2 -->

        <div class="btn-group">
            <a href="#" class="btn green-gradient">skip</a>
            <a href="post-ad-2.php" class="btn green-gradient">next</a>
        </div>
    </section>
@endsection