<div class = 'container-fluid'>
        <div class="col-md-12" style="padding:0; margin-bottom:4%;">
            <div class="col-md-12">
                <div class="form-group col-sm-3" style="display:grid">
                    <label for="vehicle" class="control-label required">Vehicle: </label>
                    <label id="vehicle" class="form-control">{{ $maintenance_request->vehicle_no }}</label>
                </div>
                <div class="form-group col-sm-3">
                    <label for="from_date" class="control-label required">Start From </label>
                    <label id="from_date" class="form-control">{{ $maintenance_request->from_date }}</label>
                </div>
                <div class="form-group col-sm-3">
                    <label for="to_date" class="control-label required">End On </label>
                    <label id="to_date" class="form-control">{{ $maintenance_request->to_date }}</label>
                </div>
                <div class="form-group col-sm-3">
                    <label for="delay_days" class="control-label required">Delay (in days) </label>
                    <label id="delay_days" class="form-control">{{ $maintenance_request->days_delay }}</label>
                </div>
            </div>
        </div>
        
    </div>
    <div class = 'container-fluid' id="generatedTable">
        <table class='table dataTable table-bordered' width='100%'>
            <thead>
                <tr>
                    <th>Date</th>
                    {{-- <th>Vehicle</th> --}}
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maintenance_request_schedules as $MRschedule)
                    <tr>
                        <td>{{ $MRschedule->date }}</td>
                        {{-- <td>{{ $maintenance_request->vehicle_no }}</td> --}}
                        <td>{{ ($MRschedule->status ==0 ? "Not active" : "Active") }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>