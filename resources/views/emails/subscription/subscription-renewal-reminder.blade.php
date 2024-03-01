@extends('layouts.wrapper')

@section('title')
Subscription Renewal Reminder
@endsection

@section('content')

<div style="background: linear-gradient(to top, transparent, #FFEC8540); padding: 2px 30px;">

    <div style="text-align: center; padding: 40px 0px;">
      <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/notification.png" alt=""
        style="display: inline-block; max-width: 30%; height: auto;">
    </div>

    <div style="
      color: #191919;
      font-family: 'IBM Plex Sans', sans-serif;
      background: #fff;
      border-radius: 8px;
      border: 1.5px solid #FEC84B;
      padding: 20px 30px;
      width: auto;
      margin-bottom: 10px;">

      <p
        style="font-size: 30px; line-height: 40px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; margin: 0px;">
        Subscription Renewal <br>  Reminder 🔄
      </p>

      <br>

      <p
        style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
        Hello <b>John Edem</b> 👋</p>
      <p
        style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">
        This is a friendly reminder that your Rayda subscription will be automatically renewed in 7 days.
        You may manage your subscription by clicking on the button below
      </p>

      <p
        style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">
        If you have any questions, please contact hello@rayda.co
      </p>

      <div style="margin-top: 50px;">

        <p
        style="font-size: 14px; line-height: 10px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
        <b>Order details:</b>
        </p>
        <p
          style="font-size: 14px; line-height: 10px; color: #004CCC; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
          <span style="font-weight: 300; color: #191919;">No. Invoice:</span> INV/20220403/NTL/75686059
        </p>

      </div>

      <hr style="border: 0.5px solid #DCDFEA; margin: 30px 0px;">

      <div style="
      display: flex;
      flex-direction: column;
      color: #191919;
      font-family: 'IBM Plex Sans', sans-serif;
      background: #fff;
      border-radius: 8px;
      width: auto;
      margin-bottom: 10px;">

      <div style="display: flex; line-height: 5px;">
        <div style="text-align: left; font-size: 14px; width: 45%; font-weight: 300;">
          <p>Subtotal</p>
        </div>
        <div style="text-align: right; font-size: 14px; width: 55%; font-weight: 500;">
          <p>$2,200</p>
        </div>
      </div>

      <div style="display: flex; line-height: 5px;">
        <div style="text-align: left; font-size: 14px; width: 45%; font-weight: 300;">
          <p>Discount</p>
        </div>
        <div style="text-align: right; font-size: 14px; width: 55%; font-weight: 500;">
          <p>$0</p>
        </div>
      </div>

      <div style="display: flex; line-height: 5px;">
        <div style="text-align: left; font-size: 14px; width: 45%; font-weight: 300;">
          <p>Tax (5%)</p>
        </div>
        <div style="text-align: right; font-size: 14px; width: 55%; font-weight: 500;">
          <p>$50</p>
        </div>
      </div>

      <div style="display: flex; line-height: 10px;">
        <div style="text-align: left; font-size: 14px; width: 45%; font-weight: 300;">
          <p>Total</p>
        </div>
        <div style="text-align: right; font-size: 14px; width: 55%; font-weight: 500;">
          <p>$2,250</p>
        </div>
      </div>

    </div>

    <div style="margin: 0px 0px 30px 0px; text-align: center;">
      <a href="" style="display: inline-block; width: 100%; padding: 15px 0;
          font-weight: 500;
          font-size: 14px;
          font-family: 'IBM Plex Sans', sans-serif;
          border-radius: 8px;
          background: #004CCC;
          color: #fff;
          text-decoration: none;">
        Manage Subscription
      </a>
    </div>

    </div>

    <p
      style="font-size: 14px; line-height: 24px; color: #404968; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; padding: 0px 20px;">
      Learn more about our plans, payments accepted and billing practices in our help centre.
      <br> <br> <br>
      The Rayda Team
    </p>

  </div>

@endsection
