@extends('master')

@section('main')
    <div class="container" id="DispensariesDetail">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="sidebar block">
                    <img class="avatar" src="{{ $dispensary['image'] }}" alt="">
                    <h4 class="name">{{ $dispensary['name'] }}</h4>
                    <p>Cannabis Dispensary in {{ $dispensary['city'] }}, {{ $dispensary['state'] }}</p>
                    <a target="_blank" href="https://www.google.com/maps/dir/Current+Location/{{ $dispensary['address']['address1'] }}+{{ $dispensary['state'] }}+{{ $dispensary['address']['zip'] }}"><button class="btn btn-circle btn-gradient"><i class="icon-map-marker"></i> Get direction</button></a>
                    <ul class="more clearfix">
                        <li><a target="_blank" href="https://maps.google.com/?q={{ $dispensary['address']['address1'] }}+{{ $dispensary['state'] }}+{{ $dispensary['address']['zip'] }}"><i class="icon-map-marker"></i> Map</a></li>
                        <li><a href="#cannabis-menu"><i class="icon-list-alt"></i> Menu</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="block" id="cannabis-menu">
                    <h3><i class="icon-book"></i> Cannabis Menu</h3>
                    <ul class="menu clearfix">
                        <li><a class="btn btn-default" role="tab" data-toggle="tab" href="#flowers"><i class="icon-leaf"></i> Flowers - {{ $dispensary['flowers']['count'] }}</a></li>
                        <li><a class="btn btn-default" role="tab" data-toggle="tab" href="#extracts"><i class="icon-filter"></i> Extracts - {{ $dispensary['extracts']['count'] }}</a></li>
                        <li><a class="btn btn-default" role="tab" data-toggle="tab" href="#edibles"><i class="glyphicon glyphicon-cutlery"></i> Edibles - {{ $dispensary['edibles']['count'] }}</a></li>
                        <li><a class="btn btn-default" role="tab" data-toggle="tab" href="#products"><i class="icon-certificate"></i> Products - {{ $dispensary['products']['count'] }}</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="block tab-pane active" id="flowers">
                        <div class="content">
                            @include('partials.flowers_row')
                        </div>

                        <button class="btn btn-primary btn-loadmore" id="loadmore-flowers" data-link="{{ $dispensary['flowers']['link'] }}">Load more</button>
                    </div>
                    <div role="tabpanel" class="block tab-pane" id="extracts">
                        <div class="content">
                            @include('partials.extracts_row')
                        </div>

                        <button class="btn btn-primary btn-loadmore" id="loadmore-extracts" data-link="{{ $dispensary['extracts']['link'] }}">Load more</button>
                    </div>
                    <div role="tabpanel" class="block tab-pane" id="edibles">
                        <div class="content">
                            @include('partials.edibles_row')
                        </div>

                        <button class="btn btn-primary btn-loadmore" id="loadmore-edibles" data-link="{{ $dispensary['edibles']['link'] }}">Load more</button>
                    </div>
                    <div role="tabpanel" class="block tab-pane" id="products">
                        <div class="content">
                            @include('partials.products_row')
                        </div>

                        <button class="btn btn-primary btn-loadmore" id="loadmore-products" data-link="{{ $dispensary['products']['link'] }}">Load more</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        jQuery(document).ready(function($) {
            var flowersPage = 1;
            $('#loadmore-flowers').click(function(){
                var link = $(this).data('link') + '?page=' + (++flowersPage);
                var type = 'flowers';
                var _self = $(this);
                _self.text('Loading...');
                loadMore(link, type, '#flowers .content');
            });
            var extractsPage = 1;
            $('#loadmore-extracts').click(function(){
                var link = $(this).data('link') + '?page=' + (++extractsPage);
                var type = 'extracts';
                var _self = $(this);
                _self.text('Loading...');
                loadMore(link, type, '#extracts .content');
            });
            $('#loadmore-edibles').click(function(){
                var link = $(this).data('link') + '?page=' + (++flowersPage);
                var type = 'edibles';
                var _self = $(this);
                _self.text('Loading...');
                loadMore(link, type, '#edibles .content');
            });
            $('#loadmore-products').click(function(){
                var link = $(this).data('link') + '?page=' + (++flowersPage);
                var type = 'products';
                var _self = $(this);
                _self.text('Loading...');
                loadMore(link, type, '#products .content');
            });

            function loadMore(link, type, appendTarget) {
                $.ajax({
                    url: '{{ url("dispensaries/items") }}',
                    type: 'POST',
                    data: {link: link, type: type}
                })
                .done(function(res) {
                    if(res) {
                        $(appendTarget).append(res);
                    }else{
                        $('#loadMore-'+type).hide();
                    }
                })
                .fail(function() {
                    alert('Failed to get more '+type);
                })
                .always(function() {
                    $('#loadMore-'+type).text('Load more');
                });
            }
        });
    </script>
@endsection