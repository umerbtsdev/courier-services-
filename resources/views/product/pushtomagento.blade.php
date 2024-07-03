<div class="row pushstorefront-wrap">

  <div class="col-md-4 modal-img-wrap">
    <img src="{{ url('img/custom') }}/img-push-storefront.png"  style="width: 250px;" />
  </div>
  <div class="col-md-8 modal-cont-wrap">
    {!! Form::open(array('url'=>'products/addmagento','method'=>'POST', 'files'=>true)) !!}
    <input type="hidden" name="id" id="id" value="{{$id}}" />
    <div class="col-md-12">
      <p>
          Are you sure to push in store front? <br />
          Please click below button to send this product to the storefront.
      </p>
    </div>
    <div class="col-md-12">
        <input type="submit" class="bgcolr-aqua custom-btns custom-btn-primary submit-product" type="button" value="Push to Storefront">
    </div>
    {!! Form::close() !!}
  </div>

</div>
 