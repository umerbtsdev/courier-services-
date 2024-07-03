
<div class="laradrop-thumbnail thumbnail laradrop-droppable col-md-2 laradrop-draggable "  file-id="[[id]]">




    <div class=" well" >
        <h4 class="laradrop-filealias" >[[alias]]</h4>
        <p class="text-info">[[type]] / [[updated_at]]</p>
        <p>
            <a href="<?php echo e(route('product.imagesave')); ?>" class="label label-danger laradrop-file-delete" rel="tooltip" title="<?php echo e(trans('laradrop::app.delete')); ?>"><?php echo e(trans('laradrop::app.delete')); ?></a>
        </p>
        <p><input type="radio" name="imagetype[]" class="image[[id]] imagtype" value="[[id]]|image">Base Image</p>
        <script>
            try {
                jQuery(".[[imagetype]][[id]]").prop('checked', true);
                    if(!$(".imagtype").is(":checked"))
                    {
                        jQuery(jQuery(".imagtype")[0]).prop('checked',true);
                    }
            }catch(err) {

            }
        </script>
        <img src="[[fileSrc]]" alt="[[alias]]" >
    </div>
</div>

