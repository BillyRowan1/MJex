@foreach($edibles as $edible)
    <div class="row item">
        <div class="col-md-3">
            <img src="{{ $edible['item']['image'] }}" alt="{{ $edible['name'] }}">
        </div>
        <div class="col-md-9">
            <h4>{{ $edible['name'] }}</h4>
            <h5>{{ $edible['item']['producer']['name'] }}</h5>
            <ul>
                <li><i class="icon-beaker"></i> CBD: {{ $edible['item']['cbd'] }}</li>
                <li><i style="color: red;" class="icon-beaker"></i> THC: {{ $edible['item']['thc'] }}</li>
            </ul>

            <div class="row menu-row price-row menu-price-line">
                <div class="col-xs-1">
                    <p><i class="icon-tag"></i></p>
                </div>
                <div class="col-xs-2">
                    <p>${{ $edible['price_gram'] or 0 }}
                        <br class="visible-xs visible-sm"><small>/g</small></p>
                </div>
                <div class="col-xs-2">
                    <p>${{ $edible['price_eighth'] or 0 }}
                        <br class="visible-xs visible-sm"><small> ⅛</small></p>
                </div>
                <div class="col-xs-2">
                    <p>${{ $edible['price_quarter'] or 0 }}
                        <br class="visible-xs visible-sm"><small> ¼</small></p>
                </div>
                <div class="col-xs-2">
                    <p>${{ $edible['price_half_ounce'] or 0 }}
                        <br class="visible-xs visible-sm"><small> ½</small></p>
                </div>
                <div class="col-xs-2">
                    <p>${{ $edible['price_ounce'] or 0 }}
                        <br class="visible-xs visible-sm"><small>/oz</small></p>
                </div>
            </div>
        </div>
    </div>
@endforeach