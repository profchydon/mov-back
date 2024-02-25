@extends('layouts.wrapper')

@section('title')
Subscription Upgraded
@endsection

@section('content')

<div style="background: linear-gradient(to top, transparent, #C0C0C040); padding: 2px 30px;">

  <div style="text-align: center; padding: 40px 0px;">
    <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/plane.png" alt=""
      style="display: inline-block; max-width: 40%; height: auto;">
  </div>

  <div style="
      color: #191919;
      font-family: 'IBM Plex Sans', sans-serif;
      background: #fff;
      border-radius: 8px;
      border: 1.5px solid #0C66FF;
      padding: 20px 30px;
      width: auto;
      margin-bottom: 10px;">

    <p
      style="font-size: 30px; line-height: 40px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; margin: 0px;">
      Your Plan has been <br> upgraded successfully 👍
    </p>

    <p
      style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
      Hello <b>{{ $company?->name }}</b> 👋️</p>
    <br>
    <p
      style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">
      Your Rayda account has been upgraded successfully from <b> {{ strtolower($oldPlan?->name) }} plan </b> to <b> {{
        strtolower($newPlan?->name) }} plan </b>. This means you
      have gained access to the following benefits:
    </p>

    <ul style="list-style-type: none; font-family: 'IBM Plex Sans', sans-serif; font-size: 16px; padding: 0px;">

      @foreach ($offers as $offer)

      <li style="display: flex; font-weight: 500; margin: 20px 0px;">
        <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png" class="object-contain"
          alt=""
          style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
        {{ $offer }}
      </li>

      @endforeach

    </ul>

    <div style="margin-top: 50px;">

      <p
        style="font-size: 14px; line-height: 10px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
        <b>Order details:</b>
      </p>
      <p
        style="font-size: 14px; line-height: 10px; color: #004CCC; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
        <span style="font-weight: 300; color: #191919;">Invoice No:</span> <a href={{ $link }}> {{
          $invoice?->invoice_number}} </a>
      </p>

    </div>

    {{-- <hr style="border: 0.5px solid #DCDFEA; margin: 30px 0px;">

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

    </div> --}}

  </div>

  <p
    style="font-size: 14px; line-height: 24px; color: #404968; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; padding: 0px 20px;">
    Learn more about our plans, payments accepted and billing practices in our help centre.
    <br> <br> <br>
    The Rayda Team
  </p>

</div>

@endsection
