@extends('admin.master')

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
                    <h3 class="title">Administrator Portal</h3>
                    <form action="{{ url('mjexadmin/auth/login') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="">Username*</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password*</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn green-gradient">SIGN IN</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection