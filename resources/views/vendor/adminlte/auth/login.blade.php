@extends('adminlte::layouts.auth')
@section('htmlheader_title')
Log in
@endsection
@section('content')
<body class="hold-transition login-page screen-login">
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
   <!-- Error Msg -->
   <div class="login-box screen-login-content">
     <!-- login-logo -->
     <div class="login-logo logo-tango">
       <a href="{{ url('/home') }}"><img src="public/img/custom/yayvo_logo.png"></a>
     </div>
     <!-- login-logo -->
     <!-- login form -->
     <form action="{{ url('/login') }}" method="post">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <login-input-field
         name="{{ config('auth.providers.users.field','email') }}"
         domain="{{ config('auth.defaults.domain','') }}"
         ></login-input-field>
       <ul>
         <li>
           <input type="email" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email"/>
           <i class="fa fa-user"></i>
         </li>
         <li>
           <input type="password" class="" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
           <i class="fa fa-unlock"></i>
         </li>

         <li>
             <div class="other-info">
                <a class="pull-right" href="{{ url('/password/reset') }}">Forgot Password</a>
                <a class="pull-right" href="{{ url('/register') }}"  class="text-center">Register</a>
               <label class="pull-left">
                 <input type="checkbox" name="remember"> 
                  <span><a>{{ trans('adminlte_lang::message.remember') }} </a> </span>
                </label>
             </div>
           
         </li>

         <li>
           <button type="submit" class="btn-signin">{{ trans('adminlte_lang::message.buttonsign') }}</button>
         </li>
       </ul>
     </form>
     <!-- login form -->
     {{-- @include('adminlte::auth.partials.social_login') --}}
   </div>
   <!-- /.login-box -->
 </div>

 
  @include('adminlte::layouts.partials.scripts_auth')
  <script>
    $(function () {
      // $('input').iCheck({
      //   checkboxClass: 'icheckbox_square-blue',
      //   radioClass: 'iradio_square-blue',
      //   increaseArea: '0%' // optional
      // });
    });
  </script>
</body>
@endsection