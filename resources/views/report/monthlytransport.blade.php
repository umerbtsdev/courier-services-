{{--@extends('adminlte::layouts.page')--}}
@extends('adminlte::layouts.app')
@section('htmlheader_title')
    <div> Month wise Transport </div>
@endsection

@section('contentheader_title')

@endsection

@section('title', 'Account List')

{{--@section('content_header')--}}
{{--<h1>Clients List</h1>--}}



{{--@stop--}}

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="flash-message">

                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach

            </div> <!-- end .flash-message -->
        </div>
        <div class="col-md-12">
            <div class="page-heading-primary">
                <span>
                    <a href="#"> <i class="fa fa-home"></i> </a>
                    <i class="fa fa-angle-right"> &nbsp; </i>
                    <a href="#"> Month wise Transport Report </a>
                </span>
                <h1>
                    <b> Month wise Transport Report</b>
                    <br/>
                </h1>
            </div>

        </div>
        <div class="col-md-12">
            @if(App\Helper\Common::userwisepermission(Auth::user()->id, "Month Wise Transport Create"))
                {!! Form::open(array('url'=>'Report/monthly-transport-report','method'=>'POST','id'=>'client-ledger-report', 'files' => true)) !!}
                <div class="col-md-3">
                    <div class="form-group adjust">
                        <label  for="Purchase_inv_id">Date From</label>
                        <input type="date" class="form-control textrequired" name="date_from" id="date_from" value="{{isset($data["date_from"]) ? date("Y-m-d",strtotime($data["date_from"])) : ""}}" placeholder="Enter Date from">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group adjust">
                        <label  for="Purchase_inv_id">Date To</label>
                        <input type="date" class="form-control textrequired" name="date_to" id="date_to" value="{{isset($data["date_to"]) ? date("Y-m-d",strtotime($data["date_to"])) : ""}}" placeholder="Enter Date to">
                    </div>
                </div>
                <div class="col-md-3">
                <div class="form-group adjust">
                    <label  for="Purchase_inv_id">Vehicle</label>
                <select class="form-control selectrequired" class="form-control" name="vehicle_id" id="vehicle_id" >
                    <option value="">Select Vehicle Station</option>
                    @foreach($vehicles as $vehicle)
                        @if(isset($data["vehicle_id"]))
                            @if($data["vehicle_id"] == $vehicle->id)
                                <option value="{{$vehicle->id}}" selected="selected">{{$vehicle->vehicle_no}}</option>
                            @else
                                <option value="{{$vehicle->id}}">{{$vehicle->vehicle_no}}</option>
                            @endif
                         @else
                            <option value="{{$vehicle->id}}">{{$vehicle->vehicle_no}}</option>
                        @endif
                    @endforeach
                </select>
                </div>
            </div>
                <div class="col-md-1">
                    <div class="form-group adjust">
                        <label  for="Purchase_inv_id"></label>
                        <button type="submit" class="btn btn-primary bgcolr-orange" id="submit-dept" style="float: right">Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}

            @endif
        </div>
        <div class="col-md-12">
            @if(isset($monthwisereport))

                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>
                            id
                        </th>
                        <th>
                            Date
                        </th>
                        <th style="text-align: center;">
                            Billed
                        </th>
                        <th style="text-align: center;">
                            Detention
                        </th>
                        <th style="text-align: center;">
                            Total Billed
                        </th>
                        <th style="text-align: center;">
                            Diesel
                        </th>
                        <th style="text-align: center;">
                            Driver Allowance
                        </th>
                        <th style="text-align: center;">
                            Misc
                        </th>
                        <th style="text-align: center;">
                            Total Expense
                        </th>
                        <th style="text-align: center;">
                            Net Profit/Loss
                        </th>
                        <th style="text-align: center;">
                            Reading Start
                        </th>
                        <th style="text-align: center;">
                            Reading End
                        </th>
                        <th style="text-align: center;">
                            Total Reading
                        </th>
                        <th style="text-align: center;">
                            Remarks
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php // $profit_afn = 0; ?>
                    <?php // $profit_usd = 0; ?><?php $count = 0; $status = 0; ?>
                    <?php $period = \Carbon\CarbonPeriod::create($data["date_from"], $data["date_to"]); ?>

                    <?php $totalbl = 0; ?>
                    <?php $totalexp = 0; ?>
                    <?php $totalbilled = 0; ?>
                    <?php $totaldetention = 0; ?>
                    <?php $totaldiesel = 0; ?>
                    <?php $totaldriverallowance =0 ?>
                    <?php $totalmisc =0 ?>
                    <?php $totalprofit =0 ?>
                    <?php $totalreading = 0 ?>

                    @foreach ($period as $date)

                    @foreach($monthwisereport as $monthwiserpt)

                        @if($date->format('d.m.Y') != date('d.m.Y', strtotime($monthwiserpt->trip_date)))

                            @continue
                            @else
                        <?php //$profit_afn = $profit_afn + ($Profitandloss->currency == "AFN" ? floatval($Profitandloss->total_amount) : 0); ?>
                        <?php //$profit_usd = $profit_usd + ($Profitandloss->currency == "USD" ? floatval($Profitandloss->total_amount) : 0); ?>
                        <tr>
                            <td>
                                {{$count}}
                            </td>
                            <td>

                                {{$date->format('d.m.Y')}}
                                {{--{{date('d.m.Y', strtotime($monthwiserpt->trip_date))}}--}}
                            </td>
                            <td>
                                <?php $totalbilled +=$monthwiserpt->Billed ?>
                                {{$monthwiserpt->Billed}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totaldetention += $monthwiserpt->Detention ?>
                                {{$monthwiserpt->Detention}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totalbl += floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention); ?>
                                {{floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention)}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totaldiesel += $monthwiserpt->Diesel ?>
                                {{$monthwiserpt->Diesel}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totaldriverallowance += $monthwiserpt->driver_allowance ?>
                                {{$monthwiserpt->driver_allowance}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totalmisc += $monthwiserpt->misc ?>
                                {{$monthwiserpt->misc}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totalexp += floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc); ?>
                                {{floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc)}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totalprofit += floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention) - (floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc)); ?>
                                {{floatval($monthwiserpt->Billed) + floatval($monthwiserpt->Detention) - (floatval($monthwiserpt->driver_allowance) + floatval($monthwiserpt->Diesel) + floatval($monthwiserpt->misc))}}
                            </td>
                            <td style="text-align: center;">
                                {{$monthwiserpt->reading_start}}
                            </td>
                            <td style="text-align: center;">
                                {{$monthwiserpt->reading_end}}
                            </td>
                            <td style="text-align: center;">
                                <?php $totalreading += (intval($monthwiserpt->reading_end) - intval($monthwiserpt->reading_start)) ?>
                                {{intval($monthwiserpt->reading_end) - intval($monthwiserpt->reading_start)}}
                            </td>
                            <td style="text-align: center;">
                                {{$monthwiserpt->remarks}}
                            </td>
                        </tr>
                            <?php $status = 1; ?>
                        @endif

                    @endforeach

                            <?php $count ++; ?>
                        @if($status == 0)
                            <tr>
                                <td>
                                    {{$count}}
                                </td>
                                <td>
                                    {{$date->format('d.m.Y')}}
                                </td>
                                <td colspan="12">
                                    <b>Not Working</b>
                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                                <td style="display: none;text-align: center;">

                                </td>
                            </tr>
                            @else
                            <?php $status = 0; ?>
                            @endif
                            {{--@if($currentdate != date('d.m.Y', strtotime($monthwiserpt->trip_date)))--}}
                                {{--<td colspan="9">--}}
                                    {{--not working--}}
                                {{--</td>--}}
                            {{--@endif--}}

                    @endforeach
                    <tr>
                        <td>
                            {{$count}}
                        </td>
                        <td>
                            <span style="font-weight: bold"> Total </span>
                        </td>
                        <td>
                            <span style="font-weight: bold;font-size: 16px;">{{$totalbilled}}</span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totaldetention}}</span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"> {{$totalbl}} </span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totaldiesel}}</span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totaldriverallowance}}</span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totalmisc}}</span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totalexp}}</span>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totalprofit}}</span>
                        </td>
                        <td style="text-align: center;">

                        </td>
                        <td style="text-align: center;">

                        </td>

                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totalreading}}</span>
                        </td>
                        <td style="text-align: center;">

                        </td>
                    </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <script>
        var titletop = "<div style'text-align: center;font-size: 30px;font-weight: bold;'>Month wise Transport Report from {{isset($data['date_from']) ? date('d-m-Y',strtotime($data['date_from'])) : ''}} to {{isset($data['date_from']) ? date('d-m-Y',strtotime($data['date_from'])) : ''}} </div>";
        $(document).ready(function() {
            $('#example').DataTable({
                lengthMenu: [[500], [500]],
                dom: 'Blfrtip',
                aaSorting : [[0, 'asc']],
                aoColumnDefs: [{ "bVisible": false, "aTargets": [0] }],
                buttons: [
                    { extend: 'print', footer: true, title: titletop },
                    { extend: 'copy', footer: true, title: titletop },
                    { extend: 'csv', footer: true, title: titletop },
                    { extend: 'excel', footer: true, title: titletop }
                ]
            } );
        } );
    </script>
@endsection


{{--@section('js')--}}

{{--@stop--}}