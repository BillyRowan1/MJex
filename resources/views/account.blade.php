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
                            <th>sold</th>
                            </thead>
                            <tbody>
                                @if(isset($orders)&& (!empty($orders)))
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>12/24/2015</td>
                                        <td>{{ $order->unit_desc }}</td>
                                        <td>{{ $order->amount }}</td>
                                        <td>0</td>
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
                                        <td><a href="#" data-ad-id="{{ $ad->id }}" onclick="deleteAd({{ $ad->id }})"><img src="img/ic-delete.png"></a></td>
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
                                                <input type="checkbox" name="purpose[]" id="use_for_1" value="Medical" name="use_for[]">
                                                <label for="use_for_1">Medical</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_2" value="Grower" name="use_for[]">
                                                <label for="use_for_2">Grower</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_3" value="Doctor" name="use_for[]">
                                                <label for="use_for_3">Doctor</label>

                                                <input type="checkbox" name="purpose[]" id="use_for_4" value="Adult use" name="use_for[]">
                                                <label for="use_for_4">Adult use</label>
                                            </div>
                                            @else
                                            <div class="form-group col-md-12">
                                                <div class="circle-checkboxes">
                                                    <input type="checkbox" name="purpose[]" id="use_for_1" value="Medical" name="use_for[]">
                                                    <label for="use_for_1">Grower</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_2" value="Grower" name="use_for[]">
                                                    <label for="use_for_2">Doctor</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_3" value="Doctor" name="use_for[]">
                                                    <label for="use_for_3">Dispensary</label>
                                                </div>

                                                <div class="circle-checkboxes">
                                                    <input type="checkbox" name="purpose[]" id="use_for_4" value="Adult use" name="use_for[]">
                                                    <label for="use_for_4">Wholesaler</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_4" value="Adult use" name="use_for[]">
                                                    <label for="use_for_4">Lab</label>

                                                    <input type="checkbox" name="purpose[]" id="use_for_4" value="Adult use" name="use_for[]">
                                                    <label for="use_for_4">Manufacturer</label>
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
        function deleteAd(id, ele) {
            if (confirm("Are you sure?")) {
                Mjex.showLoading();
                $.ajax({
                    url: '{{ route("ad.destroy") }}',
                    type: 'POST',
                    data: {id: id}
                })
                .done(function(res) {
                    console.log(res);
                    if(status == 'ok') {
                        $('[data-ad-id='+id+']').parents('tr').remove();
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
    </script>
@endsection