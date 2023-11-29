@extends('layouts.wrapper')

@section('title')
    Overdue Asset Maintenance
@endsection

@section('content')
    <p style="font-size: 1.5rem; color: #111322; font-family: 'IBM Plex Sans', sans-serif; font-weight: bold;">Overdue Asset Maintenance</p>
    <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">Hello {{ $user->first_name }},</p>
    <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">The following assets are overdue for maintenance</p>

    <table>
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Next Maintenance Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $asset)
                <tr>
                    <td>{{ $asset->make }}</td>
                    <td>{{ $asset->model }}</td>
                    <td>{{ $asset->serial_number }}</td>
                    <td>{{ $asset->next_maintenance_date }}</td>
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
