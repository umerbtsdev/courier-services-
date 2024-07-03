@extends('layouts.ajax')
@section('title','Product Reject')
@section('content')

    <section class = 'content'>

        <div class="row">

            {!! Form::open(array('url'=>'product/add','method'=>'POST', 'files'=>true)) !!}
            <div class="col-md-12">

                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Product Information</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Additional Info</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Image</a></li>

                        </ul>
                    </div>

                    <div class="panel-body">

                        <div class="tab-content">

                            <div class="tab-pane fade in active" id="tab1primary">
                                @foreach ($prodata as $prod)
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td>
                                                Sku
                                            </td>
                                            <td>
                                                {{$prod->sku}}
                                            </td>
                                            <td>
                                                Vendor
                                            </td>
                                            <td>
                                                {{$prod->vendor_id}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Category
                                            </td>
                                            <td>
                                                {{$prod->categories_id}}
                                            </td>
                                            <td>
                                                Mode of Fullfillment
                                            </td>
                                            <td>
                                                {{$prod->mode_of_fullfillment}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Qty
                                            </td>
                                            <td>
                                                {{$prod->dropship_qty}}
                                            </td>
                                            <td>
                                                Attribute Sets
                                            </td>
                                            <td>
                                                {{$prod->attribute_set_id}}
                                            </td>
                                        </tr>
                                        <?php $count= 0 ?>

                                        @foreach ($atributedata as $attridata)
                                            @if($attridata->additional_info == 0)
                                                <?php $mod = $count % 2; ?>
                                                @if($mod == 0)
                                                    <tr>
                                                        @endif
                                                        <td>
                                                            {{$attridata->name}}
                                                        </td>
                                                        <td>
                                                            {{$attridata->value}}
                                                        </td>
                                                        @if($mod == 1)
                                                    </tr>
                                                @endif
                                                <?php $count++ ?>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>

                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="tab2primary">

                                <div class="tab2attributearea" >
                                    <table class="table table-striped">
                                        <tbody>
                                        <?php $count= 0 ?>

                                        @foreach ($atributedata as $attridata)
                                            @if($attridata->additional_info == 1)
                                                <?php $mod = $count % 2; ?>
                                                @if($mod == 0)
                                                    <tr>
                                                        @endif
                                                        <td>
                                                            {{$attridata->name}}
                                                        </td>
                                                        <td>
                                                            {{$attridata->value}}
                                                        </td>
                                                        @if($mod == 1)
                                                    </tr>
                                                @endif
                                                <?php $count++ ?>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tab3primary">
                                <div class="col-md-12">
                                    @foreach($files as $file)
                                        <img src="{{url("uploads/".$file->filename)}}" width="150" height="150" />
                                    @endforeach
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection

