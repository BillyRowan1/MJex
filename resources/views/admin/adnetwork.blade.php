@extends('admin.master')

@section('main')
    <section id="AdminDashboard" class="container">
        <div class="row">
            <div class="col-md-12">
                @include('inc.msg')

                <h1>Ad Network</h1>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a role="tab" data-toggle="tab" href="#tabAdPlacements">Ad placements</a></li>
                    <li role="presentation"><a role="tab" data-toggle="tab" href="#tabBannerAds">Purchased banners</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tabAdPlacements">

                        <table class="table panel panel-default">
                            <thead>
                            <tr>
                                <th>Position</th>
                                <th>Price ($)</th>
                                <th>Max Slot</th>
                                <th>Save</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bannerPlacements as $bannerPlacement)
                                <tr>
                                    {!! Form::open(['method'=>'put']) !!}
                                    <input type="hidden" value="{{ $bannerPlacement->id }}" name="id">
                                    <td><input type="text" name="title" value="{{ $bannerPlacement->title }}"></td>
                                    <td><input type="number" name="price" value="{{ $bannerPlacement->price }}"></td>
                                    <td><input type="number" name="max_slot" value="{{ $bannerPlacement->max_slot }}"></td>
                                    <td><input class="btn btn-primary" type="submit" value="Save"></td>
                                    {!! Form::close() !!}
                                </tr>
                            @endforeach

                            <input type="hidden" name="banner_type">
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tabBannerAds">
                        <table class="table panel panel-default">
                            <thead>
                            <tr>
                                <th>Position</th>
                                <th>Image</th>
                                <th>Active</th>
                                <th>Deactive</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bannerAds as $banner)
                                <tr>
                                    <td>{{ $banner->bannerPlacement->title }}</td>
                                    <td><a href="{{ url($banner->image) }}" target="_blank"><img src="{{ url($banner->image) }}" height="40px"></a></td>
                                    <td>{{ $banner->active == 1 ? 'Yes' : 'No' }}</td>
                                    <td>
                                        {!! Form::open(['method'=>'put','action'=>'Admin\DashboardController@putBannerAds']) !!}
                                        <input type="hidden" name="id" value="{{ $banner->id }}">
                                        <input type="hidden" name="active" value="{{ $banner->active == 1 ? 0 : 1 }}">
                                        <button class="btn btn-{{ $banner->active == 1 ? 'default' : 'warning' }}" type="submit">{{ $banner->active == 1 ? 'Deactive' : 'Active' }}</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                            <input type="hidden" name="banner_type">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    <script>
        // Go to specific welcome tab
        var tabId = location.hash;
        if(tabId) $('a[href='+tabId+']').tab('show');
    </script>
@endsection