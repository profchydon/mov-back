@extends('layouts.wrapper')

@section('title')
Welcome
@endsection

@section('content')
<p style="font-size: 1.5rem; color: #111322; font-family: 'IBM Plex Sans', sans-serif; font-weight: bold;">Welcome</p>
<p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">Hello {{$user->first_name}},</p>


<p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">
    Best regards,
    <br>
    Rayda
</p>



@endsection
