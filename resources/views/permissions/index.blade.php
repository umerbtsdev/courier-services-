@extends('layouts.app')
@section('content')

<div class = 'container-fluid'>
    <div class="col-md-12">
        <div class="flash-message">

            <!-- @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach -->

        </div> <!-- end .flash-message -->
    </div>
    <div class="row custom-container-wrap">
        <div class="col-md-12">
                
            <div class="page-heading-primary">
                <span>

                </span>
                <h1>
                    <b>All Permisions</b>

                    <a href="{{url('permissions/create')}}" class = "float-right btn-cus-dessign btn btn-primary waves-effect waves-light">
                    	Add New Permission
                    </a>
                </h1>
            </div>
            
        </div>


            <div class="col-md-12 custom-table-styles">
                <table class="table table-striped tbl-user-styled">
    				<head>
    					<th>Permissions</th>
    					<th>Actions</th>
    				</head>
    				<tbody>
    					@foreach($permissions as $permission)
    					<tr>
    						<td style="text-align: right; width: 50%" class="user-col-1">{{$permission->name}}</td>
    						<td style="width: 50%">
    							<a href="{{url('/permissions/edit')}}/{{$permission->id}}" style="display: inline-block; padding: 5px 10px;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light"> Edit Permision </a>
    							<a href="{{url('/permissions/delete')}}/{{$permission->id}}" style="display: inline-block; padding: 5px 10px;" class = "btn-cus-dessign btn btn-primary waves-effect waves-light"> Delete Permision </a>
    						</td>
    					</tr>
    					@endforeach
    				</tbody>
    			</table>
            </div>

    </div>
</div>

@endsection