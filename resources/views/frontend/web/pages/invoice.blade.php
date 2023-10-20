<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ str_replace(array("/","-",".","_") , " ",strtoupper(request()->route()->getName())) }} | {{
        config('siteConfig.app.name') }}</title>
    <!--Favicon-->

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/sites/logo.png') }} " />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
            class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

        <!-- Page CSS -->

        <!-- Helpers -->
        <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

</head>
<style>
body{
    font-family: Arial, sans-serif;
    font-size: 14px;
 }
#paid {
        opacity: 0.5;
        color: #03045e;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 25px;
        padding-right: 25px;
        border: 2px solid #03045e;
        border-style: dashed;
        position: fixed;
        top: auto;
        left: 80%;
        transform: rotate(-45deg);
    }
 @media print {
     @page {
         margin-top: 0;
         margin-left: 0.25;
         margin-right: 0.25;
         margin-bottom: 0;
     }

     body {
         padding-top: 40px;
         margin-left: 0.25px;
         margin-right: 0.25px;
         padding-bottom: 40px;
     }
 }
 @media print {
     #printButton {
         display: none;
         position: fixed;
         bottom: 20px;
         right: 30px;
         z-index: 99;
     }
 }

 .details th {
     padding: 5px;
     padding-left: 15px;
 }

    table
</style>

<body>
    <section class="p-2">
        <!------Button--------->
        <button class="btn btn-lg btn-floating float-end" style="background-color: #5f61e6;color: white;"
            id="printButton" onclick="window.print()"><i class="fas fa-print"></i> Print Invoice</button>
        <!------Main Invoice starts--------->

        <div class="row">
            <div class="col">
               <h2>{{ env('APP_NAME') }}</h2>

            @foreach($get_details as $details)
                <div style="padding-top: 20px;">
                    <table class="table table-borderless">
                        <tr>
                            <td>Bill To:</td>
                            <td scope="col">{{ $details->name }}</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td scope="col">
                                {{ $details->shipping_address }}
                            </td>
                        </tr>
                        <tr>
                            <td>Contact:</td>
                            <td scope="col">{{ $details->phone }}</td>
                        </tr>
                        <tr>
                            <td>Location:</td>
                            <td scope="col"><span class="text-white bg-primary p-2">{{ $details->location }}</span></td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="col">
                <div class="float-end">
                    <h4 class="text-uppercase">Invoice</h4>
                    <div style="color:#1c1c1c"># Order id-<span id="order_id"> {{ $details->serial }}</span></div>

                    <div style="padding-top: 40px;">
                        <p><span style="color:#1c1c1c">Date:</span><span style="padding-left:40px">{{ date('d-m-Y', strtotime($details->created_at)) }}</span>
                        </p>
                    </div>
                    <div style="background-color:#f5f5f5;">
                        <p style="padding:5px;padding-left:10px"><span style="color:#1c1c1c">Total Bill:</span><span
                                style="padding-left:25px;color:#1c1c1c"> {{ $details->total_amount }} &#2547;</span></p>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div style="padding-top: 40px;">
                    <table class="table table-bordered" style="width: 100%;">
                        <thead style="background-color:#5f61e6;">
                            <tr class="text-white">
                                <th scope="col" style=" color:white;">Item</th>
                                <th scope="col" style=" color:white;">Quantity</th>
                                <th scope="col" style=" color:white;">Rate</th>
                                <th scope="col" style=" color:white;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product_json as $key => $pd)
                            <tr>
                                <td>
                                   {{ $pd['medicine_name'] }} <br>
                                   <small class="text-primary">{{ $pd['medicine_type'] }} ({{ $pd['manufacturer'] }})</small>
                                </td>
                                <td>{{$pd['bought'] }}</td>
                                <td>{{ $pd['price'] }} &#2547;</td>
                                <td></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>Total Product Price</td>
                                <td></td>
                                <td></td>
                                <td>{{ $details->total_price }} &#2547;</td>
                            </tr>
                            <tr>
                                <td>Delivery Charge</td>
                                <td></td>
                                <td></td>
                                <td>{{ $details->deilvery_charge }} &#2547;</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td><span id="totalBillBottom"></span> <span>{{ $details->total_amount }} &#2547;</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @endforeach
     <!------Button--------->
    <div class="d-flex justify-content-center">
    <a href="{{ route('welcome') }}" class="btn btn-lg btn-floating" style="background-color: #5f61e6;color: white;" id="printButton">Return
        To homepage</a>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>

