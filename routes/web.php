<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

//Route::get('/testemail', function (){
  // $ss = new App\Http\Controllers\AccountOpeningController();
   // $senddata =  $ss->Emailsend('Account opening from level 1',"Created");
    //$user = User::findOrFail(1);
    //$data = array("ss"=>"2222");
    //Mail::send('emails.reminder', compact('data'), function ($m) {
    //    $m->from('dms@icsgroup.com.pk', 'Document Management System');

    //    $m->to('muhammad.shoaib@icsgroup.com.pk', 'shoaib')->subject('Your Reminder!');
    //});
   // echo "test";
//});



Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('transaction/bookinglist','BookingController@boobkingorderlist');
    Route::post('bookingorder-grid-data','BookingController@BookingGridData');

    Route::get('transaction/singlebooking','BookingController@SingleOrderBooking');
    Route::post('transaction/singlebookingstore', 'BookingController@BookingSingleStore');

    Route::get('transaction/bulkbooking','BookingController@BulkOrderBooking');
    Route::post('transaction/bookingsinglestore', 'BookingController@BookingSingleStore');

    //Alert
        Route::get('General-Setup/alertinfo','AlertController@index');
        Route::post('alert-grid-data','\App\Http\Controllers\AlertController@AlertGridData');
        Route::get('alert/create','AlertController@create');
        Route::post('alert/store', '\App\Http\Controllers\AlertController@store');
        Route::get('alert/edit/{alert_id}','\App\Http\Controllers\AlertController@edit');
        Route::post('alert/update/{alert_id}', 'AlertController@update');

        Route::get('alert/delete/{id}','AlertController@destroyview');
        Route::post('alert/delete/{id}','AlertController@destroy');

    //generalaccount
        Route::get('General-Setup/generalaccountinfo','GeneralAccountController@index');
        Route::post('generalaccount-grid-data','\App\Http\Controllers\GeneralAccountController@AlertGridData');
        Route::get('generalaccount/create','GeneralAccountController@create');
        Route::post('generalaccount/store', 'GeneralAccountController@store');
        Route::get('generalaccount/edit/{alert_id}','\App\Http\Controllers\GeneralAccountController@edit');
        Route::post('generalaccount/update/{alert_id}', 'GeneralAccountController@update');
        Route::get('generalaccount/delete/{id}','GeneralAccountController@destroyview');
        Route::post('generalaccount/delete/{id}','GeneralAccountController@destroy');


    //Catagorey
        Route::get('General-Setup/categoriesinfo','CategoriesController@index');
        Route::post('cat-grid-data','\App\Http\Controllers\CategoriesController@CatGridData');
        Route::get('categories/create','CategoriesController@create');
        Route::post('categories/store', '\App\Http\Controllers\CategoriesController@store');
        Route::get('categories/edit/{cat_id}','\App\Http\Controllers\CategoriesController@edit');
        Route::post('categories/update/{cat_id}', 'CategoriesController@update');
        Route::get('categories/delete/{id}','CategoriesController@destroyview');
        Route::post('categories/delete/{id}','CategoriesController@destroy');


    //Brand
        Route::get('General-Setup/brandinfo','BrandController@index');
        Route::post('brand-grid-data','\App\Http\Controllers\BrandController@BrandGridData');
        Route::get('brand/create','BrandController@create');
        Route::post('brand/store', '\App\Http\Controllers\BrandController@store');
        Route::get('brand/edit/{brand_id}','\App\Http\Controllers\BrandController@edit');
        Route::post('brand/update/{brand_id}', 'BrandController@update');
        Route::get('brand/delete/{id}','BrandController@destroyview');
        Route::post('brand/delete/{id}','BrandController@destroy');


    //Countries
    Route::get('setup/countries','CountriesController@index');
    Route::post('countries-grid-data','CountriesController@CountriesGridData');
    Route::get('setup/countries/create','CountriesController@create');
    Route::post('setup/countries/store', 'CountriesController@store');
    Route::get('setup/countries/edit/{id}','CountriesController@edit');
    Route::post('setup/countries/update/{id}', 'CountriesController@update');
    Route::get('setup/countries/delete/{id}','CountriesController@destroyview');
    Route::post('setup/countries/delete/{id}','CountriesController@destroy');


    //City
        Route::get('setup/city','CityController@index');
        Route::post('city-grid-data','\App\Http\Controllers\CityController@CityGridData');
        Route::get('setup/city/create','CityController@create');
        Route::post('setup/city/store', '\App\Http\Controllers\CityController@store');
        Route::get('setup/city/edit/{id}','\App\Http\Controllers\CityController@edit');
        Route::post('setup/city/update/{id}', 'CityController@update');
        Route::get('setup/city/delete/{id}','CityController@destroyview');
        Route::post('setup/city/delete/{id}','CityController@destroy');


    //Vehicles 
        Route::get('General-Setup/vehiclesinfo','VehiclesController@index');
        Route::post('vehicles-grid-data','\App\Http\Controllers\VehiclesController@VachGridData');
        Route::get('vehicles/create','VehiclesController@create');
        Route::post('vehicles/store', '\App\Http\Controllers\VehiclesController@store');
        Route::get('vehicles/edit/{vech_id}','\App\Http\Controllers\VehiclesController@edit');
        Route::post('vehicles/update/{id}', 'VehiclesController@update');
        Route::get('vehicles/delete/{id}','VehiclesController@destroyview');
        Route::post('vehicles/delete/{id}','VehiclesController@destroy');

    //customer strat
        Route::get('customer','CustomerController@index');
        Route::post('customer-grid-data','CustomerController@CustomerGridData');
        Route::get('customer/create','CustomerController@create');
        Route::post('customer/store', 'CustomerController@store');
        Route::get('customer/edit/{id}','CustomerController@edit');
        Route::post('customer/update/{id}', 'CustomerController@update');
        Route::get('customer/delete/{id}','CustomerController@destroyview');
        Route::post('customer/delete/{id}','CustomerController@destroy');
    Route::get('customer/customeapprovals','CustomerController@CustomerApprove');
    Route::post('customer-approve-grid-data','CustomerController@CustomerApproveGridData');
        Route::get('customer/approve/{id}','CustomerController@CustomerApproval');
        Route::get('customer/disable/{id}','CustomerController@CustomerDisable');
    Route::post('customer/approve-data/{id}','CustomerController@ApproveDataCustomer');
    Route::post('customer/disable-data/{id}','CustomerController@DisableDataCustomer');
    //customer End

    //Cost Center start
        Route::get('setup/costcenter','CostCenterController@index');
        Route::post('costcenter-grid-data','CostCenterController@CustomerGridData');
        Route::get('setup/costcenter/create','CostCenterController@create');
        Route::post('setup/costcenter/store', 'CostCenterController@store');
        Route::get('setup/costcenter/edit/{id}','CostCenterController@edit');
        Route::post('setup/costcenter/update/{id}', 'CostCenterController@update');
        Route::get('setup/costcenter/delete/{id}','CostCenterController@destroyview');
        Route::post('setup/costcenter/delete/{id}','CostCenterController@destroy');
        Route::get('admin/delete/', 'BookingController@delete_order');

    //Cost Center End


    //Fuel Sation strat
        Route::get('General-Setup/fuelstationinfo','FuelStationController@index');
        Route::post('fuelstation-grid-data','FuelStationController@CustomerGridData');
        Route::get('fuelstation/create','FuelStationController@create');
        Route::post('fuelstation/store', 'FuelStationController@store');
        Route::get('fuelstation/edit/{id}','FuelStationController@edit');
        Route::post('fuelstation/update/{id}', 'FuelStationController@update');
        Route::get('fuelstation/delete/{id}','FuelStationController@destroyview');
        Route::post('fuelstation/delete/{id}','FuelStationController@destroy');
    //Fuel Sation End

    //Driver
        Route::get('General-Setup/driversinfo','DriversController@index');
        Route::post('/drivers-grid-data','\App\Http\Controllers\DriversController@DriversGridData');
        Route::get('driver/create','DriversController@create');
        Route::post('driver/store', '\App\Http\Controllers\DriversController@store');
        Route::get('driver/edit/{driver_id}','\App\Http\Controllers\DriversController@edit');
        Route::post('driver/update/{driver_id}', 'DriversController@update');
        Route::get('driver/delete/{id}','DriversController@destroyview');
        Route::post('driver/delete/{id}','DriversController@destroy');



    //#regionRoutes
        Route::get('General-Setup/routeinfo','RouteController@index');
        Route::post('/route-grid-data','\App\Http\Controllers\RouteController@RouteGridData');
        Route::get('route/create','RouteController@create');
        Route::post('route/store', '\App\Http\Controllers\RouteController@store');
        Route::get('route/edit/{driver_id}','\App\Http\Controllers\RouteController@edit');
        Route::post('route/update/{driver_id}', 'RouteController@update');
        Route::get('route/delete/{id}','RouteController@destroyview');
        Route::post('route/delete/{id}','RouteController@destroy');
    //endregion

    //#region Transactions
        //#region trips
            Route::get('Transactions/tripinfo','TripController@index');
            Route::get('trip/create','TripController@create');
            Route::post('trip/save','TripController@TripSave');
            Route::get('trip/edit/{id}','TripController@edit');
            Route::post('trip/updatesave/{id}','TripController@TripUpdateSave');
            Route::post('/trip-grid-data','TripController@TripGridData');
        //#endregion
        //#region Roadreciept
            Route::post('/roadreceipt-data','TripController@roadreceipt_trip');
            Route::get('Transactions/roadreceiptinfo','RoadreceiptController@index');
            Route::get('roadreceipt/create','RoadreceiptController@create');
            Route::post('roadreceipt/save','RoadreceiptController@RoadReceiptSave');
            Route::get('roadreceipt/edit/{id}','RoadreceiptController@edit');
            Route::post('roadreceipt/updatesave/{id}','RoadreceiptController@RoadReceiptUpdateSave');
            Route::post('/roadreceipt-grid-data','RoadreceiptController@RoadReceiptGridData');

            Route::post('roadreceipt/roadreceipt-data','RoadreceiptController@roadreceipt_trip');

            Route::match(['get','post'],'Report/monthly-transport-report','ReportController@monthWiseTransport');
        //#endregion
        //#region Customer-Inovices
            Route::get('Transactions/Customer-Inovices',['middleware'=> ['permission:Customer Invoices View'],'uses' =>'TripController@CustomerInvoicesIndex']);
            Route::post('transactions/customerinovices/fetch-grid',['middleware'=> ['permission:Customer Invoices View'],'uses' =>'TripController@CustomerInvoicesGridData']);
            Route::get('/Transactions/Customer-Inovices/create-invoice',['middleware'=> ['permission:Customer Invoice Create'],'uses' =>'TripController@CustomerInvoicesCreate']);
            Route::post('/Transactions/Customer-Inovices/create-invoice',['middleware'=> ['permission:Customer Invoice Create'],'uses' =>'TripController@CustomerInvoicesSave']);
            Route::post('/Transactions/Report/monthly-transport-report','TripController@monthWiseTransport');
            Route::post('/Transactions/Report/monthly-transport-report-view','TripController@monthWiseTransportView');
            Route::post('/Transactions/Report/monthly-job-report','TripController@monthWiseJobTransport');
            
            Route::post('/Transactions/Report/getDepreciation','TripController@getVehicleInfo');

            Route::get('/Transactions/Customer-Inovices/view/{id}',['middleware'=> ['permission:Customer Invoices Update'],'uses' =>'TripController@CustomerInvoicesView']);
            Route::get('/Transactions/Customer-Inovices/delete/{id}',['middleware'=> ['permission:Customer Invoices Cancel'],'uses' =>'TripController@CustomerInvoicesDelete']);
            
            
            Route::post('/Transactions/Customer-Inovices/ApproveReject',['middleware'=> ['permission:Customer Invoices Approve Reject'],'uses' =>'TripController@CustomerInvoicesApproveReject']);

            //#region printing
                Route::get('/Transactions/Customer-Inovices/print/customerInvoice/{id}',['middleware'=> ['permission:Print Customer Invoices'],'uses' =>'TripController@PrintCustomerInvoice']);
                Route::post('/Transactions/Customer-Inovices/save-customer-invoice-data/','TripController@SaveCustomerInvoiceData');
            //#endregion
        //#endregion
    //#endregion
    //category Routes
    //Transaction info end

    //Users
        Route::get('users',['middleware'=> ['permission:User List'],'uses' =>'\App\Http\Controllers\UserController@index']);
        Route::post('user-grid-data','\App\Http\Controllers\UserController@userGridData');

        Route::get('users/edit/{user_id}',['middleware'=> ['permission:User Update'],
            'uses' => '\App\Http\Controllers\UserController@edit']);
        Route::post('users/update', '\App\Http\Controllers\UserController@update');
        Route::get('users/create',['middleware'=> ['permission:User Create'],
            'uses' => '\App\Http\Controllers\UserController@create']);
        Route::post('users/store', '\App\Http\Controllers\UserController@store');
        Route::get('users/delete/{user_id}', '\App\Http\Controllers\UserController@destroy');
        Route::post('users/addRole', '\App\Http\Controllers\UserController@addRole');
        Route::get('users/removeRole/{role}/{user_id}', '\App\Http\Controllers\UserController@revokeRole');

        Route::group(['middleware' =>'permission:Reset Password'],function(){

            Route::get('users/changepassword','\App\Http\Controllers\HomeController@getChangePassword');
            Route::post('users/changepassword','\App\Http\Controllers\HomeController@postChangePassword');
        });


    //Rolesvendoronboarding> ['permission:Role List'],
        Route::get('roles', ['middleware'=> ['permission:Role List'],
            'uses' =>'\App\Http\Controllers\RoleController@index']);
        Route::get('roles/edit/{role_id}', ['middleware'=> ['permission:Role Update'],
            'uses' =>'\App\Http\Controllers\RoleController@edit']);
        Route::post('roles/update', '\App\Http\Controllers\RoleController@update');
        Route::get('roles/create', ['middleware'=> ['permission:Role Create'],
            'uses' =>'\App\Http\Controllers\RoleController@create']);
        Route::post('roles/store', '\App\Http\Controllers\RoleController@store');
        Route::post('roles/addPermission', '\App\Http\Controllers\RoleController@addPermission');
        Route::get('roles/removePermission/{permission}/{user_id}', '\App\Http\Controllers\RoleController@revokePermission');
        Route::get('roles/delete/{role_id}', '\App\Http\Controllers\RoleController@destroy');



    //Permissions
        Route::get('permissions', ['middleware'=> ['permission:Permission List'],
            'uses' =>'\App\Http\Controllers\PermissionController@index']);
        Route::get('permissions/edit/{role_id}', ['middleware'=> ['permission:Permission Update'],
            'uses' =>'\App\Http\Controllers\PermissionController@edit']);
        Route::post('permissions/update', '\App\Http\Controllers\PermissionController@update');
        Route::get('permissions/create', ['middleware'=> ['permission:Permission Create'],
            'uses' =>'\App\Http\Controllers\PermissionController@create']);
        Route::post('permissions/store', '\App\Http\Controllers\PermissionController@store');
        Route::get('permissions/delete/{role_id}', '\App\Http\Controllers\PermissionController@destroy');

        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/home', 'HomeController@index')->name('home');

    //end premission
    //#region general-setup
        //#region Workshops
            Route::get('/General-Setup/workshops','WorkshopSetupController@WorkshopHome');
            Route::get('workshops/setup/add','WorkshopSetupController@WorkshopAdd');
            Route::post('workshops/setup/add','WorkshopSetupController@WorkshopSave');
            Route::match(['get', 'post'], 'workshops/setup/fetch-grid', 'WorkshopSetupController@WorkshopGridData');
            Route::get('workshops/setup/update/{id}','WorkshopSetupController@WorkshopEdit');
            Route::post('workshops/setup/update','WorkshopSetupController@WorkshopUpdate');
            Route::get('workshops/setup/delete/{id}','WorkshopSetupController@WorkshopDelete');
            Route::post('workshops/setup/delete/','WorkshopSetupController@WorkshopDeleted');
        //#endregion
        //#region Banks
        Route::get('/General-Setup/Banks',['middleware'=> ['permission:Banks View'],'uses' =>'BankController@BanksHome']);
        Route::match(['get', 'post'],'General-Setup/banks/fetch-grid',['middleware'=> ['permission:Banks View'],'uses' =>'BankController@BankGridData']);
        
        Route::get('/General-Setup/banks/add',['middleware'=> ['permission:Banks Create'],'uses' =>'BankController@BankAdd']);
        Route::post('/General-Setup/banks/save',['middleware'=> ['permission:Banks Create'],'uses' =>'BankController@BankSave']);

        Route::get('/General-Setup/banks/edit/{id}',['middleware'=> ['permission:Banks Update'],'uses' =>'BankController@BankEdit']);
        Route::post('/General-Setup/banks/edit',['middleware'=> ['permission:Banks Update'],'uses' =>'BankController@BankUpdate']);

        Route::get('/General-Setup/banks/delete/{id}',['middleware'=> ['permission:Banks Cancel'],'uses' =>'BankController@BankDelete']);
        Route::post('/General-Setup/banks/delete',['middleware'=> ['permission:Banks Cancel'],'uses' =>'BankController@BankDeleted']);
    //#endregion

    //#region Bank Branches
        Route::get('/General-Setup/Banks/Branches',['middleware'=> ['permission:Bank Branch View'],'uses' =>'BankBranchesController@BankBranchesHome']);
        Route::match(['get', 'post'],'General-Setup/bankbranches/fetch-grid',['middleware'=> ['permission:Bank Branch View'],'uses' =>'BankBranchesController@BankBranchesGridData']);
        
        Route::get('/General-Setup/bankbranches/add',['middleware'=> ['permission:Bank Branch Create'],'uses' =>'BankBranchesController@BankBranchesAdd']);
        Route::post('/General-Setup/bankbranches/save',['middleware'=> ['permission:Bank Branch Create'],'uses' =>'BankBranchesController@BankBranchesSave']);

        Route::get('/General-Setup/bankbranches/edit/{id}',['middleware'=> ['permission:Bank Branch Update'],'uses' =>'BankBranchesController@BankBranchesEdit']);
        Route::post('/General-Setup/bankbranches/edit',['middleware'=> ['permission:Bank Branch Update'],'uses' =>'BankBranchesController@BankBranchesUpdate']);

        Route::get('/General-Setup/bankbranches/delete/{id}',['middleware'=> ['permission:Bank Branch Cancel'],'uses' =>'BankBranchesController@BankBranchesDelete']);
        Route::post('/General-Setup/bankbranches/delete',['middleware'=> ['permission:Bank Branch Cancel'],'uses' =>'BankBranchesController@BankBranchesDeleted']);
    //#endregion

    //#region Accounts
        Route::get('/General-Setup/Accounts',['middleware'=> ['permission:Bank Accounts View'],'uses' =>'BankAccountsController@AccountsHome']);
        Route::match(['get', 'post'],'General-Setup/accounts/fetch-grid',['middleware'=> ['permission:Bank Accounts View'],'uses' =>'BankAccountsController@AccountsGridData']);
        
        Route::get('/General-Setup/accounts/add',['middleware'=> ['permission:Bank Accounts Create'],'uses' =>'BankAccountsController@AccountsAdd']);
        Route::post('/General-Setup/accounts/save',['middleware'=> ['permission:Bank Accounts Create'],'uses' =>'BankAccountsController@AccountsSave']);

        Route::get('/General-Setup/accounts/edit/{id}',['middleware'=> ['permission:Bank Accounts Update'],'uses' =>'BankAccountsController@AccountsEdit']);
        Route::post('/General-Setup/accounts/edit',['middleware'=> ['permission:Bank Accounts Update'],'uses' =>'BankAccountsController@AccountsUpdate']);

        Route::get('/General-Setup/accounts/delete/{id}',['middleware'=> ['permission:Bank Accounts Cancel'],'uses' =>'BankAccountsController@AccountsDelete']);
        Route::post('/General-Setup/accounts/delete',['middleware'=> ['permission:Bank Accounts Cancel'],'uses' =>'BankAccountsController@AccountsDeleted']);
        
        Route::get('/General-Setup/accounts/makePrimary/{id}',['middleware'=> ['permission:Bank Accounts Make Primary'],'uses' =>'BankAccountsController@MakeAccountPrimary']);
        Route::post('/General-Setup/accounts/makePrimary/',['middleware'=> ['permission:Bank Accounts Make Primary'],'uses' =>'BankAccountsController@MakePrimaryAccount']);

        Route::get('/General-Setup/FetchBankBranches/{id}','BankAccountsController@GetBranchFromBank');
    //#endregion
    //#region

    //#region Workshop
        //#region Manufacturer
            Route::get('/workshops/Manufacturers','WorkshopController@ManufacturerHome');
            Route::match(['get','post'],'workshops/Manufacturers/fetch-grid','WorkshopController@ManufacturerGridData');
            Route::get('/workshops/Manufacturers/add','WorkshopController@ManufacturerAdd');
            Route::post('/workshops/Manufacturers/add','WorkshopController@ManufacturerSave');
            Route::get('/workshops/Manufacturers/update/{id}','WorkshopController@ManufacturerEdit');
            Route::post('/workshops/Manufacturers/update','WorkshopController@ManufacturerUpdate');
            Route::get('/workshops/Manufacturers/delete/{id}','WorkshopController@ManufacturerDelete');
            Route::post('/workshops/Manufacturers/delete/','WorkshopController@ManufacturerDeleted');
        //#endregion

        //#region Parts
            Route::get('/workshops/Parts','WorkshopController@PartsHome');
            Route::match(['get','post'],'/workshops/parts/fetch-grid','WorkshopController@PartsGridData');
            Route::get('workshops/parts/add','WorkshopController@addPart');
            Route::post('workshops/parts/add','WorkshopController@SavePart');
            Route::get('workshops/parts/update/{id}','WorkshopController@EditPart');
            Route::post('workshops/parts/update/','WorkshopController@UpdatePart');
            Route::get('workshops/parts/delete/{id}','WorkshopController@DeletePart');
            Route::post('workshops/parts/delete/','WorkshopController@DeletedPart');
        //#endregion

        //#region services
            Route::get('setup/services','WorkshopController@servicesHome');
            Route::match(['get','post'], 'workshops/services/fetch-grid', 'WorkshopController@servicesGridData');
            Route::get('setup/workshops/services/add','WorkshopController@addService');
            Route::post('setup/workshops/services/add','WorkshopController@saveService');
            Route::get('setup/workshops/service/update/{id}','WorkshopController@editService');
            Route::post('setup/workshops/service/update','WorkshopController@updateService');
            Route::get('setup/workshops/service/delete/{id}','WorkshopController@deleteService');
            Route::post('setup/workshops/service/delete/','WorkshopController@deletedService');
        //#endregion

        //#region Jobs
            Route::get('workshops/Jobs','WorkshopController@JobsHome');
            Route::match(['get','post'],'workshops/Jobs/fetch-grid','WorkshopController@JobsGridData');
            Route::get('workshops/job/add','WorkshopController@addJob');
            Route::post('workshops/job/save','WorkshopController@saveJob');
            Route::get('workshops/job/update/{id}','WorkshopController@editJob');
            Route::post('workshops/job/update','WorkshopController@updateJob');
            Route::get('workshops/job/delete/{id}','WorkshopController@deleteJob');
            Route::post('workshops/job/delete','WorkshopController@deletedJob');
            Route::get('workshops/job/view/{id}','WorkshopController@viewJob');
        //#endregion

        //#region maintenance schedule
            Route::get('/workshops/maintenance-schedule','WorkshopController@maintenanceScheduleHome');
            Route::match(['get','post'],'/workshops/maintenance-schedule/fetch-grid','WorkshopController@maintenanceScheduleGridData');

            Route::get('/workshops/maintenance-schedule/add','WorkshopController@maintenanceScheduleAdd');
            Route::post('/workshops/maintenance-schedule/add','WorkshopController@maintenanceScheduleSave');
            
            Route::get('workshops/maintenance-schedule/view/{id}','WorkshopController@maintenanceScheduleView');

            Route::get('workshops/maintenance-schedule/update/{id}','WorkshopController@maintenanceScheduleEdit');
            Route::post('workshops/maintenance-schedule/update','WorkshopController@maintenanceScheduleUpdate');
            Route::get('workshops/maintenance-schedule/remove/{id}','WorkshopController@maintenanceScheduleDelete');
            Route::post('workshops/maintenance-schedule/cancel', 'WorkshopController@maintenanceScheduleDeleted');

        //#endregion

        //#region schedule-job-processing
            Route::get('/workshops/schedule-job-processing','WorkshopController@scheduleJobProcessingHome');
            Route::match(['get','post'],'/workshops/schedule-job-processing/fetch-grid','WorkshopController@scheduleJobProcessingGridData');
            Route::get('/workshops/schedule-job-processing/perform/{id}','WorkshopController@scheduleJobProcessingPerformView');
            Route::post('/workshops/schedule-job-processing/job/save','WorkshopController@scheduleJobProcessingPerformJob');
        //#endregion
    //#endregion


    //#region Project Management
        //#region Projects
            Route::get('project-management/projects','ProjectManagementController@ProjectsHome');
            Route::match(['get', 'post'],'project-management/projects/fetch-grid','ProjectManagementController@ProjectsHomeGridData');
            
            Route::get('project-management/projects/add','ProjectManagementController@ProjectsAdd');
            Route::post('project-management/projects/add','ProjectManagementController@ProjectSave');

            Route::get('project-management/projects/edit/{id}','ProjectManagementController@ProjectEdit');
            Route::post('project-management/projects/edit/','ProjectManagementController@ProjectUpdate');

            Route::get('project-management/projects/delete/{id}','ProjectManagementController@ProjectDelete');
            Route::post('project-management/projects/delete/','ProjectManagementController@ProjectDeleted');
            Route::get('project-management/projects/view/{id}','ProjectManagementController@ProjectView');

        //#endregion
    //#endregion

    //#region Dashboard
        Route::post('dashboard/truckwisedetails','HomeController@vehiclemonthwise');

    //#endregion

    //#region finance
        //#region Chart-of-Account 
            Route::get('/Finance/Chart-of-Account','ChartOfAccountController@chartofaccountHome');
            Route::post('/Finance/Chart-of-Account/child/save','ChartOfAccountController@saveChild');

        //#endregion

        //#region General Voucher
            Route::get('/Finance/General-Voucher','GeneralVoucherController@GeneralVoucherHome');
            Route::match(['get','post'],'/finance/General-Voucher/fetch-grid', 'GeneralVoucherController@GeneralVoucherGridData');

            Route::get('/finance/General-Voucher/create','GeneralVoucherController@GeneralVoucherAdd');
            Route::post('/finance/General-Voucher/save','GeneralVoucherController@GeneralVoucherStore');

            Route::get('/finance/General-Voucher/edit/{id}','GeneralVoucherController@GeneralVoucherEdit');
            Route::post('/finance/General-Voucher/update','GeneralVoucherController@GeneralVoucherUpdate');

            Route::get('/finance/General-Voucher/view/{id}','GeneralVoucherController@GeneralVoucherView');

            Route::get('/finance/General-Voucher/delete/{id}','GeneralVoucherController@GeneralVoucherDelete');
            Route::post('/finance/General-Voucher/deleted','GeneralVoucherController@GeneralVoucherDeleted');
        //#endregion
        
        //#region vehicle Leasing
            Route::get('/Finance/Vehicle-Leasing/',['middleware'=> ['permission:Vehicle Leasing View'],'uses' =>'VehicleLeasingController@VehicleLeasingHome']);
            Route::match(['get','post'],'/vehicles-leasing-grid', ['middleware'=> ['permission:Vehicle Leasing View'],'uses' =>'VehicleLeasingController@VehicleLeasingGridData']);
            
            Route::get('/Finance/Vehicle-Leasing/add', ['middleware'=> ['permission:Vehicle Leasing Create'],'uses' =>'VehicleLeasingController@VehicleLeasingCreate']);
            Route::post('/Finance/Vehicle-Leasing/add', ['middleware'=> ['permission:Vehicle Leasing Create'],'uses' =>'VehicleLeasingController@VehicleLeasingSave']);
                       
            Route::get('/Finance/Vehicle-Leasing/edit/{id}', ['middleware'=> ['permission:Vehicle Leasing Update'],'uses' =>'VehicleLeasingController@VehicleLeasingEdit']);
            Route::post('/Finance/Vehicle-Leasing/edit', ['middleware'=> ['permission:Vehicle Leasing Update'],'uses' =>'VehicleLeasingController@VehicleLeasingUpdate']);

            Route::get('/Finance/Vehicle-Leasing/delete/{id}', ['middleware'=> ['permission:Vehicle Leasing Cancel'],'uses' =>'VehicleLeasingController@VehicleLeasingDelete']);
            Route::post('/Finance/Vehicle-Leasing/delete', ['middleware'=> ['permission:Vehicle Leasing Cancel'],'uses' =>'VehicleLeasingController@VehicleLeasingDeleted']);

        //#endregion
        //#region Depreciations-Paid
            Route::get('/Finance/Depreciations-Paid/',['middleware'=> ['permission:Depreciations Paid View'],'uses' =>'DepreciationsPaidController@DepreciationsPaidHome']);
         
             Route::match(['get','post'],'/depreciations-paid-grid', ['middleware'=> ['permission:Depreciations Paid View'],'uses' =>'DepreciationsPaidController@DepreciationsPaidGridData']);
            
            Route::get('/Finance/Depreciations-Paid/add', ['middleware'=> ['permission:Depreciations Paid Create'],'uses' =>'DepreciationsPaidController@DepreciationsPaidCreate']);
            Route::post('/Finance/Depreciations-Paid/add', ['middleware'=> ['permission:Depreciations Paid Create'],'uses' =>'DepreciationsPaidController@DepreciationsPaidSave']);
                   
            Route::get('/Finance/Depreciations-Paid/edit/{id}', ['middleware'=> ['permission:Depreciations Paid Update'],'uses' =>'DepreciationsPaidController@DepreciationsPaidEdit']);
            Route::post('/Finance/Depreciations-Paid/edit', ['middleware'=> ['permission:Depreciations Paid Update'],'uses' =>'DepreciationsPaidController@DepreciationsPaidUpdate']);
            
            
            Route::get('/Finance/Depreciations-Paid/delete/{id}', ['middleware'=> ['permission:Depreciations Paid Cancel'],'uses' =>'DepreciationsPaidController@DepreciationsPaidDelete']);
            Route::post('/Finance/Depreciations-Paid/delete', ['middleware'=> ['permission:Depreciations Paid Cancel'],'uses' =>'DepreciationsPaidController@DepreciationsPaidDeleted']);
            
        //#endregion
        //#region Expense-Payment
            Route::get('/Finance/Expense-Payment/',['middleware'=> ['permission:Expense Payment View'],'uses' =>'ExpensePaymentController@ExpensePaymentHome']);
         
            Route::match(['get','post'],'/expense-payment-grid', ['middleware'=> ['permission:Expense Payment View'],'uses' =>'ExpensePaymentController@ExpensePaymentGridData']);
            
            Route::get('/Finance/Expense-Payment/add', ['middleware'=> ['permission:Expense Payment Create'],'uses' =>'ExpensePaymentController@ExpensePaymentCreate']);
            Route::post('/Finance/Expense-Payment/add', ['middleware'=> ['permission:Expense Payment Create'],'uses' =>'ExpensePaymentController@ExpensePaymentSave']);
            /*           
            Route::get('/Finance/Vehicle-Leasing/edit/{id}', ['middleware'=> ['permission:Vehicle Leasing Update'],'uses' =>'VehicleLeasingController@VehicleLeasingEdit']);
            Route::post('/Finance/Vehicle-Leasing/edit', ['middleware'=> ['permission:Vehicle Leasing Update'],'uses' =>'VehicleLeasingController@VehicleLeasingUpdate']);

            Route::get('/Finance/Vehicle-Leasing/delete/{id}', ['middleware'=> ['permission:Vehicle Leasing Cancel'],'uses' =>'VehicleLeasingController@VehicleLeasingDelete']);
            Route::post('/Finance/Vehicle-Leasing/delete', ['middleware'=> ['permission:Vehicle Leasing Cancel'],'uses' =>'VehicleLeasingController@VehicleLeasingDeleted']);
            */
        //#endregion
        //#region Invoice-Amount-Receivable
            Route::get('/Finance/Invoice-Amount-Receivable/',['middleware'=> ['permission:Invoice Amount Receivable View'],'uses' =>'InvoiceAmountReceivableController@InvoiceAmountReceivableHome']);
         
            Route::match(['get','post'],'/invoice-amount-receivable-grid', ['middleware'=> ['permission:Invoice Amount Receivable View'],'uses' =>'InvoiceAmountReceivableController@InvoiceAmountReceivableGridData']);
            
            Route::get('/Finance/Invoice-Amount-Receivable/add', ['middleware'=> ['permission:Invoice Amount Receivable Create'],'uses' =>'InvoiceAmountReceivableController@InvoiceAmountReceivableCreate']);
            Route::post('/Finance/Invoice-Amount-Receivable/add', ['middleware'=> ['permission:Invoice Amount Receivable Create'],'uses' =>'InvoiceAmountReceivableController@InvoiceAmountReceivableSave']);
            /*           
            Route::get('/Finance/Vehicle-Leasing/edit/{id}', ['middleware'=> ['permission:Vehicle Leasing Update'],'uses' =>'VehicleLeasingController@VehicleLeasingEdit']);
            Route::post('/Finance/Vehicle-Leasing/edit', ['middleware'=> ['permission:Vehicle Leasing Update'],'uses' =>'VehicleLeasingController@VehicleLeasingUpdate']);

            Route::get('/Finance/Vehicle-Leasing/delete/{id}', ['middleware'=> ['permission:Vehicle Leasing Cancel'],'uses' =>'VehicleLeasingController@VehicleLeasingDelete']);
            Route::post('/Finance/Vehicle-Leasing/delete', ['middleware'=> ['permission:Vehicle Leasing Cancel'],'uses' =>'VehicleLeasingController@VehicleLeasingDeleted']);
            */
        //#endregion
    //#region
});
Auth::routes();

