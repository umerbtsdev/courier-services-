
<script src="<?php echo e(asset('jqGrid/i18n/grid.locale-en.js' )); ?>"></script>
<script src="<?php echo e(asset('jqGrid/jquery.jqGrid.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery-barcode.js')); ?>"></script>
<script src="<?php echo e(asset('js/print/print.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/buttons.flash.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/buttons.print.min.js')); ?>" ></script>

<div class="screen-loader ajax-loader-region">
  <div id="ajax-loader-region-content">
    <div class="spinner">
      <h3> Loading </h3>
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
  </div>
</div>


<script>
	
	/* Enable AJAX request capturing on Send and Complete 
	*/

	//On AJAX send
	jQuery( document ).ajaxSend(function( event, request, settings ) {
		jQuery(".screen-loader").fadeIn("slow");	//Show Loader
	});

	//On AJAX complete
	jQuery( document ).ajaxSuccess(function( event, request, settings ) {
		jQuery(".screen-loader").fadeOut("slow");	//Hide Loader
	});

</script>