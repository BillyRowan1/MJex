@extends('master')

@section('main')

    <section id="Home" class="main-content">
        <div class="container">
            <div class="row">
                <img src="img/logo2.png" alt="logo" class="second-logo">
                <h1 class="title">Connecting <span class="green-text">Seekers and Sellers</span> Anonymously</h1>
                <div class="home-search-wrap clearfix">
                    <div class="zipcode">
                        <span>Your zipcode</span>
                        <input type="text" name="zipcode">
                    </div>
                    <input type="text" placeholder="What are you looking for?" class="search">
                    <div class="green-gradient search-submit-wrap">
                        <button class="search-submit" type="submit">Search</button>
                    </div>
                </div>
                <h2 class="step"><span class="green-text">Step 1</span>  Sign Up to open an account with an anonymous email.
                    <br><span class="green-text">Step 2</span>  Use your anonymous email to buy and sell.</h2>

                <div class="section-posts">
                    <h2 class="title">search results</h2>
                    <div class="sort">
                        Sort By: <a href="#">latest</a> <a href="#">closest to me</a>
                    </div>

                    <div class="post">
                        <table>
                            <thead class="red-bg">
                            <th>SELLER</th>
                            <th>TYPE OF PRODUCT</th>
                            <th>TYPE OR STRAIN</th>
                            <th>UNIT</th>
                            <th>DESC</th>
                            <th>PRICE/UNIT</th>
                            <th>AMT</th>
                            <th>LOCATION</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>bambam (30+; 100%)      </td>
                                <td>Flowers         </td>
                                <td>Sativa/Sour Diesel  </td>
                                <td>Gram            </td>
                                <td>20 USD          </td>
                                <td>2       </td>
                                <td>Michigan/USA</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="content">
                            <div class="thumb"></div>
                            <p>This is where 3 lines of text for the ad that the buyer wants.
                                This is where 3 lines of text for the ad that the buyer wants.This is where 3 lines of text for the ad that the buyer wants. This
                                of text for the ad that the buyer wants. This is where 3 lines of text for the ad that the buyer wants. This is where 3 lines of.</p>
                        </div>
                    </div>
                    <!-- end post -->
                </div>

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
                            <a href="{{ url('signup') }}?package=free" class="btn sign-up">sign up</a>
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
                            <a href="{{ url('signup') }}?package=monthly" class="btn sign-up">sign up</a>
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
                            <a href="{{ url('signup') }}?package=monthly_pro" class="btn sign-up">sign up</a>
                        </div>
                    </div>
                </div>

                <div class="section-posts">
                    <h2 class="title">latest posts</h2>
                    <div class="sort">
                        Sort By: <a href="#">latest</a> <a href="#">closest to me</a>
                    </div>

                    <div class="post">
                        <table>
                            <thead class="red-bg">
                            <th>SELLER</th>
                            <th>TYPE OF PRODUCT</th>
                            <th>TYPE OR STRAIN</th>
                            <th>UNIT</th>
                            <th>DESC</th>
                            <th>PRICE/UNIT</th>
                            <th>AMT</th>
                            <th>LOCATION</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>bambam (30+; 100%)      </td>
                                <td>Flowers         </td>
                                <td>Sativa/Sour Diesel  </td>
                                <td>Gram            </td>
                                <td>20 USD          </td>
                                <td>2       </td>
                                <td>Michigan/USA</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="content">
                            <div class="thumb"></div>
                            <p>This is where 3 lines of text for the ad that the buyer wants.
                                This is where 3 lines of text for the ad that the buyer wants.This is where 3 lines of text for the ad that the buyer wants. This
                                of text for the ad that the buyer wants. This is where 3 lines of text for the ad that the buyer wants. This is where 3 lines of.</p>
                        </div>
                    </div>
                    <!-- end post -->
                </div>
            </div>
        </div>
    </section>

@endsection