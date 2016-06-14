<h2>Customer:</h2>
<ul>
    <li>{{ $buyer->community_name }}@mjex.co</li>
</ul>
<h2>Customer order:</h2>
<ul>
    @foreach(Cart::content() as $cartItem)
        <li>
            <span>Quantity: {{ $cartItem->qty }}</span><br>
            <span class="name">Product: {{ $cartItem->name }}</span><br>
            <span class="price">Price: ${{ $cartItem->price }}</span>
        </li>
    @endforeach

    {{--@if(is_grower($seller))--}}
        <p class="text-center">
            Confirm order:
                <a href="{{ url('confirm-order') . '?b=' . $buyer->id . '&a=no' }}">Refuse</a>
                <a href="{{ url('confirm-order') . '?b=' . $buyer->id . '&a=yes'}}">Accept</a>
        </p>
    {{--@endif--}}
</ul>