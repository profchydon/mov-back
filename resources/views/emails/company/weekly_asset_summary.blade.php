@extends('layouts.wrapper')

@section('title')
Your Weekly Asset Report is Here!
@endsection

@section('content')

<div>
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
        <img
          src="https://s3.amazonaws.com/rayda.co/images+for+email+template/email-snapshot.png"
          style="width: 570px"
          alt=""
        />
      </div>

      <div style="padding: 32px 24px 32px 24px">
        <div style="margin-bottom: 3.125rem">
          <div
            style="
              font-family: 'IBM Plex Sans', sans-serif;
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
                font-family: 'IBM Plex Sans', sans-serif;
                font-size: 16px;
                font-weight: 400;
                line-height: 24px;
                text-align: left;
              "
            >
              Hi,
            </p>

            <p
              style="
                font-family: 'IBM Plex Sans', sans-serif;
                font-size: 16px;
                font-weight: 400;
                line-height: 24px;
                text-align: left;
              "
            >
              Here is an overview of your asset’s progress in
              <span
                style="
                  font-family: 'IBM Plex Sans', sans-serif;
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
              font-family: 'IBM Plex Sans', sans-serif;
              font-size: 18px;
              font-weight: 600;
              line-height: 28px;
              text-align: left;
            "
          >
            Report Overview
          </p>

          <div style="display: flex; line-height: 5px; margin: 20px 0px">
            <div style="width: 50%; opacity: 0px">
              <div
                style="
                  border: 1px solid rgba(0, 76, 204, 1);
                  border-radius: 8px;
                  padding: 20px;
                  margin-right: 10px;
                "
              >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
                    font-family: 'IBM Plex Sans', sans-serif;
                    font-size: 30px;
                    font-weight: 600;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{ number_format($report->totalAssetValue) }}</span
                >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
            </div>

            <div style="width: 50%; opacity: 0px">
              <div
                style="
                  border: 1px solid rgba(0, 76, 204, 1);
                  border-radius: 8px;
                  padding: 20px;
                  margin-left: 10px;
                "
              >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
                    font-family: 'IBM Plex Sans', sans-serif;
                    font-size: 30px;
                    font-weight: 600;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{ number_format($report->totalAssetAddedValue) }}</span
                >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
            </div>
          </div>

          <div style="display: flex; line-height: 5px; margin: 20px 0px">
            <div style="width: 50%; opacity: 0px">
              <div
                style="
                  border: 1px solid rgba(0, 76, 204, 1);
                  border-radius: 8px;
                  padding: 20px;
                  margin-right: 10px;
                "
              >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
                    font-family: 'IBM Plex Sans', sans-serif;
                    font-size: 30px;
                    font-weight: 600;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{ number_format($report->totalInsuredAssetValue) }}</span
                >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
            </div>

            <div style="width: 50%; opacity: 0px">
              <div
                style="
                  border: 1px solid rgba(0, 76, 204, 1);
                  border-radius: 8px;
                  padding: 20px;
                  margin-left: 10px;
                "
              >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
                    font-family: 'IBM Plex Sans', sans-serif;
                    font-size: 30px;
                    font-weight: 600;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{ number_format($report->totalUnInsuredAssetValue) }}</span
                >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
            </div>
          </div>

          <div style="display: flex; line-height: 5px; margin: 20px 0px">
            <div style="width: 50%; opacity: 0px">
              <div
                style="
                  border: 1px solid rgba(0, 76, 204, 1);
                  border-radius: 8px;
                  padding: 20px;
                  margin-right: 10px;
                "
              >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
                    font-family: 'IBM Plex Sans', sans-serif;
                    font-size: 30px;
                    font-weight: 600;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{ number_format($report->totalAssetDueMaintenanceValue) }}
                </span>
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
            </div>

            <div style="width: 50%; opacity: 0px">
              <div
                style="
                  border: 1px solid rgba(0, 76, 204, 1);
                  border-radius: 8px;
                  padding: 20px;
                  margin-left: 10px;
                "
              >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 20px;
                    text-align: left;
                    color: rgba(0, 76, 204, 1);
                    display: block;
                  "
                  >Checked-out Assets</span
                >
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
                    font-size: 30px;
                    font-weight: 600;
                    line-height: 44px;
                    letter-spacing: -0.02em;
                    text-align: left;
                    display: block;
                  "
                  >₦ {{ number_format($report->totalCheckedOutAssetValue) }}
                </span>
                <span
                  style="
                    font-family: 'IBM Plex Sans', sans-serif;
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
                color: #fff;
              "
            >
              <span
                style="
                  font-family: 'IBM Plex Sans', sans-serif;
                  font-size: 16px;
                  font-weight: 600;
                  line-height: 24px;
                  text-align: left;
                  color: #fff !important;
                "
                >View full report</span
              >
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
