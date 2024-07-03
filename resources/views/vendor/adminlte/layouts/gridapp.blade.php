<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('adminlte::layouts.partials.htmlheader')
    @include('adminlte::layouts.partials.gridscripts')
@show


<body class="skin-blue sidebar-mini">

<!-- Main Header -->
<!-- skin chooser -->
<div class="skin-choser">
</div>
<!-- skin chooser -->

<div id="app" v-cloak>
    <div class="wrapper">

        @include('adminlte::layouts.partials.mainheader')

         {{--@include('adminlte::layouts.partials.sidebar') --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            {{--@include('adminlte::layouts.partials.contentheader')--}}
            @if(config('adminlte.layout') == 'top-nav')
                <div class="container">
                @endif

                <!-- Content Header (Page header) -->
                    <section class="content-header">
                        @yield('content_header')
                    </section>

            <!-- Main content -->
            <section  class="content">
                <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
                <!-- /.content -->
                @if(config('adminlte.layout') == 'top-nav')
        </div>
            <!-- /.container -->
            @endif
        </div><!-- /.content-wrapper -->

        {{-- @include('adminlte::layouts.partials.controlsidebar') --}}

        {{-- @include('adminlte::layouts.partials.footer') --}}

    </div><!-- ./wrapper -->
</div>
<div class="modal fade custom-modal-rj"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog custom-modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <h4 class="modal-title custom-modal-title" id="myLargeModalLabel">Large modal</h4>
            </div>
            <div class="modal-body custom-modal-body-rj">  </div>
        </div>
    </div>
</div>
<div class="modal fade custom-modal-rj-inner"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog custom-modal-dialog-inner modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <h4 class="modal-title custom-modal-title-inner" id="myLargeModalLabel">Large modal</h4>
            </div>
            <div class="modal-body custom-modal-body-rj-inner">  </div>
        </div>
    </div>
</div>
@section('scripts')
   
    @include('adminlte::layouts.partials.scripts')
@show

<div class="content-fader"></div>

</body>
</html>
