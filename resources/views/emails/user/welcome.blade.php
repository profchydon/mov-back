@extends('layouts.wrapper')

@section('title')
Welcome to Rayda
@endsection

@section('content')

<div
  style="background-image: url(https://s3.amazonaws.com/rayda.co/images+for+email+template/hero-bg.png); padding: 2px 30px;">
  <p
    style="font-size: 42px; line-height: 52px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
    Unlock the Value <br>
    of your Asset
  </p>
  <p
    style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
    Hello {{ $user?->first_name}},</p>
  <p
    style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
    My name is Francis and I am the founder of Rayda. Thank you for signing up on Rayda. My team and I have spent
    the
    past months building a product that provides individuals and organisations with the tool to manage an essential
    part of their operations: Assets.
  </p>
  <p
    style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
    Now you can take total control of your business assets.
  </p>
</div>

<div
    style="padding: 30px; background: #F2F7FF; width: auto; margin: 25px 0px; display: flex; justify-content: center;">
    <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/Desktop (LG) -- Single Assetaaaa 1.png"
    alt="" style="width: 100%;" />
</div>

<div style="padding: 2px 30px;">
  <p
    style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
    Rayda helps you manage... </p>

  <ul style="list-style-type: none; font-family: 'IBM Plex Sans', sans-serif; font-size: 16px; padding: 0px;">

    <li style="display: flex; font-weight: 500; margin: 20px 0px;">
      <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png" class="object-contain"
        alt=""
        style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
      Asset history
    </li>

    <li style="display: flex; font-weight: 500; margin: 20px 0px;">
      <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png" class="object-contain"
        alt=""
        style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
      Insurance
    </li>

    <li style="display: flex; font-weight: 500; margin: 20px 0px;">
      <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png" class="object-contain"
        alt=""
        style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
      Asset document
    </li>

    <li style="display: flex; font-weight: 500; margin: 20px 0px;">
      <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/check-verified.png" class="object-contain"
        alt=""
        style="display: flex; margin-right: 10px; width: 20px; height: 20px; max-width: 20px; max-height: 20px; position: relative; top: 2px" />
      Policy management and so much more...
    </li>
  </ul>
</div>

<div style="background:#162234; width: auto; color: #fff; padding: 30px;">
  <p
    style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; color: #fff;">
    We are building an OS to power every asset within your business and ensure the asset value is optimised.
  </p>

  <p
    style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; color: #fff;">
    As with a product dear to us, I'd love feedback on your experience with Rayda. This is a personal mail so feel
    free to reply with questions and suggestions. I promise to read them personally!
  </p>

  <p
    style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; color: #fff;">
    Francis
  </p>
</div>

@endsection
