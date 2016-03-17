@extends('master')

@section('main')
    <section id="PostAds" class="container">
        <div class="btn-group mjex">
            <a href="{{ route('ad.create.free') }}" class="btn green-gradient">post a free ad</a>
            <a href="{{ route('ad.create.paid') }}" class="btn green-gradient">post a paid ad</a>
        </div>
        <h2 class="text-center">Free ad ({{ $adsLeft }} ads left)</h2>
        @include('inc.msg')
        @if(isset($adsLeft) && $adsLeft > 0)
            <form action="{{ route('ad.store.free') }}" method="post" enctype="multipart/form-data">
                <div id="step1">
                        {!! csrf_field() !!}
                    <input type="hidden" name="ad_type" value="free">
                        <div class="box">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Type of Product</label>
                                        <select name="type_of_product" class="form-control">
                                            <option value="Flowers">Flowers</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Unit Description</label>
                                        <select name="unit_desc" class="form-control">
                                            <option value="Ounce">Ounce</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Amount</label>
                                        <input type="text" class="form-control" name="amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Header color</label>
                                        <select name="header_color" class="form-control">
                                            <option value="#00cc00">Green</option>
                                            <option value="#ff0000">Red</option>
                                            <option value="#0000ff">Blue</option>
                                            <option value="#970097">Purple</option>
                                            <option value="#333">Dark gray</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Location</label>
                                        <input type="text" class="form-control" name="location">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Type or Strain</label>
                                        <select name="type_of_strain" class="form-control">
                                            <option value="Edibles">Edibles</option>
                                            <option value="Flower">Flower</option>
                                            <option value="Oil">Oil</option>
                                            <option value="Tincture">Tincture</option>
                                            <option value="Patches">Patches</option>
                                            <option value="Indica/Sativa">Indica/Sativa</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Price per Unit in USD</label>
                                        <input type="text" class="form-control" name="price_per_unit">
                                    </div>
                                    <div class="form-group" id="pricePerQuantity">
                                        <label>Price per Quantity in USD</label>
                                        <div class="clearfix">
                                            <div class="input-box">
                                                <span>Gram</span>
                                                <input type="text" name="price_per_quantity[gram]">
                                            </div>
                                            <div class="input-box">
                                                <span>Eighth</span>
                                                <input type="text" name="price_per_quantity[eighth]">
                                            </div>
                                            <div class="input-box">
                                                <span>Quarter</span>
                                                <input type="text" name="price_per_quantity[quater]">
                                            </div>
                                            <div class="input-box">
                                                <span>Half</span>
                                                <input type="text" name="price_per_quantity[half]">
                                            </div>
                                            <div class="input-box">
                                                <span>Ounce</span>
                                                <input type="text" name="price_per_quantity[ounce]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Upload Logo/Product for Thumbnail</label>
                                        <input type="file" name="thumb" accept="image/*">
                                    </div>
                                </div>
                                <hr class="clearfix" style="border-color: #000000;">
                                @if(auth()->user()->package == 'weekly' || auth()->user()->package == 'weekly_pro')
                                    <div class="form-group col-md-12">
                                        <label for="">Place your Ad copy here</label>
                                        <div class="simple-editor" id="adContent"></div>
                                    </div>
                                @else
                                    <div class="form-group col-md-12">
                                        <label for="">Place your Ad copy here</label>
                                        <input type="text" placeholder="This is one line of text that buyers want" name="adContent" class="form-control">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="dropzone">
                            <h3 class="text-center">Upload up to 4 Photos</h3>

                            <div class="row">
                                <div class="col-md-3">
                                    <img src="" class="preview">
                                    <input type="file" name="gallery[]" accept="image/*">
                                </div>
                                <div class="col-md-3">
                                    <img src="" class="preview">
                                    <input type="file" name="gallery[]" accept="image/*">
                                </div>
                                <div class="col-md-3">
                                    <img src="" class="preview">
                                    <input type="file" name="gallery[]" accept="image/*">
                                </div>
                                <div class="col-md-3">
                                    <img src="" class="preview">
                                    <input type="file" name="gallery[]" accept="image/*">
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /#step1 -->
                <div class="btn-group mjex">
                    {{--<a href="#" class="btn green-gradient">skip</a>--}}
                    <button type="submit" class="btn green-gradient">next</button>
                </div>
            </form>

            <div class="row" id="step2" style="display: none;">
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
        @else
            <p class="text-center">Can't create more ad. Please wait until next month or create a <a href='{{ route('ad.create.paid') }}'>Paid ad</a></p>
        @endif
    </section>
@endsection

@section('page-js')
    <script>
        function previewFile(input, previewImg) {
            var preview = previewImg;
            var file    = input.files[0];
            var reader  = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
        jQuery(document).ready(function($) {
            $('[name="gallery[]"]').change(function(){
                var previewImg = $(this).parent().find('img');
                previewImg.show();
                previewFile($(this)[0], previewImg[0]);
            });
        });
    </script>
@endsection