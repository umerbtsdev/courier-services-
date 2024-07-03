<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="custom-headings heading-level-1">
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb custom-breadcrumb">
        <li>
            <a href="#"> <i class="fa fa-home"></i> </a>
            <i class="fa fa-angle-right"></i>
            <a href="#">
                {{ trans('adminlte_lang::message.level') }}
            </a> 
            <i class="fa fa-angle-right"></i>
            <em> {{ trans('adminlte_lang::message.here') }} </em>  
        </li>
 </ol>
</section>