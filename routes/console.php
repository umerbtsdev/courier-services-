<?php

use Illuminate\Foundation\Inspiring;
use App\Console\Commands\StoreFrontPushData;
use App\Console\Commands\Orders;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('cron:storefrontpush', function (StoreFrontPushData $frontPushData) {
    $frontPushData->productoffload();
});

Artisan::command('cron:Ordersoffloading', function (Orders $orderdata) {
    $orderdata->OrderOffloading();
});