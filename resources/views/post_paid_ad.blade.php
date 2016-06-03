@extends('master')

@section('main')
    <section id="PostAds" class="container">
        <div class="btn-group mjex">
            <a href="{{ route('ad.create.free') }}" class="btn green-gradient">post a free ad</a>
            <a href="{{ route('ad.create.paid') }}" class="btn green-gradient">post a paid ad</a>
        </div>
        <h2 class="text-center">Paid ad ($2 per additional ad)</h2>
        <p class="text-center">(This money automatically charge from your saved Credit card)</p>
        @include('inc.msg')
        <form action="{{ route('ad.store.paid') }}" method="post" enctype="multipart/form-data">
            <div id="step1">
                {!! csrf_field() !!}
                <input type="hidden" name="ad_type" value="paid">

                <div class="box">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Type of Product</label>
                                <select name="type_of_product" class="form-control">
                                    <option value="Flower">Flower</option>
                                    <option value="Oil">Oil</option>
                                    <option value="Edible">Edible</option>
                                    <option value="Topical">Topical</option>
                                    <option value="Concentrate">Concentrate</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Unit Available</label>
                                <select name="unit_available" class="form-control">
                                    <option value="Gram">Gram</option>
                                    <option value="Eighth">Eighth</option>
                                    <option value="Quarter">Quarter</option>
                                    <option value="Half">Half</option>
                                    <option value="Ounce">Ounce</option>
                                    <option value="lb">lb</option>
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Description</label>
                                <input type="text" name="description" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Price (USD)</label>
                                <input type="text" class="form-control" name="price_per_unit">
                            </div>

                            <div class="form-group">
                                <label for="">Category</label>
                                <select name="category" class="form-control">
                                    <option value="adult_use">Adult use +21</option>
                                    <option value="medical">Medical</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Upload Product Thumbnail</label>
                                <input type="file" name="thumb" accept="image/*">
                            </div>
                        </div>
                        <hr class="clearfix" style="border-color: #000000;">

                        <div class="form-group col-md-12">

                            <label for="">Place your Ad copy here</label>
                            <div class="simple-editor" id="adContent"></div>
                        </div>
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
                <button type="submit" class="btn green-gradient">next</button>
            </div>
        </form>
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