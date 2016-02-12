<nav id="main-nav">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <ul id="main-menu" class="collapse navbar-collapse">
    	<li><a class="active" href="{{ url('/') }}">home</a></li>
	    <li><a href="{{ url('contact') }}">contact</a></li>
        @if(!auth()->user())
    	    <li class="active"><a href="{{ url('register') }}">sign up</a></li>
        @else
            <li class="active"><a href="{{ url('account') }}">account</a></li>
        @endif
        <li><a href="{{ route('ad.create') }}">post ad</a></li>
        <li><a href="{{ url('find-growers') }}">find growers</a></li>
	    <li><a href="{{ url('faq') }}">faq</a></li>
    </ul>
</nav>