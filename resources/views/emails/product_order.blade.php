<h2>Customer: {{ $buyer->community_name }}@mjex.co</h2>
<h2>Customer order Products from Cannabis Report:</h2>
<ul>
    @foreach(Cart::instance('products')->content() as $cartItem)
        <li>
            <span>Quantity: {{ $cartItem->qty }}</span><br>
            <span class="name">Product: {{ $cartItem->name }}</span><br>
            <span>UCPC: {{ $cartItem->id }}</span>
        </li>
    @endforeach
</ul>