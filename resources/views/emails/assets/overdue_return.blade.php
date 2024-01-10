@extends('layouts.wrapper')

@section('title')
    Overdue Asset Return
@endsection

@section('content')
    <p style="font-size: 1.5rem; color: #111322; font-family: 'IBM Plex Sans', sans-serif; font-weight: bold;">Overdue Asset Return</p>
    <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">Hello {{ $user->first_name }},</p>
    <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">The following assets have not been returned and are past their return dates.</p>

    <table>
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Expected Return Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($checkouts as $checkout)
                <tr>
                    <td>{{ $checkout->asset->make }}</td>
                    <td>{{ $checkout->asset->model }}</td>
                    <td>{{ $checkout->asset->serial_number }}</td>
                    <td>{{ $checkout->return_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">
        Best regards,
        <br>
        Rayda
    </p>
@endsection
