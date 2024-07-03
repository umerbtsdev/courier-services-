<?php

namespace App\Http\Controllers;

use Mgallegos\LaravelJqgrid\Facades\GridEncoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB,Auth;
use App\Model\Manufacturers\manufacturers;
use App\Model\Manufacturers\manufacturersDataRepository;
use App\Model\Parts\parts;
use App\Model\Parts\partsDataRepository;
use App\Model\Services\services;
use App\Model\Services\servicesDataRepository;
use App\Model\Job\job_data;
use App\Model\Job\job_details;
use App\Model\Job\jobsDataRepository;
use App\Model\Workshop\workshops;
use App\Model\VehiclesManagment\Vehicles;
use App\Model\MaintenanceRequests\maintenance_request;
use App\Model\MaintenanceRequests\maintenance_request_schedule;
use App\Model\MaintenanceRequests\maintenance_requestDataRepository;
use App\Model\Projects\projects;
use App\Model\JobProcessingSchedule\JobProcessingScheduleDataRepository;

class WorkshopController extends Controller
{
    //#region Manufacturers
        public function ManufacturerHome(){
            return view('manufacturers.index');
        }
        public function ManufacturerGridData(){
            GridEncoder::encodeRequestedData(new manufacturersDataRepository(), Input::all());
        }

        public function ManufacturerAdd(){
            return view('manufacturers.create');
        }
        public function ManufacturerSave(Request $request){

            $data=[
                "name" => $request->input('manufacturer_name'),
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => Auth::User()->id
            ];
            manufacturers::insert($data);

            return redirect('/workshops/Manufacturers');
        }
        public function ManufacturerEdit($id){

            $manufacturers = manufacturers::find($id);
            return view('manufacturers.edit', compact('manufacturers'));
        }
        public function ManufacturerUpdate(Request $request){

            $id= $request->input('Manu_id');
            $data=[
                "name" => $request->input('manufacturer_name'),
                "updated_at" => date('Y-m-d H:i:s'),
                "updated_by" => Auth::User()->id
            ];

            manufacturers::where('id','=', $id)->update($data);
            return redirect('/workshops/Manufacturers');
        }
        public function ManufacturerDelete($id){
            return view('manufacturers.delete', compact('id'));
        }
        public function ManufacturerDeleted(Request $request){
            $id= $request->input('manufacturer_id');
            manufacturers::find($id)->delete();
            return redirect('/workshops/Manufacturers');
        }
    //#endregion

    //#region Parts
        
        public function PartsHome(){
            return view('parts.index');
        }

        public function PartsGridData(){
            GridEncoder::encodeRequestedData(new partsDataRepository(), Input::all());
        }
        public function addPart(){
            $manufacturers = manufacturers::pluck("name","id");
            return view('parts.create', compact('manufacturers'));
        }
        public function SavePart(Request $request){
            $m_id = $request->input('m_id');
            $part_name = $request->input('part_name');

            $data = [
                "manufacturer_id" => $m_id,
                "part_name" => $part_name,
                "created_by" => Auth::user()->id,
                "created_at" => date("Y-m-d H:i:s")
            ];
            parts::insert($data);
            return redirect('/workshops/Parts');

        }

        public function EditPart($id){
            $manufacturers = manufacturers::pluck("name","id");
            $parts = parts::where("part_id",'=',$id)->first();
            return view('parts.edit',compact('parts','manufacturers'));
        }

        public function UpdatePart(Request $request){
            $part_id = $request->input('part_id');
            $part_name = $request->input('part_name');
            $m_id = $request->input('m_id');

            $data=[
                "manufacturer_id"   => $m_id,
                "part_name"         =>  $part_name,
                "updated_by"        => Auth::User()->id,
                "updated_at"        => date("Y-m-d H:i:s")
            ];
            parts::where("part_id",'=',$part_id)->update($data);
            return redirect('/workshops/Parts');
        }

        public function DeletePart($id){
            return view('parts.delete', compact('id'));
        }
        public function DeletedPart(Request $request){
            $id = $request->input('part_id');
            parts::where("part_id",'=',$id)->delete();
            return redirect('/workshops/Parts');
        }

    //#endregion

    //#region services

        public function servicesHome(){
            return view('services.index');
        }

        public function servicesGridData(){
            GridEncoder::encodeRequestedData(new servicesDataRepository(), Input::all());
        }

        public function addService(){
            return view('services.create');
        }
        public function saveService(Request $request){
            $data=[
                "service_name" => $request->input('service_name'),
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => Auth::User()->id
            ];
            services::insert($data);

            return redirect('/setup/services');
        }

        public function editService($id){
            $services = services::find($id);
            return view('services.edit', compact('services'));
        }

        public function updateService(Request $request){
            $id = $request->input('service_id');
            $data=[
                'service_name' =>$request->input('service_name'),
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            services::where('id','=',$id)->update($data);
            return redirect('/setup/services');

        }
        public function deleteService($id){
            return view('services.delete', compact('id'));
        }
        public function deletedService(Request $request)
        {
            $id = $request->input('service_id');
            services::where('id','=',$id)->delete();
            return redirect('/setup/services');
        }
    //#endregion

    //#region Jobs
        public function JobsHome(){
            return view('jobs.index');
        }
        public function JobsGridData(){
            GridEncoder::encodeRequestedData(new jobsDataRepository(), Input::all());
        }

        public function addJob(){
            $services = services::get();
            $Vehicles = Vehicles::get();
            $workshops = workshops::get();
            $projects = projects::get();
            $parts = parts::get();
            return view('jobs.create',compact('services','Vehicles','parts','workshops','projects'));
        }

        public function saveJob(Request $request){

            
            $job_date = $request->input('job_date');
            $vehicle = $request->input('vehicle');
            $workshop = $request->input('workshop');

            $project_id = $request->input('project');
            $service_id = $request->input('service_id');
            $service_description = $request->input('service_description');
            $service_amount = $request->input('service_amount');

            $external_part_id = $request->input('external_part_id');
            $external_part_description = $request->input('external_part_description');
            $external_part_amount = $request->input('external_part_amount');
            $loop=0; $total =0;
            foreach($service_amount as $s_amount){
                $total += $s_amount;
                
            }
            foreach($external_part_amount as $e_p_amount){
                $total += $e_p_amount;
            }
            
            $job_data = new job_data();
                $job_data->vehicle_id = $vehicle;
                $job_data->grand_total = $total;
                $job_data->created_by = Auth::user()->id;
                $job_data->created_at = date('Y-m-d H:i:s');
                $job_data->job_date = $job_date;
                $job_data->workshop_id = $workshop;
                $job_data->project_id = $project_id;
            $job_data->save();


            $loop = 0;
            foreach ($service_id as $service) {
                $job_details = new job_details();
                    $job_details->job_id = $job_data->id;
                    $job_details->service_id = $service_id[$loop];
                    $job_details->service_amount = $service_amount[$loop];
                    $job_details->service_description = $service_description[$loop];
                    $job_details->part_id = $external_part_id[$loop];
                    $job_details->part_amount = $external_part_amount[$loop];
                    $job_details->part_description = $external_part_description[$loop];
                $job_details->save();
                $loop++;
            }

            return redirect('workshops/Jobs');
        }

        public function editJob($id){
            $services = services::get();
            $Vehicles = Vehicles::get();
            $workshops = workshops::get();
            $parts = parts::get();
            $projects = projects::get();
            //job_data  

            $job_data = job_data::select(
                'job_data.id',
                'job_data.vehicle_id',
                'job_data.grand_total',
                'job_data.job_date',
                'job_data.workshop_id'
            )->where('job_data.id','=',$id)->first();

            $job_details_services = job_details::select(
                'job_details.id',
                'job_details.service_id',
                'job_details.service_amount',
                'job_details.service_description'
            )->where('job_details.job_id', '=',$id)->get();

            $job_details_parts = job_details::select(
                'job_details.part_id',
                'job_details.part_description',
                'job_details.part_amount'
            )->where('job_details.job_id', '=',$id)->get();

            /*dump($job_data);
            dd($job_details);*/
            return view('jobs.edit',compact('projects','services','Vehicles','parts','workshops','job_data','job_details_services','job_details_parts'));
        }

        public function updateJob(Request $request){
            $job_id = $request->input('job_id');
            $job_date = $request->input('job_date');
            $vehicle = $request->input('vehicle');
            $workshop = $request->input('workshop');

            $service_id = $request->input('service_id');
            $service_description = $request->input('service_description');
            $service_amount = $request->input('service_amount');

            $external_part_id = $request->input('external_part_id');
            $external_part_description = $request->input('external_part_description');
            $external_part_amount = $request->input('external_part_amount');
            $detail_id = $request->input('detail_id');
            $loop=0; $total =0;
            foreach($service_amount as $s_amount){
                $total += $s_amount;
                
            }
            foreach($external_part_amount as $e_p_amount){
                $total += $e_p_amount;
            }

            $job_data = job_data::where('id','=',$job_id)->first();
                $job_data->vehicle_id = $vehicle;
                $job_data->grand_total = $total;
                $job_data->updated_by = Auth::user()->id;
                $job_data->updated_at = date('Y-m-d H:i:s');
                $job_data->job_date = $job_date;
                $job_data->workshop_id = $workshop;
            $job_data->save();


            $loop = 0;
            foreach ($detail_id as $detail_id) {
                $job_details = job_details::where('job_id','=',$job_id)->where('id','=',$detail_id)->first();
                    $job_details->service_id = $service_id[$loop];
                    $job_details->service_amount = $service_amount[$loop];
                    $job_details->service_description = $service_description[$loop];
                    $job_details->part_id = $external_part_id[$loop];
                    $job_details->part_amount = $external_part_amount[$loop];
                    $job_details->part_description = $external_part_description[$loop];
                $job_details->save();
                $loop++;
            }

            return redirect('workshops/Jobs');
        }

        public function deleteJob($id){
            return view('jobs.delete', compact('id'));
        }

        public function deletedJob(Request $request){
            $id = $request->input('job_id');
            $job_data = job_data::find($id);

            $job_data->delete();

            job_details::where("job_id",'=',$id)->delete();

            return redirect('workshops/Jobs');
        }

        public function viewJob($id)
        {

            $job_data = job_data::leftjoin('vehicles','job_data.vehicle_id','=','vehicles.id')
            ->leftjoin('workshops','job_data.workshop_id','=','workshops.workshop_id')
            ->select(
                'job_data.id',
                'vehicles.vehicle_no',
                'job_data.grand_total',
                'job_data.job_date',
                'workshops.workshop_name',
                'workshops.workshop_location'
            )->where('job_data.id','=',$id)->first();

            $job_details_services = job_details::join('services','job_details.service_id','=','services.id')
            ->join('parts','job_details.part_id','=','parts.part_id')
            ->leftjoin('manufacturers','parts.manufacturer_id','=','manufacturers.id')
            ->select(
                'services.service_name',
                'job_details.service_amount',
                'job_details.service_description',
                'parts.part_name',
                'job_details.part_description',
                'job_details.part_amount',
                'manufacturers.name as m_name'
            )->where('job_details.job_id', '=',$id)->get();

            // $job_details_parts = job_details::join('parts','job_details.part_id','=','parts.part_id')
            // ->leftjoin('manufacturers','parts.manufacturer_id','=','manufacturers.id')
            // ->select(
            //     'parts.part_name',
            //     'job_details.part_description',
            //     'job_details.part_amount',
            //     'manufacturers.name'
            // )->where('job_details.job_id', '=',$id)->get();

            return view('jobs.view',compact('job_data','job_details_services'));
        }
    //#endregion

    //#region maintenance Schedule
        public function maintenanceScheduleHome(){
           return view('maintenanceSchedule.index');
        }
        public function maintenanceScheduleGridData(){
            GridEncoder::encodeRequestedData(new maintenance_requestDataRepository(), Input::all());
        }
        public function maintenanceScheduleAdd(){
            $vehicles = Vehicles::get();
           return view('maintenanceSchedule.create', compact('vehicles'));
        }
        public function maintenanceScheduleSave(Request $request){
            
            $vehicle = $request->input('vehicle');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $delay_days = $request->input('delay_days');
            $dates = $request->input('dates');

            $maintenance_request = new maintenance_request;
            $maintenance_request->vehicle_id = $vehicle;
            $maintenance_request->from_date = $from_date;
            $maintenance_request->to_date   = $to_date;
            $maintenance_request->days_delay = $delay_days;
            $maintenance_request->created_by = Auth::User()->id;
            $maintenance_request->created_at = date("Y-m-d H:i:s");
            $maintenance_request->save();
                
                foreach($dates as $date){
                    $schedule_data=[
                        'request_id' =>$maintenance_request->id,
                        'date' => $date,
                        'status' => 0
                    ];

                    maintenance_request_schedule::insert($schedule_data);

                }
            return redirect('/workshops/maintenance-schedule');
            
        }

        public function maintenanceScheduleView($id)
        {
            $maintenance_request = maintenance_request::join('vehicles','maintenance_request.vehicle_id','=','vehicles.id')
            ->select(
                'maintenance_request.id',
                'maintenance_request.from_date',
                'maintenance_request.to_date',
                'maintenance_request.days_delay',
                'vehicles.vehicle_no'
            )
            ->where('maintenance_request.id' ,'=',$id)->first();
            $maintenance_request_schedules = maintenance_request_schedule::where('request_id','=',$maintenance_request->id)->get();

            return view('maintenanceSchedule.view', compact('maintenance_request','maintenance_request_schedules'));
            
        }

        public function maintenanceScheduleDelete($id)
        {
            return view('maintenanceSchedule.delete', compact('id'));
        }

        public function maintenanceScheduleDeleted(Request $request)
        {
            $id = $request->input('schedule_id');
            $maintenance_request = maintenance_request::find($id);

            $maintenance_request->delete();

            maintenance_request_schedule::where("request_id",'=',$id)->delete();

            return redirect('/workshops/maintenance-schedule');            
        
        }

        public function maintenanceScheduleEdit($id)
        {
            $vehicles = Vehicles::get();
            $maintenance_request = maintenance_request::select(
                'id',
                'from_date',
                'to_date',
                'days_delay',
                'vehicle_id'
            )
            ->where('maintenance_request.id' ,'=',$id)->first();
            $maintenance_request_schedules = maintenance_request_schedule::where('request_id','=',$maintenance_request->id)->get();

            return view('maintenanceSchedule.edit', compact('maintenance_request','maintenance_request_schedules', 'vehicles'));
        }
        public function maintenanceScheduleUpdate(Request $request)
        {
            $id = $request->input('schedule_id');
            $vehicle = $request->input('vehicle');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $delay_days = $request->input('delay_days');
            $dates = $request->input('dates');

            $maintenance_request = maintenance_request::where('id','=',$id)->first();
            $maintenance_request->vehicle_id = $vehicle;
            $maintenance_request->from_date = $from_date;
            $maintenance_request->to_date   = $to_date;
            $maintenance_request->days_delay = $delay_days;
            $maintenance_request->created_by = Auth::User()->id;
            $maintenance_request->created_at = date("Y-m-d H:i:s");
            $maintenance_request->save();

            maintenance_request_schedule::where("request_id",'=',$id)->delete();    

            foreach($dates as $date){
                $schedule_data=[
                    'request_id' =>$maintenance_request->id,
                    'date' => $date,
                    'status' => 0
                ];
                maintenance_request_schedule::insert($schedule_data);
            }
            return redirect('/workshops/maintenance-schedule');
        }
    //#region

    //#region schedule-job-processing
        public function scheduleJobProcessingHome()
        {
            return view('scheduleJobProcessing.index');
        }
        public function scheduleJobProcessingGridData()
        {
            GridEncoder::encodeRequestedData(new JobProcessingScheduleDataRepository(), Input::all());
        }

        public function scheduleJobProcessingPerformView($id)
        {
            $maintenance_request_schedule = maintenance_request_schedule::join('maintenance_request','maintenance_request_schedule.request_id','=','maintenance_request.id')
            ->leftjoin('vehicles','maintenance_request.vehicle_id','=','vehicles.id')
            ->select(
                'maintenance_request_schedule.date as sjp_date',
                'vehicles.vehicle_no',
                'maintenance_request.vehicle_id'
              )
              ->where('maintenance_request_schedule.id','=',$id)
              ->first();

            $services = services::get();
            $workshops = workshops::get();
            $projects = projects::get();
            $parts = parts::get();
            return view('scheduleJobProcessing.createJob', compact('projects','maintenance_request_schedule','services','parts','workshops','id'));
            
        }
        public function scheduleJobProcessingPerformJob(Request $request)
        {
            //ADD NORMAL JOB
            $this->saveJob($request);

            //Update status on current schedule

            //sjpid
            $sjpid = $request->input('sjpid');
            $maintenance_request_schedule = maintenance_request_schedule::find($sjpid);
            $maintenance_request_schedule->status = 1;
            $maintenance_request_schedule->save();
            return redirect('/workshops/schedule-job-processing');
        }
    //#endregion
}
