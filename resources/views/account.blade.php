@extends('master')
@section('main')
    <section id="Account" class="container {{ auth()->user()->type }}">

        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#tab-orders" aria-controls="home" role="tab" data-toggle="tab">Orders</a></li>
                    @if(auth()->user()->type == 'seller')
                    <li role="presentation"><a href="#tab-ads" aria-controls="home" role="tab" data-toggle="tab">Ads</a></li>
                    @endif
                    <li role="presentation"><a href="#tab-chat-history" aria-controls="profile" role="tab" data-toggle="tab">Chat history</a></li>
                    <li role="presentation" class="active"><a href="#tab-contact" aria-controls="messages" role="tab" data-toggle="tab">Profile</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="tab-orders">
                        {{--<div class="form-group">--}}
                            {{--<label for="filter_1">Medical</label>--}}
                            {{--<input type="checkbox" name="medical">--}}
                            {{--<label for="filter_2">Adult use</label>--}}
                            {{--<input type="checkbox" id="filter_2" name="medical">--}}
                            {{--<label for="filter_3">Both</label>--}}
                            {{--<input type="checkbox" id="filter_3" name="medical">--}}
                        {{--</div>--}}

                        <table class="table">
                            <thead>
                            <th>#</th>
                            <th>DATE</th>
                            <th>description</th>
                            <th>price / unit</th>
                            <th>sold</th>
                            </thead>
                            <tbody>
                                @if(isset($orders)&& (!empty($orders)))
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>12/24/2015</td>
                                        <td>{{ $order->desc }}</td>
                                        <td>${{ $order->price }}</td>
                                        <td>{{ $order->qty }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if(auth()->user()->type == 'seller')
                    <div role="tabpanel" class="tab-pane" id="tab-ads">
                        <div class="form-group">
                            <label for="filter_1">Medical</label>
                            <input type="checkbox" name="medical">
                            <label for="filter_2">Adult use</label>
                            <input type="checkbox" id="filter_2" name="medical">
                            <label for="filter_3">Both</label>
                            <input type="checkbox" id="filter_3" name="medical">
                        </div>

                        <table class="table">
                            <thead>
                            <th>#</th>
                            <th>DATE</th>
                            <th>description</th>
                            <th>price / unit</th>
                            <th>type of product</th>
                            <th>repost</th>
                            <th>delete</th>
                            <th>edit</th>
                            </thead>
                            <tbody>
                                @if(isset($ads)&& (!empty($ads)))
                                    @foreach($ads as $ad)
                                    <tr>
                                        <td>{{ $ad->id }}</td>
                                        <td>{{ $ad->created_at }}</td>
                                        <td>{{ $ad->unit_desc }}</td>
                                        <td>{{ $ad->price_per_unit }}</td>
                                        <td>{{ $ad->type_of_product }}</td>
                                        <td><a href="#"><img src="img/ic-repost.png" alt="" class="repost"></a></td>
                                        <td><a href="#" data-ad-id="{{ $ad->id }}" class="delete-ad-btn"><img src="img/ic-delete.png"></a></td>
                                        <td><a href="#"><img src="img/ic-edit.png"></a></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div role="tabpanel" class="tab-pane" id="tab-chat-history">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="users box">
                                    <h3 class="title">users</h3>
                                    <ul class="nicescroll nav nav-tabs" role="tablist">
                                        @if(isset($contactedUsers))
                                        @foreach($contactedUsers as $idx => $contactedUser)
                                        <li role="presentation" class="{{ $idx==0?'active':'' }}"><a href="#chat-{{ $contactedUser->id }}" role="tab" data-toggle="tab">
                                        <!-- <span class="date">12/04/15</span> -->
                                        {{ $contactedUser->anonymous_email }}</a></li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="box chats">
                                    <h3 class="title">chats</h3>
                                    <div class="tab-content">
                                    @if(isset($contactedUsers))
                                        @foreach($contactedUsers as $idx => $contactedUser)
                                        <ul class="nicescroll tab-pane {{ $idx==0?'active':'' }}" role="tabpanel" id="chat-{{ $contactedUser->id }}">
                                            @if(isset($contactedUser->messages))
                                            @foreach($contactedUser->messages as $msg)
                                            <?php 
                                                $isMe = false;
                                                if(auth()->user()->id == $msg->sender_id) {
                                                    $isMe = true;
                                                }
                                            ?>
                                            <li class="{{ $isMe?'me':'' }}">
                                                <span class="name">{{ $isMe?'You':explode('@',$contactedUser->anonymous_email)[0] }}</span>
                                                <div class="message">
                                                    {{ $msg->message }}
                                                    <span class="time">{{ $msg->created_at }}</span>
                                                </div>
                                            </li>
                                            @endforeach
                                            @endif
                                        </ul>
                                        @endforeach
                                    @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab-contact">
                        <div class="row">
                            <div class="col-md-12">
                                @include('inc.msg')

                                <div class="box">
                                    <form action="" method="post">
                                        <button type="submit" class="green-gradient">SAVE</button>
                                        <h3 class="title">contact info</h3>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Your contact Email*</label>
                                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Community Name</label>
                                                    <input type="text" name="community_name" value="{{ $user->community_name }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">State or Province</label>
                                                    <input type="text" name="state" value="{{ $user->state }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    @if(auth()->user()->type == 'seller')
                                                        <label for="">Drag marker around to select your Store location (<i>this will be use to target your ads to the right Seeker</i>)</label>
                                                    @else
                                                        <label for="">Drag marker around to select your location (<i>this will be use to display nearest Store</i>)</label>
                                                    @endif
                                                    <div id="map"></div>
                                                    <input type="hidden" name="lat" value="{{ $user->lat }}">
                                                    <input type="hidden" name="lng" value="{{ $user->lng }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Zip code</label>
                                                    <input type="text" name="zipcode" value="{{ $user->zipcode }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Country</label>
                                                    @include('inc.country_select')
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <div class="row">
                                            @if(auth()->user()->type == 'seeker')
                                            <div class="form-group circle-checkboxes col-md-12">
                                                <input type="checkbox" name="purpose[]" id="use_for_1" {{ in_array('medical',$user->purpose)?'checked':'' }} value="medical" name="use_for[]">
                                                <label for="use_for_1">Medical</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_2" {{ in_array('grower',$user->purpose)?'checked':'' }} value="grower" name="use_for[]">
                                                <label for="use_for_2">Grower</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_3" {{ in_array('doctor',$user->purpose)?'checked':'' }} value="doctor" name="use_for[]">
                                                <label for="use_for_3">Doctor</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_4" {{ in_array('adult_use',$user->purpose)?'checked':'' }} value="adult_use" name="use_for[]">
                                                <label for="use_for_4">Adult use</label>
                                            </div>
                                            @else
                                            <div class="form-group col-md-12">
                                                <div class="circle-checkboxes">
                                                    <input type="checkbox" name="purpose[]" id="use_for_1" {{ in_array('grower', $user->purpose)?'checked':'' }} value="grower" name="use_for[]">
                                                    <label for="use_for_1">Grower</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_2" {{ in_array('doctor', $user->purpose)?'checked':'' }} value="doctor" name="use_for[]">
                                                    <label for="use_for_2">Doctor</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_3" {{ in_array('dispensary', $user->purpose)?'checked':'' }} value="dispensary" name="use_for[]">
                                                    <label for="use_for_3">Dispensary</label>
                                                </div>

                                                <div class="circle-checkboxes">
                                                    <input type="checkbox" name="purpose[]" id="use_for_5" {{ in_array('wholesaler', $user->purpose)?'checked':'' }} value="wholesaler" name="use_for[]">
                                                    <label for="use_for_5">Wholesaler</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_6" {{ in_array('lab', $user->purpose)?'checked':'' }} value="lab" name="use_for[]">
                                                    <label for="use_for_6">Lab</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_7" {{ in_array('manufacturer', $user->purpose)?'checked':'' }} value="manufacturer" name="use_for[]">
                                                    <label for="use_for_7">Manufacturer</label>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        @if(auth()->user()->type == 'seller')
                                        <h3 class="title">PAYMENTS ACCEPTED VIA</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="" class="text-center">Separate payment types with a comma ex: (Cash, Walmart 2 Walmart, Bitcoin etc)</label>
                                                    <input type="text" value="{{ $user->accepted_payment }}" class="form-control" name="accepted_payment">
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
<script>
(function() {
    var defaultLocation = { lat: 36.228300, lng: -119.494996 };
    var $latInput = $('[name=lat]');
    var $lngInput = $('[name=lng]');
    if($latInput.val()) { defaultLocation.lat = $latInput.val(); }
    if($lngInput.val()) { defaultLocation.lng = $lngInput.val(); }
    var map = new GMaps({
        el: '#map',
        lat: defaultLocation.lat,
        lng: defaultLocation.lng,
        zoom: 5
    });
    var marker = map.addMarker({
        lat: defaultLocation.lat,
        lng: defaultLocation.lng,
        draggable: true,
        dragend: function () {
            var lat = this.getPosition().lat(),
                lng = this.getPosition().lng();
            $('[name=lat]').val(lat);
            $('[name=lng]').val(lng);
        }
    });

    // Delete ad clicked
    $('.delete-ad-btn').click(function(event) {
        deleteAd($(this).data('ad-id'));
    });

    function deleteAd(id) {
        if (confirm("Are you sure?")) {
            Mjex.showLoading();
            $.ajax({
                url: '{{ route("ad.destroy") }}',
                type: 'POST',
                data: { id: id }
            })
            .done(function(res) {
                console.log(res);
                if (res == 'ok') {
                    $('[data-ad-id=' + id + ']').parents('tr').remove();
                }
            })
            .fail(function() {
                console.log("deleteAd error");
            })
            .always(function() {
                Mjex.showLoading(false);
            });
        }
    }
})();

</script>
@endsection