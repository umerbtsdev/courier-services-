<?php

namespace App\Console\Commands;

use Dompdf\Exception;
use Illuminate\Console\Command;
use App\Model\Product\ProductModel;
use Log;

class StoreFrontPushData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:storefrontpush';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function productoffload()
    {
        $productid = "";
        $productmodule = new ProductModel();
        $filetime = "/var/www/vendorportal/crontime.txt";
        $txttime = date("Y/m/d h:i");
        $file = "/var/www/vendorportal/cronlock.txt";
        try{

            file_put_contents($filetime, $txttime.PHP_EOL , FILE_APPEND | LOCK_EX);

            $productmodule = new ProductModel();
            $txt = date("Y/m/d h:i");

            if(file_exists($file))
            {
                $time = mktime(date('H', filemtime($file)),date('i', filemtime($file)),date('s', filemtime($file)),date('m', filemtime($file)),date('d', filemtime($file)),date('Y', filemtime($file)));
                $delayminte = 61;
                $delaytime = mktime(date('H', strtotime('-'.$delayminte.' minutes')),date('i', strtotime('-'.$delayminte.' minutes')),date('s', strtotime('-'.$delayminte.' minutes')),date('m', strtotime('-'.$delayminte.' minutes')),date('d', strtotime('-'.$delayminte.' minutes')),date('Y', strtotime('-'.$delayminte.' minutes')));

                if($delaytime >= $time)
                {
                    unlink($file);
                    $myfile = file_put_contents($file, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
                }
                else
                {
                    exit();
                }
            }
            else
            {
                $myfile = file_put_contents($file, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
            }

            $PushRecords = $productmodule->getAllProductMagentoPush(1000);
            if(sizeof($PushRecords) > 0)
            {
                foreach($PushRecords as  $PushRecord)
                {
                    $productid =$PushRecord->product_id;
                    if($productmodule->CheckMagentoSku($PushRecord->product_id))
                    {
                        continue;
                    }
                    $MageId = $productmodule->getMagentoId($PushRecord->product_id);
                    if($MageId != null) {
                        if ($MageId->magento_productid != null) {
                            if ($PushRecord->comments_qc == "Auto Approved by System") {
                                try {
                                    $productmodule->getProductProductAutoApproval($PushRecord->product_id);
                                } catch (Exception $e) {
                                    Log::useDailyFiles(storage_path() . '/logs/recordinmagento.log');
                                    Log::info("Store Front product id " . $PushRecord->product_id . " result : " . $e->getMessage());

                                }
                            } else {
                                try {
                                    if ($productmodule->is_configurable($PushRecord->product_id) > 0) {
                                        $result = $productmodule->addconfigurableproductsf($PushRecord->product_id);
                                    } else {
                                        $result = $productmodule->addsimpleproductmagento($PushRecord->product_id);
                                    }
                                    if($result == "Image not found on this product")
                                    {
                                        $productmodule->MarkError($PushRecord->product_id, 'Image not found on this product');
                                    }
                                    else
                                    {
                                        Log::useDailyFiles(storage_path() . '/logs/recordinmagento.log');
                                    }

                                } catch (Exception $e) {
                                    Log::useDailyFiles(storage_path() . '/logs/recordinmagento.log');
                                    Log::info("Store Front product id " . $PushRecord->product_id . " result : " . $e->getMessage());
                                }

                            }
                        } else {
                            try {
                                if ($productmodule->is_configurable($PushRecord->product_id) > 0) {
                                    $result = $productmodule->addconfigurableproductsf($PushRecord->product_id);
                                } else {
                                    $result = $productmodule->addsimpleproductmagento($PushRecord->product_id);
                                }
                                if($result == "Image not found on this product")
                                {
                                    $productmodule->MarkError($PushRecord->product_id, 'Image not found on this product');
                                }

                            } catch (Exception $e) {
                                Log::useDailyFiles(storage_path() . '/logs/recordinmagento.log');
                                Log::info("Store Front product id " . $PushRecord->product_id . " result : " . $e->getMessage());
                            }

                        }
                    }else {
                        Log::useDailyFiles(storage_path().'/logs/trace.log');
                        Log::info("checking  product id ". $PushRecord->product_id. " result : ". $result);
                    }


                }
            }
            //
            if (unlink($file))
            {
                echo ("Deleted $file");
            }
        }catch (\Exception $e)
        {
            Log::info(" product id ---". $productid . "-- result : ".  $e->getMessage());
            $productmodule->MarkError($productid, $e->getMessage());
            if (unlink($file))
            {
                echo ("Deleted $file");
            }
        }

    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function productoffloaddesc()
    {
        $productid = "";
        try{
            $filetime = "/var/www/vendorportal/crontime.txt";
            $txttime = date("Y/m/d h:i");
            file_put_contents($filetime, $txttime.PHP_EOL , FILE_APPEND | LOCK_EX);
            $file = "/var/www/vendorportal/cronlock1.txt";

            $productmodule = new ProductModel();
            $txt = date("Y/m/d h:i");

            if(file_exists($file))
            {
                $time = mktime(date('H', filemtime($file)),date('i', filemtime($file)),date('s', filemtime($file)),date('m', filemtime($file)),date('d', filemtime($file)),date('Y', filemtime($file)));
                $delayminte = 61;
                $delaytime = mktime(date('H', strtotime('-'.$delayminte.' minutes')),date('i', strtotime('-'.$delayminte.' minutes')),date('s', strtotime('-'.$delayminte.' minutes')),date('m', strtotime('-'.$delayminte.' minutes')),date('d', strtotime('-'.$delayminte.' minutes')),date('Y', strtotime('-'.$delayminte.' minutes')));

                if($delaytime >= $time)
                {
                    if (file_exists($file))
                    {
                        unlink($file);
                    }

                }
                else
                {
                    exit();
                }
            }
            else
            {
                $myfile = file_put_contents($file, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
            }

            $productmodule = new ProductModel();

            $PushRecords = $productmodule->getAllProductMagentoPushdesc(1000);
            if(sizeof($PushRecords) > 0)
            {
                foreach($PushRecords as  $PushRecord)
                {
                    $productid =$PushRecord->product_id;
                    if($productmodule->CheckMagentoSku($PushRecord->product_id))
                    {
                        continue;
                    }
                    $MageId = $productmodule->getMagentoId($PushRecord->product_id);
                    if($MageId != null) {
                        if ($MageId->magento_productid != null) {
                            if ($PushRecord->comments_qc == "Auto Approved by System") {
                                try {
                                    $productmodule->getProductProductAutoApproval($PushRecord->product_id);
                                } catch (Exception $e) {
                                    Log::useDailyFiles(storage_path() . '/logs/recordinmagento.log');
                                    Log::info("Store Front product id " . $PushRecord->product_id . " result : " . $e->getMessage());

                                }
                            } else {
                                try {
                                    if ($productmodule->is_configurable($PushRecord->product_id) > 0) {
                                        $result = $productmodule->addconfigurableproductsf($PushRecord->product_id);
                                    } else {
                                        $result = $productmodule->addsimpleproductmagento($PushRecord->product_id);
                                    }
                                    if($result == "Image not found on this product")
                                    {
                                        $productmodule->MarkError($PushRecord->product_id, 'Image not found on this product');
                                    }
                                } catch (Exception $e) {
                                    Log::useDailyFiles(storage_path() . '/logs/recordinmagento.log');
                                    Log::info("Store Front product id " . $PushRecord->product_id . " result : " . $e->getMessage());
                                }

                            }
                        } else {
                            try {
                                if ($productmodule->is_configurable($PushRecord->product_id) > 0) {
                                    $result = $productmodule->addconfigurableproductsf($PushRecord->product_id);
                                } else {
                                    $result = $productmodule->addsimpleproductmagento($PushRecord->product_id);
                                }
                                if($result == "Image not found on this product")
                                {
                                    $productmodule->MarkError($PushRecord->product_id, 'Image not found on this product');
                                }
                            } catch (Exception $e) {
                                Log::useDailyFiles(storage_path() . '/logs/recordinmagento.log');
                                Log::info("Store Front product id " . $PushRecord->product_id . " result : " . $e->getMessage());
                            }

                        }
                    }else {
                        Log::useDailyFiles(storage_path().'/logs/trace.log');
                        Log::info("checking  product id ". $PushRecord->product_id);
                    }


                }
            }
            //
            if (file_exists($file))
            {
                if (unlink($file))
                {
                    echo ("Deleted $file");
                }
            }

        }catch (\Exception $e)
        {
            Log::info(" product id ---". $productid. "-- result : ".  $e->getMessage());
            $productmodule->MarkError($productid, $e->getMessage());
            if (file_exists($file))
            {
                if (unlink($file))
                {
                    echo ("Deleted $file");
                }
            }

        }

    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function ChangeStockData()
    {

        try{
            $filetime = "/var/www/vendorportal/cronstocktime.txt";
            $txttime = date("Y/m/d h:i");
            file_put_contents($filetime, $txttime.PHP_EOL , FILE_APPEND | LOCK_EX);
            $file = "/var/www/vendorportal/cronstocklock.txt";

            $productmodule = new ProductModel();
            $txt = date("Y/m/d h:i");

            if(file_exists($file))
            {
                $time = mktime(date('H', filemtime($file)),date('i', filemtime($file)),date('s', filemtime($file)),date('m', filemtime($file)),date('d', filemtime($file)),date('Y', filemtime($file)));
                $delayminte = 61;
                $delaytime = mktime(date('H', strtotime('-'.$delayminte.' minutes')),date('i', strtotime('-'.$delayminte.' minutes')),date('s', strtotime('-'.$delayminte.' minutes')),date('m', strtotime('-'.$delayminte.' minutes')),date('d', strtotime('-'.$delayminte.' minutes')),date('Y', strtotime('-'.$delayminte.' minutes')));

                if($delaytime >= $time)
                {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                else
                {
                    exit();
                }
            }
            else
            {
                $myfile = file_put_contents($file, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
            }

            $productmodule = new ProductModel();
// code start
            $PushRecords = $productmodule->getStockUpdateMagento(1000);
            if(sizeof($PushRecords) > 0)
            {
                foreach($PushRecords as  $PushRecord)
                {
                    $MageId = $productmodule->ChangeStockFromStoreFront($PushRecord->product_id ,$PushRecord->qty, $PushRecord->mode_of_fulfillment);
                    if($MageId == "Success"){
                        $productmodule->getStockStatusUpdate($PushRecord->product_id);
                    }
                }
            }
            //
            if (file_exists($file)) {
                if (unlink($file)) {
                    echo("Deleted $file");
                }
            }
        }catch (\Exception $e)
        {
            Log::info(" stock error ---". "-- result : ".  $e->getMessage());
            if (file_exists($file)) {
                if (unlink($file)) {
                    echo("Deleted $file");
                }
            }
        }

    }

}
