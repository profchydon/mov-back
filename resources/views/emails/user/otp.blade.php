@extends('layouts.wrapper')

@section('title')
Verify your email
@endsection

@section('content')
<div style="padding: 30px;">
  <p style="font-size: 24px; line-height: 32px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 500; margin-bottom: 16px;">
    Verify your email address
  </p>

  <p style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; margin-bottom: 16px;">
    Hello {{ $user?->first_name }},
  </p>

  <p style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; margin-bottom: 16px;">
    Use the verification code below to complete your account setup on Rayda.
  </p>

  <div style="margin: 24px 0; text-align: center;">
    <span style="display: inline-block; padding: 12px 24px; font-size: 24px; letter-spacing: 8px; font-family: 'IBM Plex Sans', sans-serif; font-weight: 600; background-color: #F2F7FF; border-radius: 8px; color: #191919;">
      {{ $otp }}
    </span>
  </div>

  <p style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; margin-bottom: 8px;">
    This code will expire in 10 minutes. If you did not request this, you can safely ignore this email.
  </p>

  <p style="font-size: 14px; line-height: 24px; color: #191919; font-family: 'IBM Plex Sans', sans-serif; font-weight: 400; margin-top: 24px;">
    Best regards,<br>
    The Rayda Team
  </p>
</div>
@endsection

