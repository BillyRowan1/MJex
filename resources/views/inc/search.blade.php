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

<div id="SearchBox" class="home-search-wrap clearfix">
    <form action="{{ url('search') }}" method="get">
        {!! csrf_field() !!}
        <div class="zipcode">
            <select name="ad_created_by" class="form-control">
                <option value="">View Ad Type</option>
                <option value="adult_use">Adult Use +21</option>
                <option value="medical">Medical</option>
                <option value="grower">Growers</option>
                <option value="other">Other Businesses</option>
            </select>
        </div>

        <input type="hidden" name="lat">
        <input type="hidden" name="lng">
        <input type="text" name="keyword" placeholder="Type in a City, State, or Product Name" class="search">
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
                    @foreach(session('bannerAds') as $idx => $bannerAd)
                    <li data-target="#carousel-example-generic" data-slide-to="{{ $idx }}" class="{{ $idx == 0 ? 'active' : '' }}"></li>
                    @endforeach
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    @foreach(session('bannerAds') as $idx => $bannerAd)
                        <div class="item {{ $idx == 0?'active':'' }}" style="background-image: url('{{ $bannerAd->thumb }}')"></div>
                    @endforeach
                </div>
            </div>

        </ul>
    @endif
    <div class="section-posts">
        <h2 class="title">search results</h2>

        @foreach(session('searchResults') as $adType => $ads)
            <h3 class="section-title">{{ $adType }}</h3>
            @foreach($ads as $ad)
            <a href="{{ route('cart.index', ['seller_id' => $ad->user_id]) }}">
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
                            <td>{{ $ad->user->community_name }}</td>
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
                        <p>{!! $ad->content !!}</p>
                    </div>
                </div>
            </a>
            @endforeach
        @endforeach

        @if(session('growerResults'))
            <section>
                <div class="section-title">Growers</div>
                @foreach(session('growerResults') as $grower)
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
@endif