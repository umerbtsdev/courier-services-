<style>
    ul{
        list-style-type: decimal;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <table id="maintenanceTable" class="table table-striped table-bordered" style="width:100%;    font-size: 11px;">
            <thead>
                <tr>
                    <th>Job Date</th>     
                    <th>Workshop Name</th>     
                    <th>Vehicle No</th>
                    <th>Services Performed</th>     
                    <th>Parts Used</th>     
                    <th>Grand Total</th>     
                </tr>
            </thead>
            <tbody>
                <?php $grand_totals = 0; $jobCount = 0; ?> 
                @foreach ($job_data as $job)
                    <tr>
                        <input type="hidden" name="JobID[]" value="{{ $job->JobID }}">
                        <td>{{ $job->job_date }}</td>
                        <td>{{ $job->workshop_name }}</td>
                        <td>{{ $job->vehicle_no }}</td>
                        <td>
                            <ul>
                                @foreach ($job_details as $job_detail)
                                    @if($job_detail->job_id == $job->JobID)
                                        <li>{{ $job_detail->service_name }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach ($job_details as $job_detail)
                                    @if($job_detail->job_id == $job->JobID)
                                        <li>{{ $job_detail->part_name }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $job->grand_total }}</td>
                        <?php $grand_totals += $job->grand_total; ?>
                        <?php $jobCount++; ?>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <input type="hidden" value="{{ $grand_totals }}" id="getMaintenanceGrandTotal">
        <input type="hidden" value="{{ $jobCount }}" id="getJobCount">
</div>
</div>
<script>

$(document).ready(function() {
    $('#maintenanceTable').DataTable({
        lengthMenu: [[-1,500], ["All",500]],
        "searching": false,       
    } );
} );
</script>