@extends('adminlte::layouts.app')
@section('title','Product Dashboard')
@section('content')
<div class='container-fluid page-product-dashboard'>
  <div class="col-md-12">
    <div class="page-heading-primary">
      <span>
      <a href="#"> <i class="fa fa-home"></i> </a>
      <i class="fa fa-angle-right"> &nbsp; </i>
      <b> Product </b>
      </span>
      <h1>
        <b>Product Dashboard</b>
      </h1>
    </div>

   
    <div class="row">
      <div class="col-md-3">
        <div class="custom-charts-wrapper" style="background: #fff">
          <!-- <div class="chart-data">
            <input type="text" class="knob" value="{{$totalproductpercent}}" data-skin="tron" data-thickness="0.2" data-width="70" data-height="70" data-fgColor="#dddddd" data-readonly="true">
            </div> -->
          <div class="chart-desc">
            <div class="chart-label"> Total Product </div>
            <div class="chart-amount"> {{$totalproduct}} </div>
          </div>
          <span class="charts-icon" style="background: #80eaf3;"><img src="{{url('img/custom')}}/icon-size.png"></span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="custom-charts-wrapper" style="background: #fff">
          <!-- <div class="chart-data">
            <input type="text" class="knob" value="53" data-skin="tron" data-thickness="0.2" data-width="70" data-height="70" data-fgColor="#dddddd" data-readonly="true">
            </div> -->
          <div class="chart-desc">
            <div class="chart-label"> QC Approved </div>
            <div class="chart-amount"> {{$qcapproved}} </div>
          </div>
          <span class="charts-icon" style="background: #b9f2a1;"><img src="{{url('img/custom')}}/icon-qc.png"></span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="custom-charts-wrapper" style="background: #fff">
          <!-- <div class="chart-data">
            <input type="text" class="knob" value="13" data-skin="tron" data-thickness="0.2" data-width="70" data-height="70" data-fgColor="#dddddd" data-readonly="true">
            </div> -->
          <div class="chart-desc">
            <div class="chart-label"> VM Approved </div>
            <div class="chart-amount"> {{$vmapproved}} </div>
          </div>
          <span class="charts-icon" style="background: #59a0ab;"><img src="{{url('img/custom')}}/icon-approve.png"></span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="custom-charts-wrapper" style="background: #fff">
          <!-- <div class="chart-data">
            <input type="text" class="knob" value="87" data-skin="tron" data-thickness="0.2" data-width="70" data-height="70" data-fgColor="#dddddd" data-readonly="true">
            </div> -->
          <div class="chart-desc">
            <div class="chart-label"> Push to StoreFront </div>
            <div class="chart-amount"> {{$PushtoStoreFront}} </div>
          </div>
          <span class="charts-icon" style="background: #f9f38e;"><img src="{{url('img/custom')}}/icon-cart.png"></span>
        </div>
      </div>
    </div>
    <div class="spacing"></div>
    <!-- row3 -->
    <div class="row">
      <div class="col-md-6">
        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title sub-heading">Product Uploaded Date Wise</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="height: 380px; background: #1ba0ab;">
            <div class="col-md-12">
              <br />
              <!-- Date and time range -->
              <div class="form-group pull-right">
                <div class="input-group">
                  <button type="button" class="btn custom-btn bgcolr-orange btn-default pull-right" id="daterange-btn">
                  <span style="margin-right: 5px;">
                  <i class="fa fa-calendar" style="margin-right: 5px;"></i> Last 30 Days
                  </span>
                  <i class="fa fa-caret-down"></i>
                  </button>
                </div>
              </div>
              <div class="" style="position: relative;">
                <!-- no data availblae situation -->
                <div class="chart-no-data-wrapper col-md-12">
                  <div class="chart-no-data-inner-wrapper col-md-12">
                    <div class="chart-no-data-content-wrapper">
                      <img src="{{ url('img/no-data.png') }}">
                      <h3> No data available <br /> on selected date </h3>
                    </div>
                  </div>
                </div>
                <!-- no data availblae situation -->
                <div class="col-md-12 chart" id="bar-chart" style="height: 279px;">
                  <!-- {{ $Last7DaysProducts }} -->
                </div>
              </div>
              <!-- /.form group -->
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-solid" >
          <div class="box-header with-border">
            <h3 class="box-title sub-heading">Active products per category level 1</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body" style="height: 380px;">
            <div id="highChart" style="width:100%; height:350px;"></div>
          </div>
        </div>
      </div>
      <!-- new categories section -->
      <?php 
        /* <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title sub-heading"> Categories </h3>
                  <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
        
               <!-- box-body -->
              <div class="box-body" style="height: 380px;">
        
                  <div id="cat-product" class="row">
                       <div class=" col-md-8">
                          <div class="product-cat-text">
                              <h1 class="title"></h1>
                              <span class="level">level # <span> </span></span>
                              <div class="total"></div>
                              <span class="level">Total Products</span>
                         </div>
                      </div>
        
                      <!-- category dropdown -->
                      <div class="col-md-4">
                        <div class="list-group mCustomScrollbar" data-mcs-theme="dark" >
                          <a id="1" class="list-group-item">Mens Fashion</a>
                          <a id="2" class="list-group-item">Mobiles & Tablets</a>
                          <a id="3" class="list-group-item">Computing</a>
                          <a id="4" class="list-group-item">Mens Fashion</a>
                          <a id="5" class="list-group-item">Mobiles & Tablets</a>
                        </div>
                      </div>
                      <!-- category dropdown -->
                   </div>
             
              </div>
              <!-- box-body -->
            </div>
            <!-- /.box -->
          </div> */
            ?>
        <!-- Report Section -->
        <?php
        /*<div class="col-md-12">
          <div class="spacing"></div>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title sub-heading">Reports</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="min-height: 380px; ">
              <div class="col-md-12">
                <div class="spacing"></div>
                <div class="" id="modern-table_wrapper">
                  <table id="modern-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <?php 
                          $tableData = array("Magento_prod_id","sku","product_type","created_at","updated_at","prod_name","STATUS","udrophip_vendor_id","vendor_name  stock","is_in_stock","visibility","price","cost","cat_name_1","cat_name_2","cat_name_3","specialprice","brandname","URL");
                            foreach ($tableData as  $value) { ?>
                        <th><?php echo $value; ?></th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php for ($i=0; $i<50 ; $i++) {  ?>
                      <tr>
                        <?php 
                          $tableData = array("365065$i","Bellona_BDE55","simple","8/9/2017","8/9/2017","Green Amethyst Earrings - BDE55","Enable","1147","          Bellona Designs","1","1","4","1100","880","Women's Fashion","Jewelry","Earring","Bellona Designs","1-million-100ml");
                          foreach ($tableData as  $value) { ?>
                        <td><?php echo $value; ?></td>
                        <?php } ?>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>*/
        ?>
        <!-- Report Section -->
    </div>
    <!-- new categories section -->
    <!-- row 3 -->
    <div class="spacing"></div>
  </div>
</div>




<script type="text/javascript">

  //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          "dateLimit": {"days": 7},
          ranges: {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function(start, end) {
          getMessage(start.format('YYYY-MM-D'), end.format('YYYY-MM-D'));
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      );
  //Date range as a button

    function getMessage(start, end)
    {
        var url = '{{ url("products/datewise/") }}/'+ start + '|' + end;
  
        $.ajax({
            type:'GET',
            url:url,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){
              jQuery('#bar-chart').html('');
              var data = JSON.parse(data);
              console.log(data);
              
              if(data.length<1)
              {
                jQuery('.chart-no-data-wrapper').fadeIn('fast');
                jQuery('.chart-no-data-content-wrapper').addClass('visible-box');
                // alert('no data available');
              }
              else
              {
                jQuery('.chart-no-data-wrapper').fadeOut('fast');
                jQuery('.chart-no-data-content-wrapper').removeClass('visible-box');
                bar = new Morris.Bar({
                    element: 'bar-chart',
                    data: data,
                    xkey: 'dates',
                    ykeys: ['total_products'],
                    labels: ['Total Products'],
                    parseTime :false,
                    xLabelMargin: -1,
                    barColors: ['#fff'],
                    gridTextColor: ['#fff'],
                    hideHover: 'auto'               
                });
              }
            }
         });
    }

    var data = JSON.parse('<?php echo $Last7DaysProducts; ?>');

    if(data.length<1)
    {
      jQuery('.chart-no-data-wrapper').fadeIn('fast');
      jQuery('.chart-no-data-content-wrapper').addClass('visible-box');
      // alert('no data available');
    }
    else
    {
      bar = new Morris.Bar({
          element: 'bar-chart',
          data: data,
          xkey: 'dates',
          ykeys: ['total_products'],
          labels: ['Total Products'],
          parseTime :false,
          xLabelMargin: -1,
          barColors: ['#fff'],
          gridTextColor: ['#fff'],
          hideHover: 'auto'               
      });
    }
  
  
  function getCatData(catId)
  {
    var url = '{{ url("/products/categoryWise/") }}/'+catId;
    
    $.ajax({
      type:'GET',
      url:url,
      data:'',
      success:function(data){
        // jQuery('#bar-chart').html('');
        jQuery("#cat-product .title").html(data.title);
         jQuery("#cat-product .level>span").html(data.level);
          jQuery("#cat-product .total").html(data.total);
        console.log(data.title);
     
      }
    });
  }
  
  
// highChart script
    $(function () { 
    
    
    Highcharts.theme = {
    // colors: ['#24eadd', '#f9ff76', '#1ba0ab', '#b9f2a1', '#4DB6AC', '#20D0E0', '#01AABA',
    //   '#5d777b '],
         colors: ['#26C6DA', '#80D8FF', '#B2DFDB', '#B3E5FC','#90CAF9','#B2EBF2','#80CBC4','#03A9F4','#00796B','#0277BD'],
    chart: {
      backgroundColor: null,
      style: {
         fontFamily: 'roboto'
      }
    },
    title: {
      style: {
         fontSize: '16px',
         fontWeight: 'normal',
         textTransform: 'uppercase'
      }
    },
    tooltip: {
      borderWidth: 0,
      backgroundColor: 'rgba(219,219,216,0.8)',
      shadow: false
    },
    legend: {
      itemStyle: {
         fontWeight: 'bold',
         fontSize: '13px'
      }
    },
    xAxis: {
      gridLineWidth: 1,
      labels: {
         style: {
            fontSize: '12px'
         }
      }
    },
    yAxis: {
      minorTickInterval: 'auto',
      title: {
         style: {
            textTransform: 'uppercase'
         }
      },
      labels: {
         style: {
          fontWeight: 'bold',
          fontSize: '11px',
          color:'#005562'
         }
      }
    },
    plotOptions: {
      candlestick: {
         lineColor: null,
          LineWidth:'5'
      }
    },
    
    
    // General
    background2: '#F0F0EA'
    
    };
    
    Highcharts.setOptions(Highcharts.theme);
    
    var myChart = Highcharts.chart('highChart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}:{point.percentage:.1f}%'
    },
    legend: {
      itemStyle: {
         fontWeight: 'bold',
         fontSize: '1px'
      }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                borderWidth: 0,
                format: '{point.name}: {point.y}',
    
                style: {
                    color: "#005562",
                    fontFamily:'roboto',
                    fontWeight: 'normal',
                    fontSize:'12px',
                    textShadow: false
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: <?php echo $categoryActiveProducts; ?>
    }]
    })
    
    
    
    });
// highChart script
  
  
  
  jQuery(document).ready(function()
  {
  
  // category display
    jQuery("#cat-product .list-group a").on( "click", function() {
        $catId=$(this).attr('id');
        getCatData($catId);
        jQuery("#cat-product .product-cat-text ").fadeIn(100);
    
    });
  // category display

  
  // datatable
     var table = jQuery('#modern-table').DataTable( {
        autoWidth:false,
        columnDefs: [
                      { width: '60px', targets: 0 },
                      { width: '60px', targets: 2 },
                      { width: '60px', targets: 1 },
                      { width: '60px', targets: 3 },
                      { width: '60px', targets: 4 },
                      { width: '60px', targets: 5 },
                      { width: '60px', targets: 6 },
                      { width: '60px', targets: 7 },
                      { width: '60px', targets: 8 },
                      { width: '60px', targets: 9 },
                      { width: '60px', targets: 10 },
                      { width: '60px', targets: 11 },
                      { width: '60px', targets: 12 },
                      { width: '60px', targets: 13},
                      { width: '60px', targets: 14 },
                      { width: '60px', targets: 15 },
                      { width: '60px', targets: 16 },
                      { width: '60px', targets: 17 },
                      { width: '60px', targets: 18 }
                    ]
    
     } );
  // datatable

    
  
  });
                    
  
</script>
@endsection