@foreach($extracts as $extract)
<div class="row item">
    <div class="col-md-3">
        <img src="{{ $extract['item']['image'] }}" alt="{{ $extract['name'] }}">
    </div>
    <div class="col-md-9">
        <h4>{{ $extract['name'] }}</h4>
        <h5>{{ $extract['item']['producer']['name'] }}</h5>

        <div class="row menu-row price-row menu-price-line">
            <div class="col-xs-1">
                <p><i class="icon-tag"></i></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $extract['price_gram'] or 0 }}
                    <br class="visible-xs visible-sm"><small>/g</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $extract['price_eighth'] or 0 }}
                    <br class="visible-xs visible-sm"><small> ⅛</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $extract['price_quarter'] or 0 }}
                    <br class="visible-xs visible-sm"><small> ¼</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $extract['price_half_ounce'] or 0 }}
                    <br class="visible-xs visible-sm"><small> ½</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $extract['price_ounce'] or 0 }}
                    <br class="visible-xs visible-sm"><small>/oz</small></p>
            </div>
        </div>
    </div>
</div>
@endforeach