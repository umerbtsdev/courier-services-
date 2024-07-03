<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style type="text/css">
        .custom-lt
        {
            height: 350px;
            width: 500px;
            border: 1px solid #3d3d3d;
            padding: 20px;
        }
        .custom-lt ul
        {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }
        .custom-lt ul li
        {
            margin: 0 0 10px 0;
        }
        .custom-lt ul li span
        {
            font-size: 15px;
        }
        .custom-lt ul li span:first-child
        {
            font-weight: bold;
        }
        .heading-level-2 {
            font-size: 18px !important;
            display: block;
            border-bottom: 2px solid #f2f2f2;
            margin: 0 0 20px 0;
        }
        .img-wrap
        {
            width: 200px;
            height: 200px;
        }
        .img-wrap img
        {
            width: 100%;
            height: auto;
        }
        .no-padding
        {
            padding: 0;
        }
    </style>
</head>

<body>


<div class="container-fluid">
    <div class="custom-lt">
        <h3 class="heading-level-2">Product Details</h3>
        @if($productdata !=  null)
        <div class="col-md-6 no-padding">
            <ul>
                <li>
                    <span> sku : </span>
                    <span> {{$productdata->storefront_sku}} </span>
                </li>
                <li>
                    <span> Product Code : </span>
                    <span> {{$productdata->storefront_productid}} </span>
                </li>
                <li>
                    <span> Description : </span>
                    <span> {{$productdata->value}} </span>
                </li>
                <li>
                    <span> Vendor Name : </span>
                    <span> {{$productdata->vendor_name}} </span>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="img-wrap">
                @if($productimage == null)
                    <img src="{{url('/uploads/imagenotfound.png')}}" />
                    @else
                <img src="{{url($productimage->public_resource_url)}}" />
                    @endif
            </div>
        </div>
        @else
        <div class="col-md-12 no-padding">
            No Product Found
        </div>
        @endif
    </div>
</div>

</body>
</html>
