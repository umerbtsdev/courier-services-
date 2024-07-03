
@extends('layouts.app')
@section('content')



<div class="bgcolr-grey">
    @if(Request::session()->has('user_create_status'))
        @if(Request::session()->pull('user_create_status') == 'error')
            <div class="alert alert-danger">{{Request::session()->pull('user_create_message')}}</div>
        @endif
    @endif

    <div class="box-body">
        <form action="{{url('transaction/singlebookingstore')}}" method = "post"  autocomplete="off">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-10">
                    <div class="page-heading-primary">
                        <h2>
                            <b>Order Booking</b>
                        </h2>

                    </div>

                </div>
                <div class="col-md-2">
                    <button style="float: right;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="submit">Place Order</button>
                </div>
             
            </div>


                    <div class="row">
                         <div class="col-md-4 col-xl-4 display-inline">
                               <label for="">Consignment Note: </label>
                               <input type="text" name="cn_no_auto" id="cn_no_auto" class = "form-control">
                             
                         </div>

                           <div class="col-md-2 col-xl-2 display-inline">
                                <button style="margin-top: 15%" class = "btn-cus-dessign btn btn-primary waves-effect waves-light" type="button">Print</button>
                             
                         </div>
                      
                   </div>

                   <br>

            <div class="row">
                <div class="col-md-6 col-xl-6 display-inline"  >
                    <div class="card m-b-30">
                        <div class="card-body">
                             <h4>
                            <b>Shipper Information</b>
                           </h4>

                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Cost Center</label>
                                <select name = "cost_center" id="cost_center" disabled="true" class = "form-control">
                                    @foreach($costcenters as $costcenter)
                                        <option value="{{$costcenter->id}}"> {{$costcenter->name}} </option>
                                    @endforeach
                                </select>
                            </div>

                                <div class="form-group col-md-6 display-inline">
                                <label for="">Name</label>
                                <input type="text" name="name" {{(isset($customer->first_name) ? "readonly='readonly'" : "")}} value="{{(isset($customer->first_name) ? $customer->first_name : "") ." ".(isset($customer->last_name) ?  $customer->last_name : "") }}" id="name" class = "form-control" placeholder = "Name" disabled="true">
                            </div>

                            </div>
                            <div class="row">
                               <div class="form-group col-md-6 display-inline">
                                <label for="">Email </label>
                                <input type="email" value="{{(isset($customer->email) ? $customer->email : "" )}}" {{(isset($customer->email) ? "readonly='readonly'" : "" )}} name="email" id="email" class="form-control" placeholder="Email" disabled="true">
                            </div>



                                <input type="hidden" name="consignee_id" value="{{(isset($customer->id) ? $customer->id : "")}}" id="consignee_id" />
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Delivery Type</label>
                                <select name = "delivery_type" id="delivery_type" class = "form-control" placeholder="Delivery Type" disabled="true">
                                    <option value=""> select Delevery Type</option>
                                    @foreach($deliverytypes as $deliverytype)
                                        <option value="{{$deliverytype->id}}">{{$deliverytype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">City </label>
                                <select name = "city" id="city" {{ (isset($customer->city_id) ? "readonly='readonly'" : "")}} class = "form-control" placeholder="City" disabled="true">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        @if(isset($customer->city_id))
                                            @if($customer->city_id ==  $city->id)
                                                <option value="{{$city->id}}" selected="selected">{{$city->name}}</option>
                                            @else
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endif
                                        @else
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-6 display-inline">
                                <label for="">Contact </label>
                                <input type="text" name="contact" value="{{(isset($customer->contact_no) ? $customer->contact_no : "")}}" {{(isset($customer->contact_no) ? "readonly='readonly'" : "")}}  id="contact" class="form-control" placeholder="contact" disabled="true">
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-12 display-inline">
                                <label for="">Address</label>
                                <input type="text" name="address" value="{{(isset($customer->address) ? $customer->address : "")}}" {{(isset($customer->address) ? "readonly='readonly'" : "")}} id="address" class="form-control" placeholder="Address" disabled="true">
                            </div>
                         
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6 display-inline" >

                    <div class="card m-b-30">
                        <div class="card-body">
                                <h4>
                            <b>Consignee Information</b>
                           </h4>
                            <div class="row">
                                <div class="form-group col-md-12 display-inline">
                                    <label for="">Consignee Ref: </label>
                                    <input type="text" name="cn_no" id="cn_no" class = "form-control" placeholder = "Congiment Number">
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6 display-inline">
                                <label for="">Customer Name </label>
                                <input type="text" name="customer_name" id="customer_name" class = "form-control" placeholder = "Customer Name" required="true">
                            </div>
                                <div class="form-group col-md-6 display-inline">
                                    <label for="">Contact Number </label>
                                    <input type="text" name="customer_contact_number" id="customer_contact_number" class = "form-control" placeholder = "Contact Number" required="true">
                                </div>
                            </div>
                            <div class="row">

                            <div class="form-group col-md-6 display-inline">
                                <label for="">Email </label>
                                <input type="email" name="customer_email" id="customer_email" class = "form-control" placeholder = "Email">


                            </div>
                                <div class="form-group col-md-6 display-inline">
                                    <label for="">Contact Person </label>
                                    <input type="text" name="customer_contact_person" id="customer_contact_person" class = "form-control" placeholder = "Contact Person">
                                </div>
                            </div>
                                <div class="row">
                                    <div class="form-group col-md-12 display-inline">
                                        <label for="">Address </label>
                                        <input type="text" name="address" id="address" class = "form-control" placeholder = "Address" required="true">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                            <h4>
                            <b>Shipment Information</b>
                           </h4>
                        <div class="row">
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Pieces</label>
                            <input type="number" name="pieces" id="pieces" class = "form-control" placeholder = "Pieces" required="true">
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Weight</label>
                            <input type="number" step=0.01 name="weight" id="weight" class="form-control" placeholder="Weight in kg" required="true">
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Fragile</label>
                            <select name="fragile" id="fragile" class="form-control" placeholder="Fragile" >
                                <option value="">Select Fragile</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Origin </label>
                            <select name="origin" id="origin" class="form-control" placeholder="Origin" required="true">
                                <option value="">Origin</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Destination Country</label>
                            <select name = "destination_country" id="destination_country" class="form-control" placeholder="Destination Country" required="true">
                                <option value="">Destination Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Destination City</label>
                            <select name="destination_city" id="destination_city" class="form-control" placeholder="Destination City" required="true">
                                <option value=""> Destination City</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">COD Amount</label>
                            <input type="text" name="cod_amount" id="cod_amount" class = "form-control" placeholder="Cod Amount" required="true">
                        </div>
                        <div class="form-group col-md-3 display-inline">
                            <label for="">Product Detail</label>
                            <input type="text" name="product_detail" id="product_detail" class = "form-control" placeholder = "Product Detail">
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-3">
                            <label for="">Insurance / Declared Value</label>
                            <input type="text" name="insurance" id="insurance" class = "form-control" placeholder = "Insurance / Declared Value">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Service</label>
                            <select name = "service" id="service" class = "form-control" placeholder = "Service">
                                <option value="">Select Services</option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Remarks</label>
                            <input type="text" name="remarks" id="remarks" class = "form-control" placeholder = "Remarks" required="true">
                        </div>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection