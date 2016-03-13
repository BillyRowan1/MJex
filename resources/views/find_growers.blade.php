@extends('master')
@section('main')
    <section id="FindGrowers" class="container page">
        <div class="row">
            <header>
                <div class="col-md-12">
                    <h3 class="title">Welcome to the find a grower page</h3>
                    @if(!auth()->user() || auth()->user()->type!="seller" || !in_array('grower',json_decode(auth()->user()->purpose)))
                        <a href="{{ url('register') }}" class="btn green-gradient">REGISTER AS A GROWER</a>
                    @endif
                    <hr>
                </div>
            </header>

            <div class="col-md-12">
                @include('inc.search')
                @include('inc.msg')

                <p>Patient to Grower Connection</p>
                <p>MJex understands that not all OMMP patients are able or willing to grow their own medication. We are continuously
                    approached about connecting new patients to growers so we would like to offer our Patient to Grower Connection. If
                    you are an OMMP card holder and need a reputable and dependable grower just fill out the form below and someone
                    from MJex will contact you and get you connected!
                    Privacy – ALL information is kept private and confidential. MJex does not sell or
                    distribute your information in any way for any reason.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="{{ route('find-growers') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" name="subject" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Your Name (required)	</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Your Email (required)</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Your Message</label>
                        <textarea name="message" rows="10" class="form-control"></textarea>
                    </div>
                    <button class="btn green-gradient" type="submit">SEND</button>
                </form>
            </div>
        </div>
    </section>
@endsection