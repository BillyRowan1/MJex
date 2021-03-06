@extends('master')

@section('main')
    <section id="PostAds" class="container">
        @include('inc.msg')

        <h2 class="text-center">Edit Ad #{{$ad->id}}</h2>
        <form action="{{ route('ad.update') }}" method="post" enctype="multipart/form-data">
            <div id="step1">
                    {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $ad->id }}">
                    <div class="box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Type of Product</label>
                                    {!! Form::select('type_of_product', array(
                                        'Flowers'=>'Flowers',
                                        'Oil'=>'Oil',
                                        'Edible'=>'Edible',
                                        'Topical'=>'Topical',
                                        'Concentrate'=>'Concentrate',
                                        'Other'=>'Other'
                                         ), $ad->type_of_product, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Unit Available</label>
                                    {!! Form::select('unit_available', array(
                                        "Gram" => "Gram",
                                        "Eighth" => "Eighth",
                                        "Quarter" => "Quarter",
                                        "Half" => "Half",
                                        "Ounce" => "Ounce",
                                        "lb" => "lb",
                                         ), $ad->unit_available, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Amount</label>
                                    <input type="text" class="form-control" name="amount" value="{{ $ad->amount }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Header color</label>

                                    {!! Form::select('header_color', array(
                                        '#00cc00' => 'Green',
                                        '#ff0000' => 'Red',
                                        '#0000ff' => 'Blue',
                                        '#970097' => 'Purple',
                                        '#333' => 'Dark gray',
                                         ), $ad->header_color, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Description</label>
                                    {!! Form::text('description', $ad->description, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="">Price (USD)</label>
                                    <input type="text" class="form-control" name="price_per_unit" value="{{ $ad->price_per_unit }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Category</label>
                                    {!! Form::select('category', array(
                                        'adult_use' => 'Adult use +21',
                                        'medical' => 'Medical',
                                        'other' => 'Other',
                                         ), $ad->category, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    <label for="">Upload Product Thumbnail</label>
                                    <input type="file" name="thumb" accept="image/*">
                                    @if($ad->thumb)
                                    <img style="height: 100px;" src="{{ asset($ad->thumb) }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <hr class="clearfix" style="border-color: #000000;">
                            @if($ad->ad_type == 'paid')
                                <div class="form-group col-md-12">
                                    <div class="simple-editor" id="adContent">{!! $ad->content !!}</div>
                                </div>
                            @else
                                <div class="form-group col-md-12">
                                    <label for="">Ad content</label>
                                    <input type="text" placeholder="This is one line of text that buyers want" name="adContent" class="form-control" value="{{ $ad->content }}">
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
                                @if(isset($ad->gallery[0]))
                                    <img class="img-responsive" src="{{ asset($ad->gallery[0]) }}" alt="">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <img src="" class="preview">
                                <input type="file" name="gallery[]" accept="image/*">
                                @if(isset($ad->gallery[1]))
                                    <img class="img-responsive" src="{{ asset($ad->gallery[1]) }}" alt="">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <img src="" class="preview">
                                <input type="file" name="gallery[]" accept="image/*">
                                @if(isset($ad->gallery[2]))
                                    <img class="img-responsive" src="{{ asset($ad->gallery[2]) }}" alt="">
                                @endif
                            </div>
                            <div class="col-md-3">
                                <img src="" class="preview">
                                <input type="file" name="gallery[]" accept="image/*">
                                @if(isset($ad->gallery[3]))
                                    <img class="img-responsive" src="{{ asset($ad->gallery[3]) }}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /#step1 -->
            <div class="btn-group mjex">
                {{--<a href="#" class="btn green-gradient">skip</a>--}}
                <button type="submit" class="btn green-gradient">Save</button>
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