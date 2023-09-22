@extends('layouts.wrapper')

@section('title')
Rayda Invitation
@endsection

@section('content')
<p style="font-size: 1.5rem; color: #111322; font-family: 'IBM Plex Sans', sans-serif; font-weight: bold;">You've Been Invited To Collaborate On Rayda</p>
<p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">Hello, {{$invitedBy}} has invited you to collaborate with them on Rayda at <strong>{{ $company }}</strong>. We are excited to have you join their team!</p>
<p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">To get started, just click the link below to dive into the organisation’s asset management backbone.</p>

<div style="display: flex; justify-content: space-between; flex-wrap: wrap; margin: 2rem 0">
    <a href="{{$link}}" style="text-decoration: none; color: #fff; display: inline-flex; padding: 1rem 2rem; background: #004CCC; font-family: 'IBM Plex Sans', sans-serif; border-radius: 8px; justify-content: center; min-width: 36%; flex:1;">Accept Invitation</a>
    <div style="display: inline-flex; padding: 1rem 1.5rem;  min-width: 36%; flex:1; margin-bottom: 1rem;"></div>
</div>

<p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968; margin-top: 1.5rem;">What's Rayda?</p>
<p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">Rayda is an Asset lifecycle management solution; making it easy to manage, track and audit assets as well as Insurance, issuance and so much more. Want to learn more?</p>
<p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">- The Rayda Team</p>

@endsection