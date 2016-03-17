@extends('master')

@section('main')

    <section id="Home" class="main-content">
        <div class="container">
            <div class="row">
                <img src="img/logo2.png" alt="logo" class="second-logo">
                <h1 class="title">Connecting <span class="green-text">Seekers and Sellers</span> Anonymously</h1>
                @include('inc.msg')
                @include('inc.search')

                @if(!auth()->user())
                <h2 class="step"><span class="green-text">Step 1</span>  Sign Up to open an account with an anonymous email.
                    <br><span class="green-text">Step 2</span>  Use your anonymous email to buy and sell.</h2>

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
                                <span class="currency">$</span>
                                <span class="number">5</span>
                                <span class="small">/ad/week</span>
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
                                <span class="currency">$</span>
                                <span class="number">10</span>
                                <span class="small">/ad/week</span>
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
                                        <td>{{ $ad->user->community_name }} ({{ count($ad->user->reviews) . '+' }})</td>
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