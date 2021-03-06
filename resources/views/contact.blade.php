@extends('master')

@section('main')
    <section id="Contact" class="container">
        <h1 class="title">Contact us with any issues:</h1>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                @include('inc.msg')
                <form action="{{ route('contact') }}" method="post" class="form-inline">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="">Name*</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Email*</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Subject*</label>
                        <input type="text" name="subject" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Message*</label>
                        <textarea name="message" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <button class="btn green-gradient" type="submit">SEND</button>
                </form>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="contact-box">
                    <h3><span class="green-text">Contact</span> info</h3>
                    <p>MJex.co <br>Street No.1234, <br>Portland, Oregon <br>USA</p>
                    <ul>
                        <li class="mail">contact@mjex.co</li>
                    </ul>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d130793.19693876604!2d-122.65184357678962!3d45.531102473192874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1453229155156" width="100%" height="280" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </section>
@endsection