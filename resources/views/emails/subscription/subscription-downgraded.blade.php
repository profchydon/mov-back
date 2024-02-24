@extends('layouts.wrapper')

@section('title')
Subscription downgraded
@endsection

@section('content')

<div style="background: linear-gradient(to top, transparent, #FFEC8540); padding: 2px 30px;">

    <div style="text-align: center; padding: 40px 0px;">
      <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/down.png" alt=""
        style="display: inline-block; max-width: 40%; height: auto;">
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
        Your Plan has been <br> downgraded successfully 😥
      </p>

      <p
        style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
        Hello <b> James 😥</b></p>
        <br>
      <p
        style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">
        Your Rayda account has been downgraded from <b>free plan</b> to <b>premium plan</b>. This means you have lost
        access to the following benefits:
      </p>

      <ul style="list-style-type: none; font-family: 'IBM Plex Sans', sans-serif; font-size: 16px; padding: 0px;">

        <li style="display: flex; font-weight: 500; margin: 20px 0px;">
          <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png"
            class="object-contain" alt=""
            style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
          Document manager
        </li>

        <li style="display: flex; font-weight: 500; margin: 20px 0px;">
          <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png"
            class="object-contain" alt=""
            style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
          Insurance
        </li>

        <li style="display: flex; font-weight: 500; margin: 20px 0px;">
          <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png"
            class="object-contain" alt=""
            style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
          Manage personnel
        </li>

        <li style="display: flex; font-weight: 500; margin: 20px 0px;">
          <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png"
            class="object-contain" alt=""
            style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
          Manage Insurance
        </li>
      </ul>

      <div style="margin: 60px 0px 30px 0px; text-align: center;">
        <a href="" style="display: inline-block; width: 100%; padding: 15px 0;
            font-weight: 500;
            font-size: 14px;
            font-family: 'IBM Plex Sans', sans-serif;
            border-radius: 8px;
            background: #004CCC;
            color: #fff;
            text-decoration: none;">
          Click here to upgrade account
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
