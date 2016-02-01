@extends('master')

@section('main')
    <section id="Signup" class="container">
        <div class="row">
            <div class="col-md-12">
                @include('inc.msg')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="block seeker">
                    <h3 class="title">SIGN IN</h3>
                    <form action="{{ url('signin') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="">Email*</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password*</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn green-gradient">SIGN IN</button>
                        <br>
                        <span style="text-align: center; display: block;">Don't have account?</span>
                        <a href="{{ url('register') }}" class="btn btn-default">SIGN UP</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection