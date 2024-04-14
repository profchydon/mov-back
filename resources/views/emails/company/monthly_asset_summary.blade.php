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
                    What how your assets are doing this month 🚨
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
                        Dear {Customer's Name},
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
                        We're pleased to present your monthly asset performance report
                        for
                        <span
                            style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 700;
                    line-height: 24px;
                    text-align: left;
                  "
                        >{{$company->name}}.</span
                        >
                        Our analysis covered 1,500 assets, providing a comprehensive
                        view of their current status and performance.
                    </p>
                </div>
            </div>

            <div>
                <div
                    style="
                padding: 20px;
                gap: 16px;
                border-radius: 8px;
                opacity: 0px;
                border: 1px solid rgba(0, 76, 204, 1);
                display: grid;
                place-content: center;
              "
                >
              <span
                  style="
                  font-family: IBM Plex Sans;
                  font-size: 16px;
                  font-weight: 600;
                  line-height: 24px;
                  text-align: center;
                "
              >Overall Score: {{$report->grade}}</span
              >
                    <div style="display: flex; gap: 6px">
                        <img src="assets/Silver.png" style="height: 89px" alt="" />
                        <span
                            style="
                    font-family: IBM Plex Sans;
                    font-size: 72px;
                    font-weight: 600;
                    line-height: 90px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    color: rgba(71, 84, 103, 1);
                  "
                        >{{$report->overallScore}}}}%</span
                        >
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
                        Asset Snapshot Score Overview
                    </p>

                    <div
                        style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                  margin-bottom: 25px;
                "
                    >
                        <table style="border-spacing: 8px">
                            <tr>
                                <th
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 14px;
                        font-weight: 500;
                        line-height: 20px;
                        text-align: left;
                        color: rgba(0, 76, 204, 1);
                      "
                                >
                                    Assets
                                </th>
                                <th
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 14px;
                        font-weight: 500;
                        line-height: 20px;
                        text-align: left;
                        color: rgba(0, 76, 204, 1);
                      "
                                >
                                    Units
                                </th>
                                <th
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 14px;
                        font-weight: 500;
                        line-height: 20px;
                        text-align: left;
                        color: rgba(0, 76, 204, 1);
                      "
                                >
                                    Bad
                                </th>
                                <th
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 14px;
                        font-weight: 500;
                        line-height: 20px;
                        text-align: left;
                        color: rgba(0, 76, 204, 1);
                      "
                                >
                                    Insured
                                </th>
                                <th
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 14px;
                        font-weight: 500;
                        line-height: 20px;
                        text-align: left;
                        color: rgba(0, 76, 204, 1);
                      "
                                >
                                    Needs maintenance
                                </th>
                                <th
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 14px;
                        font-weight: 500;
                        line-height: 20px;
                        text-align: left;
                        color: rgba(0, 76, 204, 1);
                      "
                                >
                                    Grade
                                </th>
                            </tr>

                            <tr>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    Computers & Equipment
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    10
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    0
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    10
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    0
                                </td>
                                <td>
                                    <div
                                        style="
                          width: 24px;
                          height: 24px;
                          padding: 5.19px 3.73px 5.19px 3.73px;
                          border-radius: 9999px;
                          opacity: 0px;
                          background: rgba(3, 152, 85, 1);
                          display: grid;
                          place-content: center;
                        "
                                    >
                        <span
                            style="
                            font-family: IBM Plex Sans;
                            font-size: 10.79px;
                            font-weight: 500;
                            line-height: 14.03px;
                            text-align: center;
                            color: rgba(255, 255, 255, 1);
                          "
                        >A</span
                        >
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    Computers & Equipment
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    10
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    0
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    10
                                </td>
                                <td
                                    style="
                        font-family: IBM Plex Sans;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 18px;
                        text-align: left;
                        color: rgba(85, 98, 117, 1);
                      "
                                >
                                    0
                                </td>
                                <td>
                                    <div
                                        style="
                          width: 24px;
                          height: 24px;
                          padding: 5.19px 3.73px 5.19px 3.73px;
                          border-radius: 9999px;
                          opacity: 0px;
                          background: rgba(3, 152, 85, 1);
                          display: grid;
                          place-content: center;
                        "
                                    >
                        <span
                            style="
                            font-family: IBM Plex Sans;
                            font-size: 10.79px;
                            font-weight: 500;
                            line-height: 14.03px;
                            text-align: center;
                            color: rgba(255, 255, 255, 1);
                          "
                        >A</span
                        >
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- <div
                      style="
                        padding: 20px;
                        gap: 16px;
                        border-radius: 8px;
                        opacity: 0px;
                        border: 1px solid rgba(0, 76, 204, 1);
                        margin-bottom: 25px;
                      "
                    >
                      <div style="height: 100px">
                        <canvas id="chartProgress"></canvas>
                      </div>
                    </div> -->

                    <div style="margin-bottom: 25px">
                        <div
                            style="
                    font-family: IBM Plex Sans;
                    font-size: 18px;
                    font-weight: 600;
                    line-height: 28px;
                    text-align: left;
                    color: rgba(56, 72, 96, 1);
                    margin-bottom: 4px;
                  "
                        >
                            Result Interpretation:
                        </div>

                        <div
                            style="
                    font-family: IBM Plex Sans;
                    font-size: 16px;
                    font-weight: 400;
                    line-height: 24px;
                    text-align: left;
                    color: rgba(56, 72, 96, 1);
                  "
                        >
                            Performance Grade Assignment :
                        </div>

                        <ul style="display: flex; flex-direction: column; gap: 12px">
                            <li
                                style="
                      font-family: IBM Plex Sans;
                      font-size: 16px;
                      font-weight: 400;
                      line-height: 24px;
                      text-align: left;
                      color: rgba(56, 72, 96, 1);
                    "
                            >
                                A: Asset exceeds expectations in all criteria.
                            </li>

                            <li
                                style="
                      font-family: IBM Plex Sans;
                      font-size: 16px;
                      font-weight: 400;
                      line-height: 24px;
                      text-align: left;
                      color: rgba(56, 72, 96, 1);
                    "
                            >
                                B: Asset meets expectations and may show moderate growth.
                            </li>

                            <li
                                style="
                      font-family: IBM Plex Sans;
                      font-size: 16px;
                      font-weight: 400;
                      line-height: 24px;
                      text-align: left;
                      color: rgba(56, 72, 96, 1);
                    "
                            >
                                C: Asset performance is satisfactory but does not
                                significantly outperform the market.
                            </li>

                            <li
                                style="
                      font-family: IBM Plex Sans;
                      font-size: 16px;
                      font-weight: 400;
                      line-height: 24px;
                      text-align: left;
                      color: rgba(56, 72, 96, 1);
                    "
                            >
                                D: Asset underperforms compared to market averages.
                            </li>

                            <li
                                style="
                      font-family: IBM Plex Sans;
                      font-size: 16px;
                      font-weight: 400;
                      line-height: 24px;
                      text-align: left;
                      color: rgba(56, 72, 96, 1);
                    "
                            >
                                E: The asset is performing poorly and shows a decline in
                                value.
                            </li>
                        </ul>
                    </div>

                    <div
                        style="
                  padding: 20px;
                  gap: 16px;
                  border-radius: 8px;
                  opacity: 0px;
                  border: 1px solid rgba(0, 76, 204, 1);
                  margin-bottom: 25px;
                "
                    >
                        <div
                            style="
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 12px;
                  "
                        >
                            <div style="display: flex; align-items: center; gap: 4px">
                                <img src="assets/clipboard-check.png" alt="" />
                                <span
                                    style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                        text-align: left;
                        color: rgba(55, 53, 47, 1);
                      "
                                >
                      Performance Grades
                    </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 4px">
                                <img src="assets/bar-chart-square-up.png" alt="" />
                                <span
                                    style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                        text-align: left;
                        color: rgba(55, 53, 47, 1);
                      "
                                >
                      Utilization Scores
                    </span>
                            </div>

                            <div style="display: flex; gap: 4px; align-items: center">
                                <div
                                    style="
                        width: 19px;
                        height: 19px;
                        padding: 2px 0px 0px 0px;
                        border-radius: 999999px;
                        background: rgba(3, 152, 85, 1);
                        display: grid;
                        place-content: center;
                      "
                                >
                      <span
                          style="
                          font-family: Inter;
                          font-size: 12px;
                          font-weight: 400;
                          line-height: 14.52px;
                          text-align: center;
                          color: rgba(255, 255, 255, 1);
                        "
                      >A</span
                      >
                                </div>

                                <span
                                    style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                      "
                                >
                      Excellent
                    </span>
                            </div>

                            <div>
                    <span
                        style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                        text-align: left;
                      "
                    >
                      75-85%: Optimum Usage
                    </span>
                            </div>

                            <div style="display: flex; gap: 4px; align-items: center">
                                <div
                                    style="
                        width: 19px;
                        height: 19px;
                        padding: 2px 0px 0px 0px;
                        border-radius: 999999px;
                        background: rgba(18, 183, 106, 1);
                        display: grid;
                        place-content: center;
                      "
                                >
                      <span
                          style="
                          font-family: Inter;
                          font-size: 12px;
                          font-weight: 400;
                          line-height: 14.52px;
                          text-align: center;
                          color: rgba(255, 255, 255, 1);
                        "
                      >B</span
                      >
                                </div>

                                <span
                                    style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                      "
                                >
                      Good
                    </span>
                            </div>

                            <div>
                    <span
                        style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                        text-align: left;
                      "
                    >
                      50-75%-Active
                    </span>
                            </div>

                            <div style="display: flex; gap: 4px; align-items: center">
                                <div
                                    style="
                        width: 19px;
                        height: 19px;
                        padding: 2px 0px 0px 0px;
                        border-radius: 999999px;
                        background: rgba(247, 144, 9, 1);
                        display: grid;
                        place-content: center;
                      "
                                >
                      <span
                          style="
                          font-family: Inter;
                          font-size: 12px;
                          font-weight: 400;
                          line-height: 14.52px;
                          text-align: center;
                          color: rgba(255, 255, 255, 1);
                        "
                      >C</span
                      >
                                </div>

                                <span
                                    style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                      "
                                >
                      Satisfactory
                    </span>
                            </div>

                            <div>
                    <span
                        style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                        text-align: left;
                      "
                    >
                      25-50%- Average
                    </span>
                            </div>

                            <div style="display: flex; gap: 4px; align-items: center">
                                <div
                                    style="
                        width: 19px;
                        height: 19px;
                        padding: 2px 0px 0px 0px;
                        border-radius: 999999px;
                        background: rgba(181, 71, 8, 1);
                        display: grid;
                        place-content: center;
                      "
                                >
                      <span
                          style="
                          font-family: Inter;
                          font-size: 12px;
                          font-weight: 400;
                          line-height: 14.52px;
                          text-align: center;
                          color: rgba(255, 255, 255, 1);
                        "
                      >D</span
                      >
                                </div>

                                <span
                                    style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                      "
                                >
                      Needs Improvement
                    </span>
                            </div>

                            <div>
                    <span
                        style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                        text-align: left;
                      "
                    >
                      0-25%- Underutilized
                    </span>
                            </div>

                            <div style="display: flex; gap: 4px; align-items: center">
                                <div
                                    style="
                        width: 19px;
                        height: 19px;
                        padding: 2px 0px 0px 0px;
                        border-radius: 999999px;
                        background: rgba(180, 35, 24, 1);
                        display: grid;
                        place-content: center;
                      "
                                >
                      <span
                          style="
                          font-family: Inter;
                          font-size: 12px;
                          font-weight: 400;
                          line-height: 14.52px;
                          text-align: center;
                          color: rgba(255, 255, 255, 1);
                        "
                      >E</span
                      >
                                </div>

                                <span
                                    style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                      "
                                >
                      Poor
                    </span>
                            </div>

                            <div>
                    <span
                        style="
                        font-family: Inter;
                        font-size: 12px;
                        font-weight: 400;
                        line-height: 14.52px;
                        text-align: left;
                      "
                    >
                      0
                    </span>
                            </div>
                        </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
