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
                            @if(auth()->user()->type == 'seller')
                            <th>request feedback</th>
                            @endif
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
                                        @if(auth()->user()->type == 'seller')
                                            <th><button data-seeker_id="{{ $order->seeker_id }}" data-seller_id="{{ $order->seller_id }}" title="by pressing this button a message will be send to this seeker" class="requestFeedbackBtn btn green-gradient">Request</button></th>
                                        @endif
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
                                        <?php $expired = $ad->expired_date<strtotime('now')?true:false; ?>
                                    <tr class="{{ $expired?'expired':'' }}">
                                        <td>{{ $ad->id }}</td>
                                        <td>{{ $ad->created_at }}</td>
                                        <td>{{ $ad->unit_available }}</td>
                                        <td>{{ $ad->price_per_unit }}</td>
                                        <td>{{ $ad->type_of_product }}</td>
                                        <td>
                                            @if($expired)
                                            <a href="#" data-ad-id="{{ $ad->id }}" class="repost-btn"><img src="img/ic-repost.png" alt=""></a>
                                            @endif
                                        </td>
                                        <td><a href="#" data-ad-id="{{ $ad->id }}" class="delete-ad-btn"><img src="img/ic-delete.png"></a></td>
                                        <td><a href="{{ route('ad.edit') }}?id={{ $ad->id }}"><img src="img/ic-edit.png"></a></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div role="tabpanel" class="tab-pane" id="tab-chat-history">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="users box">
                                    <h3 class="title">users</h3>
                                    <ul class="nicescroll nav nav-tabs" role="tablist">
                                        @if(isset($contactedUsers))
                                        @foreach($contactedUsers as $idx => $contactedUser)
                                        <li data-user-id="{{ $contactedUser->id }}" role="presentation" class="{{ $idx==0?'active':'' }}"><a href="#chat-{{ $contactedUser->id }}" role="tab" data-toggle="tab">
                                        <!-- <span class="date">12/04/15</span> -->
                                        {{ $contactedUser->anonymous_email }}</a></li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8">
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
                                                        {!! $msg->message !!}
                                                        <span class="time">{{ $msg->created_at }}</span>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>                                        
                                            @endforeach

                                        @if(count($contactedUsers)>0)
                                        <div id="chat-message-wrap">
                                            <input type="text" class="form-control" name="chat-message" placeholder="Enter your message">
                                            <button id="sendChatBtn" class="btn btn-default">Send</button>
                                        </div>
                                        @endif
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
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <button type="submit" class="green-gradient">SAVE</button>
                                        <h3 class="title">contact info</h3>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Your Mjex Email*</label> (<i>Note: only use in Mjex system</i>)
                                                    <input type="email" name="anonymous_email" value="{{ $user->anonymous_email }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Mjex username</label>
                                                    <input type="text" readonly name="community_name" value="{{ $user->community_name }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">City / State</label>
                                                    <input type="text" name="state" value="{{ $user->state }}" class="form-control">
                                                </div>

                                                @if($user->type != 'seeker')
                                                <div class="form-group">
                                                    <label for="">Delivery</label>
                                                    {!! Form::select('delivery', [1=>'Yes',0 =>'No'], $user->delivery, ['class'=>'form-control']) !!}
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Logo</label>
                                                    {!! Form::file('logo') !!}
                                                    @if(!empty($user->logo))
                                                    <img src="{{ $user->logo }}" width="100px">
                                                    @endif
                                                </div>
                                                @endif

                                            </div>
                                            <div class="col-md-6 col-sm-6">
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
                                                @if(has_purpose('grower', $user) && $user->type == 'seller')
                                                <div class="form-group">
                                                    <label for="">Number of patients available</label>
                                                    {!! Form::select('patients_available',[1,2,3,4,5], $user->patients_available,['class'=>'form-control']) !!}
                                                </div>
                                                @endif

                                                @if($user->type == 'seeker' && has_purpose('medical', $user))

                                                    <label for="">Medical card number</label>
                                                    <input type="text" name="medical_card_number" value="{{ $user->medical_card_number }}" class="form-control">
                                                    <br>
                                                    <label for="">Disired alotment</label>
                                                    <input type="text" name="desired_alotment" value="{{ $user->desired_alotment }}" class="form-control">
                                                @endif

                                                <div class="form-group">
                                                    @if(auth()->user()->type == 'seller')
                                                    <label for="">Drag marker around to select your Store location</label>
                                                    <div id="map"></div>
                                                    <input type="hidden" name="lat" value="{{ $user->lat }}">
                                                    <input type="hidden" name="lng" value="{{ $user->lng }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                        <div class="row">

                                            <div class="form-group circle-checkboxes col-md-12">
                                                <input type="checkbox" name="purpose[]" id="use_for_4" {{ has_purpose('adult_use',$user)?'checked':'' }} value="adult_use" name="use_for[]">
                                                <label for="use_for_4">Adult use +21</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_1" {{ has_purpose('medical',$user)?'checked':'' }} value="medical" name="use_for[]">
                                                <label for="use_for_1">Medical</label>

                                                @if(auth()->user()->type == 'seller')

                                                <input type="checkbox" name="purpose[]" id="use_for_2" {{ has_purpose('grower',$user)?'checked':'' }} value="grower" name="use_for[]">
                                                <label for="use_for_2">Grower</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_3" {{ has_purpose('other',$user)?'checked':'' }} value="other" name="use_for[]">
                                                <label for="use_for_3">Other business</label>

                                                @endif
                                            </div>

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
jQuery(document).ready(function($) {
    $('.requestFeedbackBtn').click(function() {
        var seeker_id = $(this).data('seeker_id'),
            seller_id = $(this).data('seller_id'),
            message = 'Can you leave a feedback on my seller page: <a href="{{ url('cart') }}?seller_id='+ seller_id + '">{{ url('cart') }}?seller_id='+ seller_id + '</a>';

        console.log(message)
        Mjex.showLoading(true);
            $.ajax({
                url: '{{ route("chat.store") }}',
                type: 'POST',
                data: {
                    message: message,
                    seller_id: seller_id,
                    seeker_id: seeker_id
                }
            }).done(function(res) {
                console.log(res);
                if(res.status == 'ok') {
                    alert('Your request was sent to this seeker');
                    Chat.addMessage(message);
                }
            }).always(function() {
                Mjex.showLoading(false);
            });
    });
});
var Chat = (function () {
    $('#sendChatBtn').click(function(event) {
        var message = $('[name=chat-message]').val();
        var chatWithUser = $('#Account #tab-chat-history .users li.active').data('user-id');
        if(message != '') {
            Mjex.showLoading(true);
            $.ajax({
                url: '{{ route("chat.store") }}',
                type: 'POST',
                data: {
                    message: message,
                    {{ auth()->user()->type }}_id: {{ auth()->user()->id }},
                    {{ auth()->user()->type=='seeker'?'seller':'seeker'}}_id: chatWithUser
                }
            }).done(function(res) {
                console.log(res);
                if(res.status == 'ok') {
                    addMessage(message);
                    $('#tab-chat [name=message]').val('');
                }
            }).always(function() {
                Mjex.showLoading(false);
            });
                
        }else{
            alert('Please enter message');
        }
    });

    function addMessage(message) {
        var item = '<li class="me"><span class="name">You</span><div class="message">'+message+'<span class="time">just now</span></div></li>';
        
        $('#tab-chat-history .nicescroll.active').prepend(item);
    }

    return {
        addMessage: addMessage
    }
})();
(function() {
    var defaultLocation = { lat: 36.228300, lng: -119.494996 };
    getLocation();
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
    function showPosition(position) {
        defaultLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        }
        initMap();
    }
    
    function initMap() {
        var $latInput = $('[name=lat]');
        var $lngInput = $('[name=lng]');
        if($latInput.val()) { 
            defaultLocation.lat = $latInput.val(); 
        }else{
            $latInput.val(defaultLocation.lat);
        }
        if($lngInput.val()) { 
            defaultLocation.lng = $lngInput.val();
        }else{
            $lngInput.val(defaultLocation.lng);
        }
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
    }

    // Delete ad clicked
    $('.delete-ad-btn').click(function(event) {
        deleteAd($(this).data('ad-id'));
    });

    // Repost ad clicked
    $('.repost-btn').click(function(event) {
        event.preventDefault();
        repostAd($(this).data('ad-id'));
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

    function repostAd(id) {
        $.ajax({
            url: '{{ route("ad.repost") }}',
            type: 'POST',
            data: {id: id},
        })
        .done(function() {
            $('a[data-ad-id='+id+']').parents('tr').removeClass('expired');
            alert('Ad reposted');
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    }
})();

</script>
@endsection