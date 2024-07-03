
@extends('layouts.app')
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
    </div>

    <div class="row custom-container-wrap product-bulk-upload">
        <div class="row">
            <div class="col-md-12">

                <div class="page-heading-primary">
                <span>

                </span>
                    <h1>
                        <b> Booking Bulk Upload </b>

                        <!-- button -->
                        <!-- button goes here with classes "viewproduct custom-btn-view bgcolr-aqua" -->
                        <!-- button -->
                    </h1>
                </div>

            </div>
        </div>



            <div class="col-md-12 custom-table-styles">
                @if($isEnable == 1)
                    <div class="form-group csvUploadField" >
                        <div class="row">
                            <div class="col-md-7" style="background: #f3f3f3;">
                                {!! Form::open(array('url'=>'product/bulkproductSubmit','method'=>'POST','id'=>'bluk_product_form', 'files'=>true)) !!}
                                <div class="row">
                                <div class="col-md-12 no-padding csv-wrap" style="height: 180px;">
                                    <div class="col-md-3 bulk-img-wrap no-padding">
                                        <img src="{{ url('img/custom')}}/icon-csv-lg.png" style="height: 50px">
                                    </div>

                                    <div class="col-md-9 no-padding">
                                        <h3 class="sub-heading"> Upload Booking CSV </h3>
                                        <p class="help-block uploaded-file-name" style="clear: both; display: block;">upload your csv here.</p>
                                        <!-- <span class="uploaded-file-name" style="height: 20px; display: block;"></span> -->
                                        <div class="btn_upload_wrapper">
                                            <input type="file" class="imagerequired" id="product_csv" name="product_csv">
                                            <em class="viewproduct custom-btn-view bgcolr-aqua">
                                                <i class="fa fa-upload"></i>
                                                Choose File
                                            </em>
                                        </div>

                                    </div>
                                </div>

                                </div>
                                <div class="row">
                                <div class="col-md-12 no-padding">
                                    {!! Form::submit('Click to upload', array('style'=>'width: 100%; padding: 20px; font-size: 20px; text-transform: uppercase; margin-bottom: 15px;', 'class'=>'btn btn btn-primary bgcolr-orange btn-primary bulkuploadbtn')) !!}
                                    {!! Form::close() !!}
                                </div>
                                </div>
                            </div>
                            <div class="col-md-5" style="background: #fff;">
                                <div class="col-md-3 bulk-img-wrap no-padding" style="height: 120px;">
                                    <img src="{{ url('img/custom')}}/icon-download-lg.png" style="height: 50px">
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="form-group">
                                        {!! Form::open(array('url'=>'/booking/sampleCSVDownload','method'=>'POST','id'=>'bluk_product_csv', 'files'=>true)) !!}
                                        <div class="">
                                            <h3 class="sub-heading"> Download Sample Booking File </h3>
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>

                                    <!-- <p class="help-block ">Click <input type="submit" class="csv_download_button" value="Here" style="background: transparent; border: 0px; color: blue; text-decoration: underline; padding: 0px;"></input> to download the sample of above mention categories </p> -->
                                </div>
                                <div class="col-md-12 no-padding">
                                    <input type="submit" class="btn btn-primary csv_download_button bgcolr-aqua" value="Download sample Booking File" style="width: 100%; padding: 20px; font-size: 20px; text-transform: uppercase; margin-bottom: 15px;"></input>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                    <!-- <div class="box-footer"></div> -->
                    @foreach ($responce as $res)
                        @if(strpos($res,"Succesfully") !== false)
                            <p class="success-log">{{$res}}</p>
                        @else
                            <p class="error-log" ><?php echo $res;?></p>
                        @endif
                    @endforeach
                @endif
            </div>

    </div>
@endsection