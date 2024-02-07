<!DOCTYPE html>
<html lang="en">

    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <title>@yield('title')</title>
    <style>
        footer ul {
            display: flex;
            justify-content: center !important;
            padding: 0;
        }

        footer ul li {
            margin: 0 10px;
            list-style-type: none;
        }
    </style>
    </head>

    <body style="background-color: #f9f9f9; padding-top: 40px; padding-bottom: 10px;">

        <div
          style="box-sizing: border-box;max-width: 570px;width: 100%; margin: 0 auto; margin-bottom: 2.5rem; background-color: #FFF; padding-bottom: 0px;">
          <div style="margin-bottom: 15px; width: 100%; padding: 20px 30px 0px 30px;">
            <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/rayda.png" style="width: 90px"
              alt="Rayda logo">
          </div>

          @yield('content')

          <footer style="background:#f1f1f1; width: auto; color: #fff; padding: 30px; text-align: center;">
            <!-- <div style="display: flex; justify-content: center; padding: 0px; list-style-type: none; text-align: center;">
              <span style="margin: 0px 10px;">
                <a href="https://twitter.com/therayda">
                  <img style="width: 35px;"
                    src="https://s3.amazonaws.com/rayda.co/images+for+email+template/socials/Filled-Social-Link.png" alt="" />
                </a>
              </span>
              <span style="margin: 0px 10px;">
                <a href="https://twitter.com/therayda">
                  <img style="width: 35px;"
                    src="https://s3.amazonaws.com/rayda.co/images+for+email+template/socials/Filled-Social-Youtube.png"
                    alt="" />
                </a>
              </span>
              <span style="margin: 0px 10px;">
                <a href="https://twitter.com/therayda">
                  <img style="width: 35px;"
                    src="https://s3.amazonaws.com/rayda.co/images+for+email+template/socials/Filled-Social-Instagram.png.png"
                    alt="" />
                </a>
              </span>
              <span style="margin: 0px 10px;">
                <a href="https://twitter.com/therayda">
                  <img style="width: 35px;"
                    src="https://s3.amazonaws.com/rayda.co/images+for+email+template/socials/Filled-Social-Twitter.png.png"
                    alt="" />
                </a>
              </span>
              <span style="margin: 0px 10px;">
                <a href="https://www.facebook.com/myraydaHQ/">
                  <img style="width: 35px;"
                    src="https://s3.amazonaws.com/rayda.co/images+for+email+template/socials/Filled-Social-Facebook.png.png"
                    alt="" />
                </a>
              </span>
            </div> -->
            <div>
              <p style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; text-align: center;" ">
                1007 N Orange St. 4th Floor
                Suite #901Wilmington, Delaware, United States
              </p>
              <a href=" https://rayda.co/policies"
                style="text-decoration-line: underline; cursor: pointer; font-size: 14px; line-height: 24px; color: #939393; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; text-align: center;">
                Privacy</a>
                <a href="https://portal.rayda.co"
                  style="text-decoration-line: underline; cursor: pointer; font-size: 14px; line-height: 24px; color: #939393; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; text-align: center;">Account</a>
            </div>
            <div style="margin-top: 10px;">
              <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/logo2.png" alt="" />
            </div>
          </footer>
        </div>
      </body>

</html>
