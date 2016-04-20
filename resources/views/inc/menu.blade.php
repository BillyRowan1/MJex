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
    	<li class="{{ Request::url()==url('/')?'active':'' }}"><a href="{{ url('/') }}">search</a></li>
        @if(!auth()->user())
    	    <li class="{{ Request::url()==url('register')?'active':'' }}"><a href="{{ url('register') }}">sign up</a></li>
        @else
            <li class="{{ Request::url()==url('account')?'active':'' }}"><a href="{{ url('account') }}">account</a></li>
        @endif
        <li class="{{ Request::url()==route('ad.create.free')?'active':'' }}"><a href="{{ route('ad.create.free') }}">post ad</a></li>
{{--        <li class="{{ Request::url()==url('find-growers')?'active':'' }}"><a href="{{ url('find-growers') }}">find growers</a></li>--}}
        <li class="{{ Request::url()==url('ad-network')?'active':'' }}"><a href="{{ url('ad-network') }}">Ad network</a></li>
	    <li class="{{ Request::url()==url('faq')?'active':'' }}"><a href="{{ url('faq') }}">faq</a></li>
    </ul>
</nav>