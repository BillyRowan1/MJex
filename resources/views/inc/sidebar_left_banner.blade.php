<div id="sidebar-left-banner" class="carousel slide sidebar" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php $idx = 0; ?>
        @foreach($bannerAds as $bannerAd)
            @if($bannerAd->bannerPlacement->placement == 'sidebar_left')
            <li data-target="#home-header-banner" data-slide-to="{{ $idx }}" class="{{ $idx == 0 ? 'active' : '' }}"></li>
            @endif
        @endforeach
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php $idx = 0; ?>
        @foreach($bannerAds as $bannerAd)
            @if($bannerAd->bannerPlacement->placement == 'sidebar_left')
            <div class="item {{ $idx == 0 ? 'active' : '' }}" style="background-image: url('{{ $bannerAd->image }}')"></div>
            @endif
        @endforeach
    </div>
</div>