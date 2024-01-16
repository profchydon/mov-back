<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>@yield('title')</title>
</head>

<body style="background-color: #E5E5E5; padding-top: 40px; padding-bottom: 10px;">
    <div style="box-sizing: border-box;max-width: 570px;width: 100%; margin: 0 auto; padding: 1.3rem; margin-bottom: 2.5rem; background-color: #FFF;">
        <div style="margin-bottom: 3rem; width: 100%">
            <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/rayda.png" style="width: 60px" alt="Bidda logo">
            <div style="width: 25%; float: right;">
                <a href="https://www.facebook.com/biddahq/" style="text-decoration: none;" target="_blank"><img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/facebook.png" alt=""></a>
                <a href="https://www.instagram.com/biddahq/" target="_blank"><img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/instagram.png" alt=""></a>
                <a href="https://www.twitter.com/biddahq" target="_blank"><img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/twitter.png" alt=""></a>
                <a href="https://www.linkedin.com/company/bidda/" target="_blank"><img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/linkedin.png" alt=""></a>
            </div>
        </div>
        @yield('content')

        <!-- <p style="margin-top: 3rem; font-family: 'IBM Plex Sans', sans-serif; color: #404968;">This email was sent from <a href="mailto:rayda@gmail.com" target="_blank">rayda@gmail.com</a>. If you'd rather not receive this kind of email, Don’t want any more emails from Rayda? <a href="">Unsubscribe</a>.</p> -->
        <p style="margin-top: 3rem; font-family: 'IBM Plex Sans', sans-serif; color: #404968;">1007 N Orange St. 4th Floor Suite #901Wilmington, Delaware, United States</p>
        <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">© {{date('Y')}} Rayda Core
        </p>
    </div>
</body>

</html>
