<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Customer Invoice</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->


    <!-- Toggles CSS -->
    <link href="{{ url('vendor/jquery-toggles/css/toggles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('vendor/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->

    <link href="{{ url('dist/css/customerInvoicePrint/style.css') }}" rel="stylesheet" type="text/css">
</head>

{{--  <body onafterprint="window.close()">  --}}
<body onafterprint="">
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->
    
	<!-- HK Wrapper -->
	<div class="hk-wrapper hk-alt-nav">
        <!-- Main Content -->
        <div class="hk-pg-wrapper" style="padding-top: 5%;">
            <div class="col-sm-12">
                <div class="container" style="text-align: center;">
                    <img src="{{ url('img/ICSLogisticslogo.png') }}"  width="200" height="40" alt="Logo">
                    <div class="container">
                        <address>1st Floor, Shafi Court, Merewether Road, Civil Lines. Karachi Pakistan.</address>
                        <tel>Phone: 92 (21) 111 565 565</tel>
                    </div>
                </div>
            </div>

            <!-- Container -->
            <div class="container-fluid">
                <!-- Title -->
                <div class="hk-pg-header mb-10">
					<div class="col-sm-11">

                    </div>
					<div class="d-flex">
                        <a onclick="window.print()" class="text-secondary mr-15"><span class="feather-icon"><i data-feather="printer"></i></span></a>
                        <a onclick="downloadInvoice()" class="text-secondary mr-15"><span class="feather-icon"><i data-feather="download"></i></span></a>
                        
                    </div>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper hk-invoice-wrap pa-35">
                            <div class="invoice-from-wrap">
                                <div class="row">
                                    <div class="col-md-7 mb-20">
                                        
                                        <h6 class="mb-5">{{ $invoice->client_name }}</h6>
                                        <address>
                                            <span class="d-block">{{ $invoice->address_line_1 }}</span>
                                            <span class="d-block">{{ $invoice->address_line_2 }}</span>
                                            <span class="d-block">{{ $invoice->client_city }}</span>

                                        </address>
                                    </div>
                                    <div class="col-md-5 mb-20">
                                        <h6> </h6>
                                        <span class="d-block">Statement Date:<span class="pl-10 text-dark">{{  date_format(date_create($invoice->statement_date),'d-F-Y') }}</span></span>
                                        <span class="d-block">Date:<span class="pl-10 text-dark">{{  date_format(date_create($invoice->created_at),'d-F-Y') }}</span></span>
                                        <span class="d-block"><span class="invoiceCode">Invoice: <span>TRN - </span>{{ $invoiceID }}</span></span></span>
                                        <span class="d-block">Remarks:
                                                <span class="d-block">{{ $invoice->days_worked }} Trip{{ $invoice->days_worked > 1 ? "s":""  }} & {{ $invoice->detention_count !=null ? $invoice->detention_count:"0" }} Detention{{ $invoice->detention_count > 1 ? "s":"" }}</span>
                                                <span class="d-block">{{ $invoice->vehicle_no }} For the M/o {{ date_format(date_create($invoice->date_from),'F-y') }} to {{ date_format(date_create($invoice->date_to),'F-y') }} </span>
                                        </span> 
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-0">
                            <!--<div class="invoice-to-wrap pb-20">
                                <div class="row">
                                    <div class="col-md-7 mb-30">

                                        <address>
												<span class="d-block">Sycamore Street</span>
												<span class="d-block">San Antonio Valley, CA 34668</span>
												<span class="d-block">thompson_peter@super.co</span>
												<span class="d-block">ABC:325487</span>
											</address>
                                    </div>
                                    <div class="col-md-5 mb-30">

                                        <span class="d-block">Scott L Thompson</span>
                                        <span class="d-block">MasterCard#########1234</span>
                                        <span class="d-block">Customer #<span class="text-dark">324148</span></span>
                                        <span class="d-block text-uppercase mt-20 mb-5 font-13">amount due</span>
                                        <span class="d-block text-dark font-18 font-weight-600">$22,010</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="mt-5">-->
                            <h5 >Items</h5>
                            
                            <div class="invoice-details mt-20">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-border mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="w-70">Items</th>
                                                    <th class="text-right">Receipt No.</th>
                                                    <th class="text-right">Amount (FC)</th>
                                                    <th class="text-right">Amount (RS)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $totalBilled = 0; ?>
                                                <tr>
                                                    <td class="w-70">Transportation Trip</td>
                                                    <td class="text-right"></td>
                                                    <td class="text-right"></td>
                                                    <td class="text-right">{{ $invoice->total_billed }}</td>
                                                    <?php $totalBilled += $invoice->total_billed; ?>
                                                </tr>
                                                <tr>
                                                    <td class="w-70">Detention Trip</td>
                                                    <td class="text-right"></td>
                                                    <td class="text-right"></td>
                                                    <td class="text-right">{{ $invoice->total_detentions }}</td>
                                                    <?php $totalBilled += $invoice->total_detentions; ?>
                                                </tr>

                                                
                                            </tbody>
                                            <tfoot class="border-bottom border-1">
                                                <tr>
                                                    <th colspan="3" class="text-right font-weight-600">total</th>
                                                    <th class="text-right font-weight-600">{{ $totalBilled }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="invoice-sign-wrap text-right py-60">
                                    <span style=""><b>For: ICS LOGISTICS (PVT) LIMITED </b></span>
                                    <br/>
                                    <h3> &nbsp;</h3>
                                    <span class="d-block" style="font-family: cursive;color: black;">_______________________</span>
                                    <p></p>
                                    <span style="d-block"><b>Accounts Department</b></span>
                                </div>
                            </div>
                            <hr>
                            <ul class="invoice-terms-wrap font-14 list-ul">
                                <li>Any disrepancy noted in this Inovice should be brought to our notice within 7 days from the date of invoice .</li>
                                <li>This is a computer generated Invoice and does not need any Signature.</li>
                            </ul>
                        </section>
                    </div>
                </div>
                <!-- /Row -->
            </div>
            <!-- /Container -->

           

        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="{{ url('vendor/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ url('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ url('dist/js/jquery.slimscroll.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ url('dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Toggles JavaScript -->
    <script src="{{ url('vendor/jquery-toggles/toggles.min.js') }}"></script>
    <script src="{{ url('dist/js/toggle-data.js') }}"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="{{ url('dist/js/feather.min.js') }}"></script>

    <!-- Init JavaScript -->
    <script src="{{ url('dist/js/init.js') }}"></script>

    <!-- Download2 JS -->
    <script src="{{ url('js/download2.js/download2.js') }}"></script>


    <script>
        function downloadInvoice(){
            download(document.body.outerHTML, "CustomerInvoice-{{ $invoiceID }}.html", "image/svg+xml");
        }

        $(document).ready(function(){


          setInterval(function(){
            if($(".preloader-it").attr('style') == "display: none;"){
                //window.print();
            }
          },500)
               
               
               
           
           
            
           
        });
    </script>
</body>

</html>