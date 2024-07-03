@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="card card-pages shadow-none col-md-8">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">

                </div>
                <h5 class="font-18 text-center">Falcon Courier and logistics Customer Registration</h5>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-horizontal m-t-30" action="{{ url('/register') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="form-group col-md-4">
        <label for="">First Name</label>
        <input type="text" name = "first_name" id="first_name" class = "form-control" placeholder = "first name" required="true">
    </div>
    <div class="form-group col-md-4">
        <label for="">Last Name</label>
        <input type="text" name = "last_name" id="last_name" class = "form-control" placeholder = "last name" required="true">
    </div>
    <div class="form-group col-md-4">
        <label>Email</label>
        <input class="form-control" type="text" id="email" name="email" required="required" placeholder="Email">
    </div>
    <div class="form-group col-md-4">
        <label>Username</label>
        <input class="form-control" type="text" id="name" name="name" required="required" placeholder="Username">
    </div>
    <div class="form-group col-md-4">
        <label>Password</label>
        <input class="form-control" type="password" id="password" name="password" required="required" placeholder="Password">
    </div>
    <div class="form-group col-md-4">
        <label>Retype Password</label>
        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required="required" placeholder="Password">
    </div>
    <div class="form-group col-md-4">
        <label for="">Contact No</label>
        <input type="text" name="contact_no" id="contact_no" class = "form-control" placeholder = "Contact No" required="true">
    </div>

    <div class="form-group col-md-4">
        <label for="">Alternate No</label>
        <input type="text" name="alernate_no" id="alernate_no" class = "form-control" placeholder = "Phone No" required="true">
    </div>
    <div class="form-group col-md-4">
        <label for="">Country</label>
        <select name="country_id" id="country_id" class = "form-control" required="true">
            <option value=""> Select Country </option>
            @foreach($countries as $country)
                <option value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="">city</label>
        <select name="city_id" id="city_id" class = "form-control" required="true">
            <option value=""> Select City </option>
            @foreach($cities as $city)
                <option value="{{$city->id}}">{{$city->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="">CNIC</label>
        <input type="text" name="cnic" id="cnic" class = "form-control" placeholder = "Cnic" required="true">
    </div>
    <div class="form-group col-md-4">
        <label for="">Bank</label>
        <input type="text" name="bank_name" id="bank_name" class = "form-control" placeholder = "Bank">
    </div>
    <div class="form-group col-md-4">
        <label for="">Branch</label>
        <input type="text" name="branch_name" id="branch_name" class = "form-control" placeholder = "Branch" >
    </div><div class="form-group col-md-4">
        <label for="">Account #</label>
        <input type="text" name="account_no" id="account_no" class = "form-control" placeholder = "account no"">
    </div>
    <div class="form-group col-md-4">
        <label for="">Account Title</label>
        <input type="text" name="account_title" id="account_title" class = "form-control" placeholder = "Account Title" >
    </div>
    <div class="form-group col-md-4">
        <label for="">Birth Date</label>
        <input type="date" name="brith_date" id="brith_date" class = "form-control" placeholder = "date of birth">
    </div>
    <div class="form-group col-md-4">
        <label for="">Anniversary Date</label>
        <input type="date" name="anniversary_date" id="anniversary_date" class = "form-control" placeholder = "Phone No" >
    </div>

        <div class="form-group col-md-4">
            <label for="">Address</label>
            <input type="text" name="address" id="address" class = "form-control" placeholder = "Address" required="true">
        </div>
</div>

                    <div class="form-group">
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" required="required" id="customCheck1">
                                <label class="custom-control-label font-weight-normal" for="customCheck1">I accept <a href="#" class="text-primary">Terms and Conditions</a></label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mb-0 row">
                        <div class="form-group text-center m-t-20 col-12">
                            <div class="col-4" style="display: inline-block;">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Register</button>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mb-0 row">
                        <div class="col-12 m-t-10 text-center">
                            <a href="{{ url('/login') }}" class="text-muted">Already have account?</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- END wrapper -->
@endsection