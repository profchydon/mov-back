<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <title>@yield('title')</title>
    <style>
      @media screen and (max-width: 768px) {
        .otp {
          width: 100% !important;
        }
      }
    </style>
  </head>

  <body
    style="background-color: #f9f9f9; padding-top: 40px; padding-bottom: 10px"
  >
    <div
      style="
        box-sizing: border-box;
        max-width: 570px;
        width: 100%;
        margin: 0 auto;
        margin-bottom: 2.5rem;
        background-color: #fff;
        padding-bottom: 0px;
      "
    >
      <div
        style="
          margin-bottom: 15px;
          width: auto;
          padding: 30px 30px 15px 30px;
          text-align: center;
        "
      >
        <img
          src="https://s3.amazonaws.com/rayda.co/images+for+email+template/rayda.png"
          style="max-width: 60%; height: auto; display: block; margin: 0 auto"
          alt="Rayda logo"
        />
      </div>

      <div
        style="
          background: linear-gradient(
            180deg,
            rgba(72, 144, 252, 0.25) 4.19%,
            rgba(255, 255, 255, 0) 40.4%
          );
        "
      >
        <div style="height: 250px">
          <img src="assets/email-snapshot.png" style="width: 570px" alt="" />
        </div>

        <div style="padding: 32px 24px 32px 24px">
          <div style="margin-bottom: 3.125rem">
            <div
              style="
                font-family: IBM Plex Sans;
                font-size: 38px;
                font-weight: 400;
                line-height: 48px;
                text-align: left;
              "
            >
              How are your assets looking this week? 🚨
            </div>

            <div>
              <p
                style="
                  font-family: IBM Plex Sans;
                  font-size: 16px;
                  font-weight: 400;
                  line-height: 24px;
                  text-align: left;
                "
              >
                Hi {Name},
              </p>

              <p
                style="
                  font-family: IBM Plex Sans;
                  font-size: 16px;
                  font-weight: 400;
                  line-height: 24px;
                  text-align: left;
                "
              >
                Here is an overview of your asset’s progress in
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 700;
                    line-height: 24px;
                    text-align: left;
                  "
                  >{{$company->name}}</span
                >
                for the week.
              </p>
            </div>
          </div>

          <div>
            <p
              style="
                font-family: IBM Plex Sans;
                font-size: 18px;
                font-weight: 600;
                line-height: 28px;
                text-align: left;
              "
            >
              Report Overview
            </p>

            <div
              style="
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 16px;
              "
              class=""
            >
              <div
                style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                "
              >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 20px;
                    text-align: left;
                    color: rgba(0, 76, 204, 1);
                    display: block;
                  "
                  >Asset Value</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 36px;
                    font-weight: 500;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{$report->totalAssetValue}}</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: left;
                    display: block;
                    color: rgba(0, 76, 204, 1);
                  "
                  >{{$report->totalAsset}} Assets</span
                >
              </div>

              <div
                style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                "
              >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 20px;
                    text-align: left;
                    color: rgba(0, 76, 204, 1);
                    display: block;
                  "
                  >Asset added this week</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 36px;
                    font-weight: 500;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{$report->totalAssetAddedValue}}</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: left;
                    display: block;
                    color: rgba(0, 76, 204, 1);
                  "
                  >{{$report->totalAssetAdded }} Assets</span
                >
              </div>

              <div
                style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                "
              >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 20px;
                    text-align: left;
                    color: rgba(0, 76, 204, 1);
                    display: block;
                  "
                  >Total Insured Assets</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 36px;
                    font-weight: 700;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                  "
                  >₦ {{$report->totalInsuredAssetValue}}</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: left;
                    display: block;
                    color: rgba(0, 76, 204, 1);
                  "
                  >{{$report->totalInsuredAsset }} Assets</span
                >
              </div>

              <div
                style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                "
              >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 20px;
                    text-align: left;
                    color: rgba(0, 76, 204, 1);
                    display: block;
                  "
                  >Total Uninsured Assets</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 36px;
                    font-weight: 700;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                  "
                  >₦ {{$report->totalUnInsuredAssetValue }}</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: left;
                    display: block;
                    color: rgba(0, 76, 204, 1);
                  "
                  >{{$report->totalUnInsuredAsset }} Assets</span
                >
              </div>

              <div
                style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                "
              >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 20px;
                    text-align: left;
                    color: rgba(0, 76, 204, 1);
                    display: block;
                  "
                  >Assets due for maintenance</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 36px;
                    font-weight: 700;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                  "
                  >₦ {{$report->totalAssetDueMaintenanceValue }}
                </span>
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: left;
                    display: block;
                    color: rgba(0, 76, 204, 1);
                  "
                  >{{$report->totalAssetDueMaintenance}} Assets</span
                >
              </div>

              <div
                style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                "
              >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 20px;
                    text-align: left;
                    color: rgba(0, 76, 204, 1);
                    display: block;
                  "
                  >Checked-out assets</span
                >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 36px;
                    font-weight: 700;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                  "
                  >₦ {{$report->totalCheckedOutAssetValue }}
                </span>
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: left;
                    display: block;
                    color: rgba(0, 76, 204, 1);
                  "
                  >{{$report->totalCheckedOutAsset }} Assets</span
                >
              </div>
            </div>

            <div style="margin-top: 30px; margin-bottom: 30px">
              <button
                style="
                  background: rgba(0, 76, 204, 1);
                  width: 100%;
                  cursor: pointer;
                  padding: 12px 20px 12px 20px;
                  gap: 8px;
                  border-radius: 8px;
                  border: 1px 0px 0px 0px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                "
              >
                <span
                  style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 600;
                    line-height: 24px;
                    text-align: left;
                    color: rgba(255, 255, 255, 1);
                  "
                  >View full report</span
                >
              </button>
            </div>

            <div
              style="
                font-family: IBM Plex Sans;
                font-size: 16px;
                font-weight: 400;
                line-height: 24px;
                text-align: left;
              "
            >
              <span style="display: block">Thanks,</span>
              <span style="display: block">Rayda’s Team</span>
            </div>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <div style="background: rgba(241, 241, 241, 1); padding: 34px">
        <div style="display: grid; place-content: center; margin-bottom: 16px">
          <div style="display: flex; gap: 12px">
            <img src="assets/socials/Filled-Social-Link.png" alt="linkedin" />
            <img src="assets/socials/Filled-Social-Youtube.png" alt="youtube" />
            <img
              src="assets/socials/Filled-Social-Instagram.png.png"
              alt="instagram"
            />
            <img
              src="assets/socials/Filled-Social-Twitter.png.png"
              alt="twitter"
            />
            <img
              src="assets/socials/Filled-Social-Facebook.png.png"
              alt="twitter"
            />
          </div>
        </div>

        <div style="margin-bottom: 12px">
          <span
            style="
              font-family: IBM Plex Sans;
              font-size: 16px;
              font-weight: 300;
              line-height: 26.32px;
              letter-spacing: -0.02em;
              text-align: center;
              display: block;
            "
          >
            Don't want to receive emails from Rayda?
          </span>
          <span
            style="
              font-family: IBM Plex Sans;
              font-size: 16px;
              font-weight: 300;
              line-height: 26.32px;
              letter-spacing: -0.02em;
              text-align: center;
              display: block;
            "
          >
            unsubscribe
          </span>
          <span
            style="
              font-family: IBM Plex Sans;
              font-size: 16px;
              font-weight: 300;
              line-height: 26.32px;
              letter-spacing: -0.02em;
              text-align: center;
              display: block;
            "
          >
            1007 N Orange St. 4th Floor Suite #901Wilmington, Delaware, United
          </span>
          <span
            style="
              font-family: IBM Plex Sans;
              font-size: 16px;
              font-weight: 300;
              line-height: 26.32px;
              letter-spacing: -0.02em;
              text-align: center;
              display: block;
            "
          >
            States© 2022 Rayda
          </span>
        </div>

        <div style="display: grid; place-content: center">
          <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/logo2.png" alt="" />
        </div>
      </div>
    </div>
  </body>
</html>
