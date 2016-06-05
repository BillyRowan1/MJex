@extends('master')

@section('main')
    <div class="container" id="Dispensaries">
        <div class="col-md-10 col-md-offset-1">
            @foreach($data as $dis)
                <div class="row block">
                    <div class="col-md-3">
                        <img src="{{ $dis->image }}" style="width: 100%" alt="{{ $dis->name }}">
                    </div>
                    <div class="col-md-9">
                        <a href="{{ url('dispensaries/detail') }}/{{ $dis->slug }}"><h3>{{ $dis->name }}</h3></a>
                        <p><i class="icon-map-marker"></i> {{ $dis->address->address1 }}, {{ $dis->city }}, {{ $dis->state }}</p>
                    </div>
                </div>
            @endforeach

            @if(count($data))
                @if($nextPage - 2 > 0)
                <a href="{{ url('dispensaries') }}?page={{ $nextPage - 2 }}"><button class="btn green-gradient">Previous page</button></a>
                @endif
            <a href="{{ url('dispensaries') }}?page={{ $nextPage }}"><button class="btn green-gradient">Next page</button></a>
            @endif
        </div>
    </div>
@endsection