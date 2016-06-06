@foreach(Cart::instance('products')->content() as $cartItem)
    <li data-rowid="{{ $cartItem->rowid }}">
        <input type="number" class="quantity" value="{{ $cartItem->qty }}">
        <span class="name">{{ $cartItem->name }}</span>
        <span> | </span>
        <a href="#" class="delete">remove</a>
    </li>
@endforeach