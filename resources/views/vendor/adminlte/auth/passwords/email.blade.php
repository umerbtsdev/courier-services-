@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Password recovery
@endsection

@section('content')

<body class="login-page screen-login">
    <div id="app">
        <!-- Error Msg -->
         @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

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
        <!-- Error Msg -->

        <div class="login-box screen-login-content">
        
            <!-- login-logo -->
            <div class="login-logo logo-tango">
                <a href="{{ url('/home') }}"><img src="../public/img/custom/yayvo_logo.png"></a>
            </div>
            <!-- login-logo -->

      

            <div  id="email-sectionbox">
                <!-- <p class="login-box-msg">Reset Password</p> -->

                <email-reset-password-form></email-reset-password-form>

                <div class="other-info">
                    <!-- <a href="{{ url('/login') }}" class="pull-left">Log in</a> -->
                    <a href="{{ url('/register') }}" class="pull-right">{{ trans('adminlte_lang::message.registermember') }}</a>
                </div>
               

            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
