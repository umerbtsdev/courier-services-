<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Customer Invoice</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->


   
    <!-- Custom CSS -->

    <link href="{{ url('dist/css/customerInvoicePrint/style.css') }}" rel="stylesheet" type="text/css"/>
    {{-- <link href="{{ url('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .table.table-bordered {
            border: 1px solid #e0e3e4;
        }
        #clientTable-inner tr:first-child td, #invoice-details-table-inner tr:first-child td {
            border: none !important;
        }

        #invoice-details-table-inner tr .descriptor:{
            width:fit-content;
        }
        #invoice-details-table-inner tr td span{
            text-align:left;
        }
        #invoice-details-table-inner tbody tr td:first-child{
            width: 120px;;
        }

        @media print{ 
            input{
                border: none !important;
                background: transparent !important;
                -webkit-box-shadow: none !important;
                -moz-box-shadow: none !important;
                box-shadow: none !important;
                height: 14px;
            }
            body {
                font-size: 10px;
            }
            .first-table{
                width: 30%;
            }
            .b-t-1{
                border-top: 1px solid black !important;
            }
            .b-b-1{
                border-bottom: 1px solid black !important;
            }
            .b-t-1{
                border-top: 1px solid black !important;
            }
            .b-b-1{
                border-bottom: 1px solid black !important;
            }
            b{
                /*font-weight: normal;*/
            }
            button  {
                display: none;
            }
        }
        body {
            font-size: 10px;
        }
        .first-table{
            width: 30%;
        }
        table tbody td{
            padding: 5px !important;
        }
        .title{
            text-align: left;
        }
        .title2{
            text-align: right;
        }
        .border-none{
            border: none !important;
        }
        .b-t-1{
            border-top: 1px solid black !important;
        }
        .b-b-1{
            border-bottom: 1px solid black !important;
        }
        address {
            margin-bottom: 15px;
            font-style: normal;
            line-height: 1.42857143;
        }
        .table td {
            /*border:none !important;*/
        }
        #itemTable th{
            font-weight: 500;
            font-size: 10px;
        }
        input{
            height: 14px;
            border: 1px solid #e3e8e6;
        }
    </style>
</head>
{{--  <body onafterprint="window.close()">  --}}
{{-- <body onafterprint="" onload="window.print()"> --}}
    @php
        $borderTop="border-top: 1px solid black !important;";
        $borderBottom="border-bottom: 1px solid black !important;";
        $borderLeft="border-left: 1px solid black !important;";
        $borderRight="border-right: 1px solid black !important;";
        $paddingBottom3 = "padding-bottom: 3px !important;";
        $centerTextOnColumn = "padding: 0;vertical-align: middle;";
        $itemTableTextAlignment = "padding-left: 6px !important;padding-right: 0 !important;";
        $otherInfo = "width: 238px";
        $colon = "<b>:</b>";
        $extraInputStyling = "";
        $w90 = "width: 90px;";
        $height23 = "height: 23px;";
        $height30 = "height: 30px;";
    @endphp
<body onafterprint="afterPrint()" >

    <!-- HK Wrapper -->
        <div class="hk-wrapper hk-alt-nav">
            <!-- Main Content -->
                <div class="hk-pg-wrapper" style="padding-top: 0%;">
                    <div class="col-sm-12" style="    margin-bottom: 7px;">
                        <div class="container" style="text-align: center;">
                            <h4>ICS LOGISTICS (PVT) LIMITED</h4>
                            <div class="container">
                                <address style="margin-bottom: 5px;">1st Floor, Shafi Court, Merewether Road, Civil Lines. <br/>Karachi Pakistan. Tel: 92 (21) 111 565 565, Fax: 021 35681342</address>
                                <br/>
                                <br/>
                                <h4>Invoice</h4>                                
                            </div>
                        </div>
                        
                    </div>

                    <!-- Container -->
                        <div class="container-fluid">
                            <p class="text-right"><b>Statement Date : {{  date_format(date_create($invoice->statement_date),'d-F-Y') }}</b>
                            <table class="table">
                                <tr class="border-none">
                                    <td class="first-table border-none" style="padding:0 !important">
                                        <table class="table dataTable border-none" id="clientTable-inner" style="{{ $borderTop.$borderBottom.$borderLeft.$borderRight }}">
                                            <tr class="border-none">
                                                <td class="border-none" style="{{ $paddingBottom3.$borderBottom }}">
                                                    <b>Client {!! $colon !!}</b> {{ $invoice->client_name }} 
                                                    <address>
                                                        <span class="d-block">{{ $invoice->address_line_1 }}</span>
                                                        <span class="d-block">{{ $invoice->address_line_2 }}</span>
                                                        <span class="d-block">{{ $invoice->client_city }}</span>
                                                    </address>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="{{ $borderBottom }}">
                                                    Commodity {!! $colon !!} 
                                                    <input type="text" id="comodity" value="{{ $invoice->comodity }}" class="otherinfo" style="width:50%;"/>
                                                </td>    
                                            </tr>        
                                            <tr>
                                                <td style="{{ $borderBottom }}">No. of Packages {!! $colon !!} 
                                                    <input type="text" id="no_of_packages" class="otherinfo" style="width:50%;" value="{{ $invoice->no_of_packages }}"/>
                                                </td>    
                                            </tr>        
                                            <tr>
                                                <td style="{{ $borderBottom }}">Shipper&quot;s Invoice value {!! $colon !!}
                                                    <input type="text" id="shipper_invoice_value" class="otherinfo" style="width:30%;" value="{{ $invoice->shipper_invoice_value }}"/>
                                                </td>    
                                            </tr>        
                                            <tr style="height:31px;">
                                                <td style="{{ $borderBottom }}">&nbsp;</td>    
                                            </tr>        

                                        </table>
                                    </td>
                                    <td style="padding:0 !important;border-top: 0px solid !important;">
                                        <table class="table dataTable " id="invoice-details-table-inner" style="{{ $borderBottom.$borderTop.$borderRight }}">
                                            <tr class="descriptor"  style="{{ $borderTop }}" style="{{ $height23 }}">
                                                <td class="title">Invoice No. {!! $colon !!} </td>
                                                <td style="{{ $borderBottom }}"><span>TRN - {{ $invoiceID }}</span></td>
                                                <td class="title2" style="{{ $borderBottom }}">Date {!! $colon !!} </td>
                                                <td style="{{ $borderBottom }}">{{  date_format(date_create($invoice->created_at),'d-F-Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="{{ $borderBottom }}" class="title b-t-1 b-b-1">Job No {!! $colon !!} </td>
                                                <td style="{{ $borderBottom }}">
                                                    <input type="text" id="job_no" value="{{ $invoice->job_no }}" style="{{ $extraInputStyling.$w90 }}" />
                                                </td>
                                                <td style="{{ $borderBottom }} padding-right: 0px !important;width: 100px;" class="title2">File Job No. {!! $colon !!}</td>
                                                <td style="{{ $borderBottom }}">
                                                    <input type="text" id="file_job_no" value="{{ $invoice->file_job_no }}" style="{{ $extraInputStyling.$w90 }}"/>
                                                </td>
                                            </tr>
                                            <tr  style="{{ $height30 }}">
                                                <td style="{{ $borderBottom }}" class="title">EGM No. {!! $colon !!}</td>
                                                <td style="{{ $borderBottom }}" colspan="3">
                                                    <span class="d-block">{{ $invoice->days_worked }} Trip{{ $invoice->days_worked > 1 ? "s":""  }} & {{ $invoice->detention_count !=null ? $invoice->detention_count:"0" }} Detention{{ $invoice->detention_count > 1 ? "s":"" }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="{{ $borderBottom }}" class="title">Shipper&quot;s Invoice No. {!! $colon !!}</td>
                                                <td style="{{ $borderBottom }}" colspan="3">
                                                    <input type="text" id="shipper_invoice_number" value="{{ $invoice->shipper_invoice_number }}" style="{{ $extraInputStyling.$w90 }}"/>
                                                </td>
                                            </tr>
                                            <tr  style="height:25px">
                                                <td style="{{ $borderBottom }}" class="title">B/L No {!! $colon !!}</td>
                                                <td style="{{ $borderBottom }}" colspan="3">
                                                    <span class="d-block">{{ $invoice->vehicle_no }} For the M/o {{ date_format(date_create($invoice->date_from),'F-y') }} to {{ date_format(date_create($invoice->date_to),'F-y') }} </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="{{ $borderBottom }}" class="title">Port of Discharge {!! $colon !!}</td>
                                                <td style="{{ $borderBottom }}" colspan="3">
                                                    <input type="text" id="port_of_discharge" value="{{ $invoice->port_of_discharge }}" style="{{ $extraInputStyling.$w90 }}"/>
                                                </td>
                                            </tr>
                                            <tr style="height:31px">
                                                <td class="title">Assessed Value {!! $colon !!}</td>
                                                <td>
                                                    <input type="text" id="assessed_value" value="{{ $invoice->assessed_value }}" style="{{ $extraInputStyling }}"/>
                                                </td>
                                                <td class="title2">Exch Rate {!! $colon !!}</td>
                                                <td>
                                                    <input type="text" id="exchange_rate" value="{{ $invoice->exchange_rate }}" style="{{ $extraInputStyling }}"/>
                                                </td>
                                            </tr>

                                        </table>
                                        
                                    </td>
                                </tr>
                                
                                
                            </table>
                            <table class="table" style="{{ $borderTop.$borderBottom.$borderLeft.$borderRight }}" id="itemTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="{{ $centerTextOnColumn.$borderBottom }} width:2%">S.no</th>
                                        <th class="text-center" style="{{ $centerTextOnColumn.$borderBottom.$borderLeft }} width:25%">Description</th>
                                        <th class="text-center" style="{{ $centerTextOnColumn.$borderBottom.$borderLeft }} width:35%">Other Info</th>
                                        <th class="text-center" style="{{ $centerTextOnColumn.$borderBottom.$borderLeft }} width:11%">Receipt #</th>
                                        <th class="text-center" style="{{ $centerTextOnColumn.$borderBottom.$borderLeft }} width:15%">Amount (FC)</th>
                                        <th class="text-center" style="{{ $centerTextOnColumn.$borderBottom.$borderLeft }} width:15%">Amount (Rs)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalBilled = 0; $sno =1; $dataCount=0; ?>
                                    @foreach ($tableDatum as $tableData)
                                        <tr>
                                            <td class="text-center" style="{{ $borderRight.$borderBottom }}">{{ $sno  }}</td>
                                            
                                            {!! Form::hidden("account_id[]" ,$tableData->id ) !!}
                                            
                                            <td class="" style="{{ $itemTableTextAlignment.$borderBottom }}">{{ $tableData->alias_name }}</td>
                                            <td class="text-center" style="{{ $borderRight.$borderLeft.$borderBottom }}">
                                                <input type="text" name="other_info[]" id="other_info" class="otherinfo" style="{{ $otherInfo }}" value="{{ $tableData->description !=null ? $tableData->description:'&nbsp;' }}" />
                                            </td>
                                            <td class="text-center"  style="{{ $borderRight.$borderBottom }}">
                                                <input type="text" name="receipt_no[]" class="otherinfo text-center"  value="{{ $tableData->receipt_no != null ? $tableData->receipt_no:'0' }}"/>
                                            </td>
                                            <td class="text-center"  style="{{ $borderRight.$borderBottom }}">
                                                <input type="text" name="amount_fc[]" class="otherinfo text-center" value="{{ $tableData->amount_fc !=null ? $tableData->amount_fc:'0'  }}" />
                                            </td>
                                            <td class="text-right" style="{{ $borderBottom }}">{{ $tableData->amount }}</td>
                                            <?php $totalBilled += $tableData->amount; ?>
                                        </tr>
                                        @php
                                            $sno++;$dataCount++;
                                        @endphp
                                    @endforeach
                                    @for ($i = 0; $i < (10 - $dataCount);$i++)
                                       
                                        <tr>
                                            <td class="text-center" style="{{ $borderRight.$borderBottom }}">&nbsp;</td>
                                            <td class="" style="{{ $itemTableTextAlignment.$borderRight.$borderBottom }}"></td>
                                            <td class="text-center" style="{{ $borderRight.$borderLeft.$borderBottom }}">
                                                
                                            </td>
                                            <td class="text-center" style="{{ $borderRight.$borderBottom }}"></td>
                                            <td class="text-center" style="{{ $borderRight.$borderBottom }}"></td>
                                            <td class="text-right" style="{{ $borderBottom }}"></td>
                                        </tr>
                                        @php
                                            $sno++;
                                        @endphp
                                    @endfor
                                   
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">
                                            <b>In Words {!! $colon !!}</b>
                                            
                                            {{-- <input type="text" class="otherinfo" style="width:78%;"/> --}}
                                            {!! App\Helper\Common::displaywords($totalBilled) !!}
                                          
                                        </th>
                                        <th  class="text-right">
                                            <b>Total Amount {!! $colon !!}</b>
                                        </th>
                                        <th class="text-right">
                                            {{ $totalBilled }}
                                        </th>

                                    </tr>
                                </tfoot>
                            </table>
                            <p>- Any Discrepancy noted in this Invoice should be brought to our notice within 7 days from the date of invoice</p>
                            <br/>
                            <h6><b>FOR : ICS LOGISTICS (PVT) LIMITED</b></h6>
                            <br/>
                            <br/>
                            <br/>
                            <p style="width:190px; border-top:1px solid black;text-align:center"><b>Accounts Department</b></p>
                            <br/>
                            <p style="font-family: monospace;"><b>Note : </b> This is a computer generated invoice and does not need any signature</p>
                        </div>
                    <!-- /Container -->
                    <div class="col-sm-2" style="float:right">
                        <button class="btn btn-primary" id="printInvoice">Print Invoice</button>
                    </div>
                </div>
            <!-- /Main Content -->
            
        </div>
    <!-- /HK Wrapper -->




    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function downloadInvoice(){
            download(document.body.outerHTML, "CustomerInvoice-{{ $invoiceID }}.html", "image/svg+xml");
        }

        jQuery(document).ready(function(){
            jQuery("#printInvoice").click(function(){

                var accounts = [];
                
                var other_info = [];
                var receipt_no = [];
                var amount_fc = [];
                for(var i = 0; i < $("input[name='account_id[]']").length; i++){
                    
                    accounts.push($("input[name='account_id[]']")[i].value);
                    other_info.push($("input[name='other_info[]']")[i].value);
                    receipt_no.push($("input[name='receipt_no[]']")[i].value);
                    amount_fc.push($("input[name='amount_fc[]']")[i].value);
                }

                jQuery.ajax({
                    url: '{{ url("/Transactions/Customer-Inovices/save-customer-invoice-data/") }}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "invoice_id" : "{!! $invoice->id !!}",
                        "comodity" :jQuery("#comodity").val(),
                        "no_of_packages" :jQuery("#no_of_packages").val(),
                        "shipper_invoice_value" :jQuery("#shipper_invoice_value").val(),
                        "job_no" :jQuery("#job_no").val(),
                        "file_job_no" :jQuery("#file_job_no").val(),
                        "shipper_invoice_number" :jQuery("#shipper_invoice_number").val(),
                        "port_of_discharge" :jQuery("#port_of_discharge").val(),
                        "assessed_value" :jQuery("#assessed_value").val(),
                        "exchange_rate" :jQuery("#exchange_rate").val(),
                        "accounts" : accounts,
                        "other_infos" : other_info,
                        "receipt_nos" : receipt_no,
                        "amounts_fc" : amount_fc,
                    },
                    success: function(data){
                        $("#printInvoice").hide()
                        window.print();
                    }
                });
                
                
            });
        });
        function afterPrint(){
          //  window.location.reload();
          $("#printInvoice").show();
        }
    </script>
</body>

</html>