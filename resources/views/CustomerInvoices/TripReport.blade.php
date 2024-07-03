
    <div class="row">
        <div class="col-md-12">
                <table id="example" class="table table-striped table-bordered" style="width:100%;    font-size: 11px;">
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
                    <?php // $profit_usd = 0; ?>
                    <?php $count = 0; $status = 0; $daysworked=0; ?>
                    <?php $period = \Carbon\CarbonPeriod::create($data["date_from"], $data["date_to"]); ?>

                    <?php $totalbl = 0; ?>
                    <?php $totalexp = 0; ?>
                    <?php $totalbilled = 0; ?>
                    <?php $totaldetention = 0; ?>
                    <?php $totaldetentionCount = 0; ?>
                    <?php $totaldiesel = 0; ?>
                    <?php $totaldriverallowance =0 ?>
                    <?php $totalmisc =0 ?>
                    <?php $totalreading = 0 ?>
                    <?php $TripCount = 0; ?>
                    <?php 
                        $date_from = explode("-",$data["date_from"]);
                        $date_to = explode("-",$data["date_to"]);
                    
                        $start = \Carbon\Carbon::create($date_from[0], $date_from[1], $date_from[2]);
                        $end = \Carbon\Carbon::create($date_to[0], $date_to[1], $date_to[2]);

                        $days = $start->diffInDaysFiltered(function (\Carbon\Carbon $date){ return $date->isWeekday(); }, $end);
                        $weekend = $start->diffInDaysFiltered(function (\Carbon\Carbon $date){ return $date->isWeekend(); }, $end);
                    
                        $days= $days + ($weekend/2);
                    ?>
                    @foreach ($period as $date)

                        @foreach($monthwisereport as $monthwiserpt)

                            @if($date->format('d.m.Y') != date('d.m.Y', strtotime($monthwiserpt->trip_date)))

                                @continue
                                @else
                                <?php //$profit_afn = $profit_afn + ($Profitandloss->currency == "AFN" ? floatval($Profitandloss->total_amount) : 0); ?>
                                <?php //$profit_usd = $profit_usd + ($Profitandloss->currency == "USD" ? floatval($Profitandloss->total_amount) : 0); ?>
                                
                               @if(isset($monthwiserpt->Billed))
                                <tr>
                                    <?php 
                                        if(isset($monthwiserpt->Billed)){
                                            $daysworked++;
                                        }
                                    ?>

                                    <td>
                                        {{$count}}
                                    </td>
                                    <td>
                                        {!! Form::hidden('rr_id[]', $monthwiserpt->rr_id) !!}
                                        {!! Form::hidden('trip_id[]', $monthwiserpt->id) !!}
                                        {{$date->format('d.m.Y')}}
                                        {{-- {{date('d.m.Y', strtotime($monthwiserpt->trip_date))}} --}}
                                    </td>
                                    <td >
                                        <?php $totalbilled +=$monthwiserpt->Billed ?>
                                        {{ $monthwiserpt->Billed }}
                                        
                                    </td>
                                    <td style="text-align: center;">
                                        <?php $totaldetention += $monthwiserpt->Detention ?>
                                        <?php 
                                        if($monthwiserpt->Detention !=0){
                                            $totaldetentionCount += 1;
                                        }
                                        ?>
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
                                    <?php $TripCount++; ?>
                                    <?php $status = 1; ?>
                                @endif
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
                                <td colspan="11" style="    width: 80px;">
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
                            <input type="hidden" id="getTotalDetention" value="{{ $totaldetention }}" >
                            <input type="hidden" id="getDetentionCount" value="{{ $totaldetentionCount }}" >
                            
                        </td>
                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;"> {{$totalbl}} </span>
                            <input type="hidden" value="{{$totalbl}}" id="getTotalBilled">
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
                            <input type="hidden" value="{{$totalexp}}" id="getTotalExpenses">
                        </td>
                        <td style="text-align: center;">

                        </td>
                        <td style="text-align: center;">

                        </td>

                        <td style="text-align: center;">
                            <span style="font-weight: bold;font-size: 16px;">{{$totalreading}}</span>
                            <input type="hidden" value="{{$totalreading}}" id="getTotalReading">
                        </td>
                        <td style="text-align: center;">

                        </td>
                    </tr>
                    </tbody>
                </table>
                {!! Form::hidden("totalDay", $days, ["id"=>"GetTotalWorkingDays"]) !!}
                <input type="hidden" id="Getdaysworked" value="{{ $daysworked }}" >
                <input type="hidden" id="getTripCount" value="{{ $TripCount }}" >
        </div>
    </div>
    <script>
        
        $(document).ready(function() {
            $('#example').DataTable({
                lengthMenu: [[-1,500], ["All",500]],
                "searching": false,
                
                aoColumnDefs: [{ "bVisible": false, "aTargets": [0] }],
               
            } );
        } );
    </script>

    