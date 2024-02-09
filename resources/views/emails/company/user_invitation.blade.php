@extends('layouts.wrapper')

@section('title')
Rayda Invitation
@endsection

@section('content')
<div style="background: linear-gradient(to bottom, transparent, #EBF2FF); padding: 2px 30px;">
    <p
      style="font-size: 40px; line-height: 52px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">
      You have been invited to <br> collaborate on Rayda
    </p>
    <p
      style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
      Hello</p>
    <p
      style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
      {{$invitedBy}} has invited you to collaborate with them on Rayda at {{ $company }}. We are excited to have you join their team!

    </p>
    <p
      style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400;">
      To get started, just click the link below to dive into the organisation’s asset management backbone.
    </p>
    <div style="margin: 50px 0px;">
      <a href="{{$link}}" style="padding: 15px 30px;
      font-weight: 500;
      font-size: 14px;
      font-family: 'IBM Plex Sans', sans-serif;
      border-radius: 8px;
      background: #004CCC;
      color: #fff;
      text-decoration: none;">
        Accept invite
      </a>

    </div>
    <p style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; width: auto; word-wrap: break-word;">
      If you're having trouble clicking the "Accept Invite" button, copy and paste the URL below into your web browser:
    </p>
    <a style="font-size: 14px; line-height: 24px; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; width: auto; word-wrap: break-word;" href="{{$link}}">
        {{$link}}
    </a>
    <div style="margin-top: 20px;">
      <img src="https://s3.amazonaws.com/rayda.co/images+for+email+template/userinvite.png" alt="" style="width: 100%;" />
    </div>
  </div>

@endsection
