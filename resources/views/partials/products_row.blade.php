@foreach($products as $product)
    <div class="row item">
        <div class="col-md-3">
            <img src="{{ $product['item']['image'] }}" alt="{{ $product['name'] }}">
        </div>
        <div class="col-md-9">
            <h4>{{ $product['name'] }}</h4>
            <h5>{{ $product['item']['producer']['name'] }}</h5>

            <div class="row menu-row price-row menu-price-line">
                <div class="col-xs-1">
                    <p><i class="icon-tag"></i></p>
                </div>
                <div class="col-xs-2">
                    <p>${{ $product['price'] or 0 }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach