<ul id="footer-menu">
    <li><a class="active" href="{{ url('/') }}">home</a></li>
    <li><a href="{{ url('contact') }}">contact</a></li>
    {{--<li><a href="account.php">account</a></li>--}}
    <li><a href="{{ route('ad.create') }}">post ad</a></li>
    <li><a href="{{ url('find-growers') }}">find growers</a></li>
    <li><a href="{{ url('faq') }}">faq</a></li>
</ul>