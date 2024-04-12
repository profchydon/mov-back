@extends('layouts.wrapper')

@section('title')
    Weekly Asset Report
@endsection

@section('content')
   <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">Here is an overview of your asset's progress in <b>{{$company->name}}</b> for the week.</p>

   <h2>Report Overview</h2>

   <table border="1" cellpadding="5" cellspacing="0">
       <tr>
           <th>Metric</th>
           <th>Count</th>
           <th>Value</th>
       </tr>
       <tr>
           <td>Asset Total</td>
           <td>{{$report->totalAsset}}</td>
           <td>{{$report->totalAssetValue}}</td>
       </tr>
       <tr>
           <td>Asset Added this week</td>
           <td>{{$report->totalAssetAdded }}</td>
           <td>{{$report->totalAssetAddedValue}}</td>
       </tr>
       <tr>
           <td>Total Insured Asset</td>
           <td>{{$report->totalInsuredAsset  }}</td>
           <td>{{$report->totalInsuredAssetValue}}</td>
       </tr>
       <tr>
           <td>Total Uninsured Asset</td>
           <td>{{$report->totalUnInsuredAsset }}</td>
           <td>{{$report->totalUnInsuredAssetValue }}</td>
       </tr>
       <tr>
           <td>Asset Due for Maintenance</td>
           <td>{{$report->totalAssetDueMaintenance}}</td>
           <td>{{$report->totalAssetDueMaintenanceValue }}</td>
       </tr>
       <tr>
           <td>Checkout Asset</td>
           <td>{{$report->totalCheckedOutAsset }}</td>
           <td>{{$report->totalCheckedOutAssetValue }}</td>
       </tr>
   </table>


    <p style="font-family: 'IBM Plex Sans', sans-serif; color: #404968;">
        Best regards,
        <br>
        Rayda
    </p>



@endsection
