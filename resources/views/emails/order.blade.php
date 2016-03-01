<h2>Customer order:</h2>
<ul>
    @foreach(Cart::content() as $cartItem)
        <li>
            <span>Quantity: {{ $cartItem->qty }}</span><br>
            <span class="name">Product: {{ $cartItem->name }}</span><br>
            <span class="price">${{ $cartItem->price }}</span>
        </li>
    @endforeach
</ul>