<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
{{-- <script src="{{ url ('/public/js/app.js') }}" type="text/javascript"></script> --}}
<script src="{{ asset ("/public/bower_components/AdminLTE/plugins/jQueryUI/jquery-ui.min.js") }}"></script>


<script src="{{ asset("/public/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- SlimScroll -->
<script src="{{ asset("/public/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>
<!-- FastClick -->
<script src="{{ asset("/public/bower_components/AdminLTE/plugins/fastclick/fastclick.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("/public/bower_components/AdminLTE/dist/js/app.min.js")}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("/public/bower_components/AdminLTE/dist/js/demo.js")}}"></script>
<!-- Bar code -->
<script src="{{ asset("/public/js/jquery-barcode.js")}}"></script>

<!-- custom js | rj -->
<script src="{{ asset("/public/js/custom.rj.js")}}"></script>

<!-- color picker js -->
<script src="{{ asset("/public/js/jscolor.min.js")}}"></script>

<!-- mCustomScrollbar -->
<script src="{{ asset("/public/js/jquery.mCustomScrollbar.js")}}"></script>

<!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.1/TweenMax.min.js'></script> -->

<script type="text/javascript" src="{{ asset('/public/js')}}/velocity.js"></script>
<script type="text/javascript" src="{{ asset('/public/js')}}/velocity.ui.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->

<!-- TODO: add belwo in saperate files -->
<!-- Return Desk -->
<script src="{{ asset('/public/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/public/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/public/js/return-desk.js') }}"></script>
