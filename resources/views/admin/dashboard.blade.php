@extends('admin.master')

@section('main')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2><span class="icon-user"></span> Registered Users</h2>
                </header>
                <table class="table table-striped border-top" id="sample_1">
                    <thead>
                    <tr>
                        <th>Anonymous username</th>
                        <th>Package</th>
                        <th>Email</th>
                        <th>Type/Purpose</th>
                        <th>City/State</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="odd gradeX">
                            <td>{{ $user->community_name }}@mjex.co</td>
                            <td>{{ $user->package }}</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td>{{ $user->type=='seeker'?'Seeker':implode(', ', json_decode($user->purpose)) }}</td>
                            <td>{{ $user->state }}{{ $user->country?', '.$user->country:'' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
@endsection