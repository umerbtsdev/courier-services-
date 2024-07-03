<?php

namespace App\Console\Commands;

use App\Model\Orders\OrdersItems;
use App\Model\Product\Product;
use App\Model\vendordetail\vendorDetails;
use Dompdf\Exception;
use Illuminate\Console\Command;
use App\Model\Product\ProductModel;
use App\Model\Orders\StorefrontOrders;
use App\Model\Orders\StoreFrontOrdersItems;
use App\Model\Orders\StoreFrontOrderAddress;
use DB;
use Log;

class Orders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:Ordersoffloading';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Data to Store Front';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }

    public function OrderOffloading(){
        $storefrontorderData = StorefrontOrders::get();//::whereNull('is_orderoffload')->get();

        //whereNull('is_orderoffload')->get();
        $productmodel = new ProductModel();
        foreach($storefrontorderData as $storefrontorder )
        {
            $storefrontorderDataAddressBill = StoreFrontOrderAddress::where('parent_id','=',$storefrontorder->entity_id)->where('address_type','=',DB::Raw("'billing'"))->first();
            $storefrontorderDataAddressShip = StoreFrontOrderAddress::where('parent_id','=',$storefrontorder->entity_id)->where('address_type','=',DB::Raw("'shipping'"))->first();
            $orderdata = new \App\Model\Orders\Orders();
            $orderdata->storefront_id = $storefrontorder->entity_id;
            $orderdata->order_id = $storefrontorder->increment_id;
            $orderdata->order_status = $storefrontorder->status;
            $orderdata->courier_id = null;
            $orderdata->courier = $storefrontorder->shipping_description;
            $orderdata->customer_id = null;
            $orderdata->first_name = $storefrontorder->customer_firstname;
            $orderdata->last_name =$storefrontorder->customer_lastname;
            $orderdata->discounts= $storefrontorder->discount_amount;
            $orderdata->total_products = $storefrontorder->total_qty_ordered;
            $orderdata->total_shipping = $storefrontorder->shipping_amount;
            // billing data start //
            if($storefrontorderDataAddressBill != null)
            {
                $orderdata->billing_first_name = $storefrontorderDataAddressBill->firstname;
                $orderdata->billing_last_name = $storefrontorderDataAddressBill->lastname;
                $orderdata->billing_telephone = $storefrontorderDataAddressBill->telephone;
                $orderdata->billing_street = $storefrontorderDataAddressBill->street;
                $orderdata->billing_city = $storefrontorderDataAddressBill->city;
            }
            // billing data end //
            // shipping data start //
            if($storefrontorderDataAddressShip != null)
            {
                $orderdata->shipping_first_name = $storefrontorderDataAddressShip->firstname;
                $orderdata->shipping_last_name = $storefrontorderDataAddressShip->lastname;
                $orderdata->shipping_telephone = $storefrontorderDataAddressShip->telephone;
                $orderdata->shipping_street = $storefrontorderDataAddressShip->street;
                $orderdata->shipping_city = $storefrontorderDataAddressShip->city;
            }
            // shipping data end //
            $orderdata->tax = null;
            $orderdata->total= $storefrontorder->grand_total;
            $orderdata->total_paid = null;
            $orderdata->invoice = null;
            $orderdata->label_url = null;
            $orderdata->tracking_number=null;
            $orderdata->created_at= $storefrontorder->created_at;
            $orderdata->save();

            $storefrontorderitems = StoreFrontOrdersItems::where('order_id','=',$storefrontorder->entity_id)->get();

            foreach($storefrontorderitems as $storefrontorderitem){

                $product = Product::join('categories_products','categories_products.product_id','=','product.id')
                    ->where('storefront_productid','=', $storefrontorderitem->product_id)->first();

                if($product != null){
                    if($storefrontorderitem->parent_item_id != null)
                    {
                        $storefrontorderitemsparent = StoreFrontOrdersItems::where('item_id','=',$storefrontorderitem->parent_item_id)->first();
                        $qty_ordered = $storefrontorderitemsparent->qty_ordered;
                        $price = $storefrontorderitemsparent->price;
                        $row_total = $storefrontorderitemsparent->row_total;
                    }else
                    {
                        $qty_ordered = $storefrontorderitem->qty_ordered;
                        $price = $storefrontorderitem->price;
                        $row_total = $storefrontorderitem->row_total;
                    }
                    $orderitemdata = new OrdersItems();
                    $orderitemdata->item_id= $storefrontorderitem->item_id;
                    $orderitemdata->order_id = $storefrontorderitem->order_id;
                    $orderitemdata->product_id = $storefrontorderitem->product_id;
                    $orderitemdata->product_sku = $storefrontorderitem->sku;
                    $orderitemdata->product_name = $storefrontorderitem->name;
                    $orderitemdata->product_qty = $qty_ordered;
                    $orderitemdata->product_price = $price;
                    $orderitemdata->product_total = $row_total;
                    $orderitemdata->product_vendor = $product->vendor_id;
                    $cost = $productmodel->getCategoryMargin($product->vendor_id,$product->cat_id,$price);
                    //$orderitemdata->vendor_name = $storefrontorderitems->entity_id;
                    $orderitemdata->cost = $cost;
                    //$orderitemdata->courier_id = $storefrontorderitems->entity_id;
                    //$orderitemdata->courier = $storefrontorderitems->entity_id;
                    $orderitemdata->created_at = $storefrontorderitem->created_at;
                    $orderitemdata->save();
                }


            }
            $save_storefrontdata = StorefrontOrders::where('entity_id','=',$storefrontorder->entity_id)->first();
            $save_storefrontdata->is_orderoffload = 1;
            $save_storefrontdata->save();
        }

    }


}
