@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Register
@endsection

@section('content')

    <body class="hold-transition register-page screen-login">
    <div id="app" v-cloak>
    <!-- Error Msg -->
         @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        <div class="register-box screen-login-content">
          <!--   <div class="register-logo">
                <a href="{{ url('/home') }}"><b>Tango</a>
            </div> -->

            <div class="register-logo logo-tango">
             <a href="{{ url('/home') }}"><img src="public/img/custom/yayvo_logo.png"></a>
            </div>
       

            <div class="">
                <!-- <p class="login-box-msg">{{ trans('adminlte_lang::message.registermember') }}</p> -->
                <form action="{{ url('/register') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <ul>
                        <li> 
                            
                                <input type="email" class="" placeholder="{{ trans('adminlte_lang::message.email') }}" name="name" value="{{ old('name') }}" autofocus/>
                               <i class="fa fa-user"></i>
                            
                         </li>

                        @if (config('auth.providers.users.field','email') === 'username')
                            <li>
                                <input type="text" class="" placeholder="{{ trans('adminlte_lang::message.username') }}" name="username" autofocus/>
                                <i class="fa fa-user"></i>
                            </li>
                        @endif

                        <li> 
                        
                            <input type="password" class=""
                             placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                            <i class="fa fa-unlock"></i>
                            
                        </li>

                        <li> 
                            <input type="password" class=""
                             placeholder="{{ trans('adminlte_lang::message.retypepassword') }}" name="password_confirmation"/>
                            <i class="fa fa-unlock"></i>                  
                        </li>

                        <li>
                           
                         
                            <div class="other-info">

                                

                                <div class="checkbox_register">

                                    <a href="{{ url('/login') }}" class="text-center pull-right ">{{ trans('adminlte_lang::message.membreship') }}</a>
                                    <label class="pull-left">
                                        <input type="checkbox" name="remember"> 
                                        <span> <a  data-toggle="modal" data-target="#termsModal" >
                                             {{ trans('adminlte_lang::message.terms') }}</a>
                                         </span>
                                    </label> 
                                </div>
             
                             </div>

                         </li>
                         <li>
                             <button type="submit" class="btn-signin">Register</button>
                         </li>

                    </ul>
                    <?php /*
                    <div class="row">
                        <div class="col-xs-1">
                            <label>
                                <div class="checkbox_register icheck">
                                    <label>
                                        <input type="checkbox" name="terms">
                                    </label>
                                </div>
                            </label>
                        </div><!-- /.col -->
                        <div class="col-xs-6">
                            <div class="form-group">
                                <button type="button" class="btn btn-block btn-flat" data-toggle="modal" data-target="#termsModal">{{ trans('adminlte_lang::message.terms') }}</button>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-xs-4 col-xs-push-1">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.register') }}</button>
                        </div><!-- /.col -->
                    </div>
                    */

                    ?>
                </form>

             {{--    @include('adminlte::auth.partials.social_login') --}}

                <!-- <a href="{{ url('/login') }}" class="text-center">{{ trans('adminlte_lang::message.membreship') }}</a> -->
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

    @include('adminlte::auth.terms')

    <script>
      $(function () {
        // $('input').iCheck({
        //   checkboxClass: 'icheckbox_square-blue',
        //   radioClass: 'iradio_square-blue',
        //   increaseArea: '20%' // optional
        // });
      });
    </script>

    </body>

@endsection