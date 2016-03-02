@extends('master')

@section('main')
    <div class="modal fade" id="chooseLocationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">Drag marker to select your location</div>
                    <div id="map"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Choose</button>
                </div>
            </div>
        </div>
    </div>
    <section id="Home" class="main-content">
        <div class="container">
            <div class="row">
                <img src="img/logo2.png" alt="logo" class="second-logo">
                <h1 class="title">Connecting <span class="green-text">Seekers and Sellers</span> Anonymously</h1>
                @include('inc.msg')
                <div class="home-search-wrap clearfix">
                    <form action="{{ url('search') }}" method="get">
                        {!! csrf_field() !!}
                        <!-- <div class="zipcode">
                            <span>Your zipcode</span>
                            <input type="text" name="zipcode">
                        </div> -->
                        <div class="zipcode">
                            <span>Your location</span>
                            <button type="button" data-toggle="modal" data-target="#chooseLocationModal" class="btn">Choose</button>
                            <input type="hidden" name="lat" value="{{ auth()->user()?auth()->user()->lat:'' }}">
                            <input type="hidden" name="lng" value="{{ auth()->user()?auth()->user()->lng:'' }}">
                        </div>
                        <input type="text" name="keyword" placeholder="What are you looking for?" class="search">
                        <div class="green-gradient search-submit-wrap">
                            <button class="search-submit" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                
                {{--Search results--}}
                @if(session('searchResults'))
                    @if(session('bannerAds'))
                        <ul id="bannerAds">
                            
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                </ol>
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    @foreach(session('bannerAds') as $idx => $bannerAd)
                                    <div class="item {{ $idx == 0?'active':'' }}" style="background-image: url('{{ $bannerAd->thumb }}')">
                                        {{ $bannerAd->thumb?'':$bannerAd->content }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </ul>
                    @endif
                <div class="section-posts">
                    <h2 class="title">search results</h2>
                    {{--<div class="sort">--}}
                        {{--Sort By: <a href="#">latest</a> <a href="#">closest to me</a>--}}
                    {{--</div>--}}

                    @foreach(session('searchResults') as $ad)
                        <a href="{{ route('cart.index', ['seller_id'=>$ad->user_id]) }}">
                            <div class="post">
                                <table>
                                    <thead class="red-bg" style="background-color: {{ $ad->header_color }};">
                                    <th>SELLER</th>
                                    <th>TYPE OF PRODUCT</th>
                                    <th>TYPE OR STRAIN</th>
                                    <th>UNIT DESC</th>
                                    <th>PRICE/UNIT</th>
                                    <th>AMOUNT</th>
                                    <th>LOCATION</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $ad->user->community_name }}</td>
                                        <td>{{ $ad->type_of_product }}</td>
                                        <td>{{ $ad->type_of_strain }}</td>
                                        <td>{{ $ad->unit_desc }}</td>
                                        <td>{{ $ad->price_per_unit }}</td>
                                        <td>{{ $ad->amount }}</td>
                                        <td>{{ $ad->location }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="content clearfix">
                                    @if(!empty($ad->thumb))
                                        <div class="thumb" style="background-image: url('{{ url($ad->thumb) }}')"></div>
                                    @endif
                                    <p>{!! $ad->content !!}</p>
                                </div>
                            </div>
                        </a>
                        <!-- end post -->
                    @endforeach
                </div>
                @endif

                @if(!auth()->user())
                <h2 class="step"><span class="green-text">Step 1</span>  Sign Up to open an account with an anonymous email.
                    <br><span class="green-text">Step 2</span>  Use your anonymous email to buy and sell.</h2>

                <div id="pricing">
                    <div class="wrapper">
                        <div class="box" id="price-free">
                            <span class="title">basic</span>
                            <span class="price">free</span>
                            <ul>
                                <li>Post a one line ad
                                    <br>+ $1 for formatting
                                    <br>(Good for one month)</li>
                                <li>$2 per extra ad
                                    <br>Includes
                                    <br>Sellers Page/Shopping Cart</li>
                            </ul>
                            <a href="{{ url('register') }}?package=free" class="btn sign-up">sign up</a>
                        </div>
                        <div class="box" id="price-monthly">
                            <span class="title">monthly</span>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="number">5</span>
                                <span class="small">month</span>
                            </div>
                            <ul>
                                <li>5 ads per month</li>
                                <li>Sellers Page/Shopping Cart</li>
                                <li>Ad thumbnail with text formatting</li>
                                <li>Only $60/ yr</li>
                            </ul>
                            <a href="{{ url('register') }}?package=monthly" class="btn sign-up">sign up</a>
                        </div>
                        <div class="box" id="price-monthly-pro">
                            <span class="title">monthly pro</span>
                            <div class="price">
                                <span class="currency">$</span>
                                <span class="number">10</span>
                                <span class="small">month</span>
                            </div>
                            <ul>
                                <li>5 ads per month</li>
                                <li>Sellers Page/Shopping Cart 728x90 Banner</li>
                                <li>Ad thumbnail with text formatting</li>
                                <li>Only $100 / yr</li>
                            </ul>
                            <a href="{{ url('register') }}?package=monthly_pro" class="btn sign-up">sign up</a>
                        </div>
                    </div>
                </div>
                @endif

                {{--Latest posts--}}
                <div class="section-posts">
                    <h2 class="title">latest posts</h2>
                    {{--<div class="sort">--}}
                        {{--Sort By: <a href="#">latest</a> <a href="#">closest to me</a>--}}
                    {{--</div>--}}

                    @if($latestAds)
                        @foreach($latestAds as $ad)
                        <a href="{{ route('cart.index', ['seller_id'=>$ad->user_id]) }}">
                            <div class="post">
                                <table>
                                    <thead class="red-bg" style="background-color: {{ $ad->header_color }};">
                                        <th>SELLER</th>
                                        <th>TYPE OF PRODUCT</th>
                                        <th>TYPE OR STRAIN</th>
                                        <th>UNIT DESC</th>
                                        <th>PRICE/UNIT</th>
                                        <th>AMOUNT</th>
                                        <th>LOCATION</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $ad->user->community_name }}</td>
                                        <td>{{ $ad->type_of_product }}</td>
                                        <td>{{ $ad->type_of_strain }}</td>
                                        <td>{{ $ad->unit_desc }}</td>
                                        <td>{{ $ad->price_per_unit }}</td>
                                        <td>{{ $ad->amount }}</td>
                                        <td>{{ $ad->location }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="content clearfix">
                                    @if(!empty($ad->thumb))
                                    <div class="thumb" style="background-image: url('{{ url($ad->thumb) }}')"></div>
                                    @endif
                                    <p>{!! $ad->content !!}</p>
                                </div>
                            </div>
                            <!-- end post -->
                        </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
<script>
    (function () {
        function initMap() {
            var defaultLocation = { lat: 36.228300, lng: -119.494996 };
            var $latInput = $('[name=lat]');
            var $lngInput = $('[name=lng]');
            if($latInput.val()) { defaultLocation.lat = $latInput.val(); }
            if($lngInput.val()) { defaultLocation.lng = $lngInput.val(); }
            var map = new GMaps({
                el: '#map',
                lat: defaultLocation.lat,
                lng: defaultLocation.lng,
                zoom: 5
            });
            var marker = map.addMarker({
                lat: defaultLocation.lat,
                lng: defaultLocation.lng,
                draggable: true,
                dragend: function () {
                    var lat = this.getPosition().lat(),
                        lng = this.getPosition().lng();
                    $latInput.val(lat);
                    $lngInput.val(lng);
                }
            });
        }

        $('#chooseLocationModal').on('shown.bs.modal', function (e) {
            initMap();
        })
    })();
</script>
@endsection