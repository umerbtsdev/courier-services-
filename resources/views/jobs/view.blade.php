<style>
    table tfoot tr td{
        border-top:2px solid #929493 !important
    }
    .dispBox{
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 0px 4px 0px rgba(0,0,0,.075);
        box-shadow: inset 0 0px 4px 0px rgba(0,0,0,.075);
        margin-right:10px;
        padding: 5px;
    }
    table{
        box-shadow: inset 0 0px 10px 0px rgba(0,0,0,.075);
    }
   /* .right-single-border{
        border-right:1px solid black !important;
    }
    .bottom-single-border{
        border-bottom:1px solid black !important;
    }*/
</style>
<div class = 'container-fluid'>
    <div class="col-md-12" style="padding:0; margin-bottom:4%;">
        <div class="col-md-10">
            <div class="form-group dispBox col-sm-2">
                <label for="job_date" class="control-label ">Job Date </label>
                <p>{{ $job_data->job_date }}</p>
            </div>
            <div class="form-group dispBox col-sm-2">
                <label for="job_date" class="control-label">Workshop </label>
                <p>{{ $job_data->workshop_name }}</p>
            </div>
            <div class="form-group dispBox col-sm-2">
                <label for="vehicle" class="control-label ">Vehicle </label>
                <p>{{ $job_data->vehicle_no }}</p>
            </div>
            <div class="form-group dispBox col-sm-2">
                <label for="vehicle" class="control-label ">Grand Total </label>
                <p>{{ $job_data->grand_total }}</p>
            </div>
        </div>
        
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
            <table class="table table-striped table-bordered dt-responsive nowrap" width="100%" style="text-align:center" id="jobs-table">
                <thead>
                    <tr>
                        <td></td>
                        <td colspan="3" class="text-center right-single-border">Services</td>
                        <td colspan="4" class="text-center">Parts</td>
                    </tr>
                    <tr>
                        <td>#</td>
                        <td class="col-md-2">Service Name</td>
                        <td class="col-md-2">Service Description</td>
                        <td class="col-md-2 right-single-border">Service Charges</td>
                        <td class="col-md-2">Part Name</td>
                        <td class="col-md-3">Part Manufacturer</td>
                        <td class="col-md-3">Part Description</td>
                        <td class="col-md-2">Part Charges</td>
                    </tr>
                </thead>
                <tbody><?php $i=1; $service_charges=0; $part_charges=0;?>
                    @foreach ($job_details_services as $job_details_service)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $job_details_service->service_name }}</td>
                            <td>{{ $job_details_service->service_description }}</td>
                            <td class="right-single-border">{{ $job_details_service->service_amount }}</td>
                            <td>{{ $job_details_service->part_name }}</td>
                            <td>{{ $job_details_service->m_name }}</td>
                            <td>{{ $job_details_service->part_description }}</td>
                            <td>{{ $job_details_service->part_amount }}</td>
                        </tr>
                        <?php $i++; $service_charges+=$job_details_service->service_amount;  $part_charges+=$job_details_service->part_amount; ?>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr >
                        <td class="bottom-single-border"></td>
                        <td class="bottom-single-border"></td>
                        <td class="bottom-single-border"></td>
                        <td class="bottom-single-border right-single-border"><strong>{{ $service_charges }}</strong></td>
                        <td class="bottom-single-border"></td>
                        <td class="bottom-single-border"></td>
                        <td class="bottom-single-border"></td>
                        <td class="bottom-single-border"><strong>{{ $part_charges }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    jQuery("#jobs-table").DataTable({
        searching: false,
        ordering:  false,
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "pageLength": 50,
    });
</script>