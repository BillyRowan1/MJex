@extends('master')

@section('main')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Write a review: Order #{{ $orderId }}</div>

                    <div class="panel-body">
                        @include('inc.msg')
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('review.store') }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <textarea rows="5" class="form-control" name="content"></textarea>
                                <input type="hidden" name="order_id" value="{{ $orderId }}">
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-refresh"></i>Send
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection