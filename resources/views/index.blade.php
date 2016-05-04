@extends('master')

@section('main')
        <!-- popups -->
@if(!null != auth()->user() )
    <section id="legal-page">
        <div class="content fluid-center">
            <h2 class="title">Age Restricted Content</h2>
            <p>Marijuana Exchange does business in accordance
                with state laws regarding access to cannabis.
                <br>
                You must be at least 21 years old, or a
                valid medical marijuana patient.
                <br>
                Are you eligible to visit
                Marijuana Exchange?</p>
            <div class="btn-group" style="margin-bottom: 20px;">
                <div class="btn bg-cover no">no</div>
                <div class="btn bg-cover yes">yes</div>
            </div>
            <p class="text-center">Search for which?</p>
            <div class="form-group checkbox-group circle-checkboxes clearfix">
                <input type="checkbox" id="legal-seller" value="medical" name="purpose[]">
                <label for="legal-seller">Seller</label>

                <input type="checkbox" id="legal-grower" value="grower" name="purpose[]">
                <label for="legal-grower">Grower</label>

                <input type="checkbox" id="legal-business" value="doctor" name="purpose[]">
                <label for="legal-business">Business</label>
            </div>
        </div>
    </section>
@endif

    <section id="Home" class="main-content">
        @include('inc.sidebar_left_banner')
        @include('inc.sidebar_right_banner')
        <div class="container">
            <div class="row">
                @include('inc.home_header_banner')

                <h2 class="step">Find Classifieds, Growers, Dispensaries <br>and Other <span class="green-text">Cannabis</span> Products</h2>

                <h1 class="title">Connecting <span class="green-text">Seekers and Sellers</span> Anonymously</h1>
                @include('inc.msg')
                @include('inc.search')

                @if(!auth()->user())

                <div id="pricing">
                    <div class="wrapper">
                        <div class="box" id="price-free">
                            <span class="title">basic</span>
                            <span class="price">free</span>
                            <ul>
                                <li>Post an ad for 1 week free</li>
                                <li>Sellers Page/Shopping Cart</li>
                            </ul>
                            <a href="{{ url('register') }}?package=free" class="btn sign-up">sign up</a>
                        </div>
                        <div class="box" id="price-monthly">
                            <span class="title">WEEKLY</span>
                            <div class="price">
                                <!-- <span class="currency">$</span> -->
                                <span class="number">$5</span>
                                <!-- <span class="small">/ad/week</span> -->
                            </div>
                            <ul>
                                <li>$5 per ad per week</li>
                                <li>Sellers Page/Shopping Cart</li>
                                <li>Ad thumbnail with text formatting</li>
                            </ul>
                            <a href="{{ url('register') }}?package=weekly" class="btn sign-up">sign up</a>
                        </div>
                        <div class="box" id="price-monthly-pro">
                            <span class="title">WEEKLY pro</span>
                            <div class="price">
                                <!-- <span class="currency">$</span> -->
                                <span class="number">$10</span>
                                <!-- <span class="small">/ad/week</span> -->
                            </div>
                            <ul>
                                <li>$10 per ad per week</li>
                                <li>Sellers Page/Shopping Cart</li>
                                <li>728x90 Banner</li>
                                <li>Ad thumbnail with text formatting</li>
                            </ul>
                            <a href="{{ url('register') }}?package=weekly_pro" class="btn sign-up">sign up</a>
                        </div>
                    </div>
                </div>
                @endif
                
                <section class="map-wrapper">
                    <input id="pac-input" class="controls" type="text" placeholder="Search">
                    <div id="sellermap"></div>
                </section>

                {{--Latest posts--}}
                <div class="section-posts">
                    <h2 class="title">latest posts</h2>
                    @if($latestAds)
                        @foreach($latestAds as $adType => $ads)
                            <section>
                                <h3 class="section-title">{{ $adType }}</h3>
                                @foreach($ads as $ad)
                                    <a href="{{ route('cart.index', ['seller_id'=>$ad->user_id]) }}">
                                        <div class="post">
                                            <table>
                                                <thead class="red-bg" style="background-color: {{ $ad->header_color }};">
                                                <th>SELLER</th>
                                                <th>TYPE OF PRODUCT</th>
                                                <th>DESCRIPTION</th>
                                                <th>UNIT AVAILABLE</th>
                                                <th>PRICE/UNIT</th>
                                                <th>AMOUNT</th>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{ $ad->user->community_name }} ({{ count($ad->user->reviews) . '+' }})</td>
                                                    <td>{{ $ad->type_of_product }}</td>
                                                    <td>{{ $ad->description }}</td>
                                                    <td>{{ $ad->unit_available }}</td>
                                                    <td>${{ $ad->price_per_unit }}</td>
                                                    <td>{{ $ad->amount }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="content clearfix">
                                                @if(!empty($ad->thumb))
                                                    <div class="thumb" style="background-image: url('{{ url($ad->thumb) }}')"></div>
                                                @endif
                                                <div>{!! $ad->content !!}</div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </section>
                        @endforeach
                    @endif

                    @if($latestGrowers)
                        <section>
                            <div class="section-title">Growers</div>
                            @foreach($latestGrowers as $grower)
                            <a href="{{ route('cart.index', ['seller_id' => $grower->id]) }}">
                                <div class="post">
                                    <table>
                                        <thead class="red-bg" style="background-color: {{ $ad->header_color }};">
                                        <th>Name</th>
                                        <th>Spots available</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td width="50%">{{ $grower->community_name }}</td>
                                            <td>{{ $grower->patients_available }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </a>
                            @endforeach
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js-before')
@if(auth()->user())
<script>
    var currentUserAddress = '{{ auth()->user()->state }}, {{ auth()->user()->country }}';
</script>
@endif
@endsection