<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Account Activation</title>
    <meta name="description" content="">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,900,700italic,700' rel='stylesheet' type='text/css'>
</head>

<body style="font-family: sans-serif;">
    <span style="
    font-size: 13px;
    color: #999999;
    margin-left: 15px;
    margin: 0; padding: 0;
">Can't see this Email? View it in your <a style="color: black; text-decoration: none;" href="{{ url('email-template/grower-request') }}?id={{ $seeker->id }}&grower_id={{ $grower->id }}">Browser</a></span>
    <div style="background: #282828;width: 100%;height: 50px;margin-top: 10px; margin-bottom: 20px;">
        <img style="height: 18px;margin-top: 17px;margin-left: 15px;" src="{{ url('img/email/logo.png') }}" alt="MJex Marijuana Exchange">
    </div>
    <img style="width: 100%; border-radius: 4px;" src="{{ url('img/email/grower-request/banner.jpg') }}" alt="Connecting Seekers & Seller Anonymously">
    <h1 style="font-family: 'Roboto', sans-serif; font-size: 25px; text-align: center;">You have received a new grower request!</h1>
    <p style="font-size: 14px; color: #999999; line-height: 22px;">You have received a request to grow from {{ $seeker->community_name }}@mjex.co
        You can respond with an email by clicking the Send Email button below.
        This will take you back to the  website, where you can fill out an email and send it using your anonymous email.
        Or paste the above email address into an email using an account of your own.</p>

    <a href="{{ url('cart') . '?seller_id=' . $grower->id }}#messages" style="
    color: white;
    background: #4bff4b;
    text-decoration: none;
    width: 160px;
    height: 33px;
    border-radius: 3px;
    margin: 0 auto;
    display: block;
    text-align: center;
    line-height: 33px;
    margin-bottom: 20px;
    ">
        Send Email
    </a>
    <footer style="background: black;height: 50px; border-top: 3px solid #007f00; width: 100%; color: white;">
        <span style="
    font-size: 12px;
    width: 50%;
    display: inline-block;
    margin-top: 10px;
    margin-left: 10px;
    color: #999;">We post all of our website updates on Social Media. Follow us to stay informed.</span>
        <a href=""><img style="float: right; margin-right: 10px; margin-top: 10px;" src="{{ url('img/email/gplus.png') }}" alt="google plus"></a>
        <a href=""><img style="float: right; margin-right: 10px; margin-top: 10px;" src="{{ url('img/email/youtube.png') }}" alt="youtube"></a>
        <a href=""><img style="float: right; margin-right: 10px; margin-top: 10px;" src="{{ url('img/email/twitter.png') }}" alt="twitter"></a>
        <a href=""><img style="float: right; margin-right: 10px; margin-top: 10px;" src="{{ url('img/email/facebook.png') }}" alt="facebook"></a>
    </footer>
</body>

</html>