@extends('master')
@section('main')
    <section id="AdNetwork" class="container page">
        <div class="panel panel-default">
            <div class="panel-heading">
                Advertising
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Position</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Home header</strong>
                                <br>Size: 468 x 60</td>
                            <td>$30 for 1 month</td>
                            <td>
                                <button class="btn green-gradient">Buy</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Sidebar left</strong>
                                <br>Size: 290 x 100</td>
                            <td>$30 for 1 month</td>
                            <td>
                                <button class="btn green-gradient">Buy</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Sidebar right</strong>
                                <br>Size: 290 x 100</td>
                            <td>$30 for 1 month</td>
                            <td>
                                <button class="btn green-gradient">Buy</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection