@foreach($flowers as $flower)
<div class="row item">
    <div class="col-md-3">
        <img src="{{ $flower['item']['image'] }}" alt="{{ $flower['name'] }}">
    </div>
    <div class="col-md-9">
        <h4>{{ $flower['name'] }}</h4>

        <div class="row menu-row price-row menu-price-line">
            <div class="col-xs-1">
                <p><i class="icon-tag"></i></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $flower['price_gram'] or 0 }}
                    <br class="visible-xs visible-sm"><small>/g</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $flower['price_eighth'] or 0 }}
                    <br class="visible-xs visible-sm"><small> ⅛</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $flower['price_quarter'] or 0 }}
                    <br class="visible-xs visible-sm"><small> ¼</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $flower['price_half_ounce'] or 0 }}
                    <br class="visible-xs visible-sm"><small> ½</small></p>
            </div>
            <div class="col-xs-2">
                <p>${{ $flower['price_ounce'] or 0 }}
                    <br class="visible-xs visible-sm"><small>/oz</small></p>
            </div>
        </div>
    </div>
</div>
@endforeach