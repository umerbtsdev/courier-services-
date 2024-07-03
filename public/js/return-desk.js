/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 78);
/******/ })
/************************************************************************/
/******/ ({

/***/ 20:
/***/ (function(module, exports) {

(function ($) {
    /*=============================================
    == Constents
    =============================================*/
    var REASON_FOR_RETURN = 'Rejected';
    var REASON_IS_EXCESS = 'Excess';
    var CROSSDOCK = 'crossdock';
    var DECISION_CROSSDOCK = 'Return To Vendor';
    var DECISION_STOCKING = 'Active - R';
    var SO_RETURN = 'SO Return';
    var SO_RETURN_RESPONSE = 'SO_RETURN';

    /*=============================================
    == /return-desk
    =============================================*/

    // will hold response data temporarily.
    var productDetailResponseGlobal = null;
    var is_so_return = false;

    /**
     *
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * Rest
     */
    var resetProductDetail = function resetProductDetail() {
        // barcode
        $('#productDetailsBarcode').val('');
        $('#productDetailsDescription').html('');
        $('#productDetailsPickupID').html('');
        $('#productDetailsMOF').html('');
        $('#productDetailsSKU').html('');
        $('#productDetailsProductCode').html('');
        $('#productDetailsDecision').html('');

        // return id
        $('#vendorDetailReturnID').val('');
        $('#vendorDetailBarcode').val('');
        $('#vendorDetailReturnAdviceID').html('');
        $('#vendorDetailVendorName').html('');
        $('#vendorDetailVendorAddress').html('');
        $('#vendorDetailReturnAdviceGeneratedDate').html('');
        $('#vendorDetailVendorID').html('');

        $('a[href="#tabReturn"], a[href="#tabInventory"]').removeClass('disabled');
        $('#productDetailsReason').prop('disabled', false);

        $('#productDetailsReason').trigger('change');

        // TODO: reset form
    };

    /**
     *
     */
    var resetCheckboxes = function resetCheckboxes() {
        $('#dataTable').DataTable().rows().nodes().to$().find('input[type="checkbox"]:checked').prop('checked', false);
    };

    /**
     *
     */
    var drawVendorList = function drawVendorList(vendorName) {
        $('#dataTable').DataTable().column(2).data().map(function (value, index) {
            return $(value).text();
        }).unique().each(function (value, index) {
            console.log(value);
        });
    };

    /**
     *
     */
    var isRowExists = function isRowExists($el, barcode) {
        var status = false;
        $el.DataTable().rows().nodes().to$().each(function (key, value) {
            if (barcode == $(value).find('[name$="[barcode]"]').val()) {
                status = true;
                return;
            }
        });
        return status;
    };

    /**
     *
     */
    var doesSoExists = function doesSoExists($el, so_return_id) {
            var status = false;
            $el.DataTable().rows().nodes().to$().each(function (key, value) {
                if (so_return_id == $(value).find('[name$="[so_return_id]"]').val()) {
                    status = true;
                    return;
                }
            });
            return status;
        };

    /**
     *
     */
    var toggleReasonForReturn = function toggleReasonForReturn(status) {
        $('#productDetailsReason').attr('disabled', status);
    };

    /**
     *
     */
    $(function () {
        $('#dataTable, #dataTableRefuseItems').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false,
            'pageLength': 10,
            'scrollY': '200px',
            'scrollCollapse': true
        });

        $('#dataTableReturnInventory, #dataTableInventoryMovementtems').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false,
            'pageLength': 10
        });
    });
    
    $('#productDetailsReason').on('change', function (e) {
        var $this = $(this),
            $ReasonForRejection = $('#productDetailsReason');

        if($ReasonForRejection.val() == SO_RETURN) {
            is_so_return = true;
            $('#soReturnID-div').show();
        } else {
            $('#so-return-id').val('');
            $('#soReturnID-div').hide();
            is_so_return = false;
        }
    })

    // get product detail
    $('#productDetailsBarcode, #so-return-id').on('change', function (e) {
        if (!isRowExists($('#dataTable'), $(this).val()) && !isRowExists($('#dataTableReturnInventory'), $(this).val())) {
            var $this = $(this),
                barcode = $('#productDetailsBarcode').val(),
                $productDetailsDescription = $('#productDetailsDescription'),
                $productDetailsPickupID = $('#productDetailsPickupID'),
                $productDetailsMOF = $('#productDetailsMOF'),
                $productDetailsSKU = $('#productDetailsSKU'),
                $productDetailsProductCode = $('#productDetailsProductCode'),
                $ReasonForRejection = $('#productDetailsReason'),
                is_so_return = false,
                so_return_id = null;

            if($('#productDetailsReason').val() == SO_RETURN) {
                is_so_return = "Yes";
                so_return_id = $('#so-return-id').val();

                // barcode validation
                if (barcode === '' || so_return_id === '') {
                    //alert('Please enter the SO-Return-ID & scan Barcode.');
                    return false;
                }
            } else {
                // barcode validation
                if (barcode === '') {
                    resetProductDetail();
                    return false;
                }
            }

            $.ajax({
                url: '/ajax/return-desk/product-detail',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    barcode: barcode,
                    is_so_return: is_so_return,
                    so_return_id: so_return_id
                }
            }).done(function (response) {
                // Update appropriate fields
                if (response != 0) {
                    $productDetailsDescription.html(response['description']);
                    $productDetailsPickupID.html(response['pickup_id']);
                    $productDetailsMOF.html(response['request_type']);
                    $productDetailsSKU.html(response['sku']);
                    $productDetailsProductCode.html(response['item_id']);

                    productDetailResponseGlobal = response;

                    if (productDetailResponseGlobal.reason_for_return === SO_RETURN_RESPONSE ||
                        productDetailResponseGlobal.reason_for_return === REASON_FOR_RETURN ||
                        productDetailResponseGlobal.request_type === CROSSDOCK) {
                        // Crossdock - QC-Rejected / SO-return
                        $('#productDetailsDecision').html(DECISION_CROSSDOCK);
                        $('#addItem').attr('data-add-to', 'return');
                        toggleReasonForReturn(false);
                        $('a[href="#tabReturn"]').removeClass('disabled').trigger('click');
                        $('a[href="#tabInventory"]').addClass('disabled');
                    } else {
                        // Inventory
                        $('#productDetailsDecision').html(DECISION_STOCKING);
                        $('#addItem').attr('data-add-to', 'inventory');
                        //toggleReasonForReturn(false);
                        $('a[href="#tabInventory"]').removeClass('disabled').trigger('click');
                        $('a[href="#tabReturn"]').addClass('disabled');
                    }

                    var length = $('#productDetailsReason > option').length;

                    // QCR and EXCESS Inventory checks
                    if(length <= 3 && (productDetailResponseGlobal.reason_for_return === REASON_FOR_RETURN ||
                        productDetailResponseGlobal.reason_for_return === REASON_IS_EXCESS)) {

                        $('#productDetailsReason').prepend (
                            "<option>Excess Inventory</option>"
                        );
                        $('#productDetailsReason').prepend (
                            "<option>QC Rejected</option>"
                        );
                    }

                    if (productDetailResponseGlobal.reason_for_return === REASON_FOR_RETURN) {
                        $('#productDetailsReason option:eq(0)').prop('selected', true);
                        $productDetailsMOF.html(response['request_type'] + ' - (QC Rejected)');
                        toggleReasonForReturn(true);
                        $('a[href="#tabReturn"]').removeClass('disabled').trigger('click');
                        $('a[href="#tabInventory"]').addClass('disabled');
                    } else if (productDetailResponseGlobal.reason_for_return === REASON_IS_EXCESS) {
                        $('#productDetailsReason option:eq(1)').prop('selected', true);
                        $productDetailsMOF.html(response['request_type'] + ' - (Excess Inventory)');
                        toggleReasonForReturn(true);
                        $('a[href="#tabReturn"]').removeClass('disabled').trigger('click');
                        $('a[href="#tabInventory"]').addClass('disabled');
                    } else {
                        if(length == 5) {
                            $("#productDetailsReason option:eq(0)").remove();
                            $("#productDetailsReason option:eq(0)").remove();
                        }
                    }
                } else {
                    resetProductDetail();
                    alert('Please use valid Barcode.');
                }
            });
        } else {
            resetProductDetail();
            alert('This item has already been added.');
        }
    });

    $('.form-product-detail').on('submit', function (e) {
        e.preventDefault();

        // barcode validation
        if($('#productDetailsMOF').html() === "") {
            return false;
        } else  if ($('#productDetailsBarcode').val() === '') {
            alert('Please enter a barcode!');
            return false;
        } else {
            var barcode = $('#productDetailsBarcode').val(),
                is_so_return = false,
                so_return_id = null;

            // if the SO-Return is selected
            if($('#productDetailsReason').val() == SO_RETURN) {
                is_so_return = "Yes";

                if($('#so-return-id').val() === '') {
                    alert('Please enter a SO-Return-ID!');
                    return false;
                }

                so_return_id = $('#so-return-id').val();
            }

            $.ajax({
                url: '/ajax/return-desk/product-detail',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    barcode: barcode,
                    is_so_return: is_so_return,
                    so_return_id: so_return_id
                }
            }).done(function (response) {
                productDetailResponseGlobal = response;

                //alert(productDetailResponseGlobal['return_quantity']);

                // Update appropriate fields
                if (response != 0) {
                    if (is_so_return==="Yes" || $('#addItem').attr('data-add-to') == 'return') {
                        if (!isRowExists($('#dataTable'), $('#productDetailsBarcode').val())) {
                            var rowIndex = $('#dataTable').DataTable().rows().nodes().length;

                            // is the SO scanned
                            if(is_so_return==="Yes") {
                                if(rowIndex!=0) {
                                    // if the so exists check - does not allow scanning of any other SO item
                                    if(!doesSoExists($('#dataTable'), so_return_id)) {
                                        alert("Invalid Item !!! The item has to be of the same SO-Return.");
                                        return false;
                                    }

                                    /*console.log(' so_return_id  '+ so_return_id);
                                    console.log(' sku  '+ productDetailResponseGlobal['sku']);
                                    console.log(' return_quantity  '+ productDetailResponseGlobal['return_quantity']);*/

                                    // Number of SO return quantity is completed per SKU
                                    if($('input[name^="returnItems[' + so_return_id + '][' + productDetailResponseGlobal['sku'] + ']"]').length
                                        == productDetailResponseGlobal['return_quantity']) {

                                        alert("Sorry! The number of SO Quantity exceeds by adding this one.");
                                        return false;
                                    }
                                }

                                // Add item
                                $('#dataTable').DataTable().row.add([
                                    '<p class="text-center"><input type="checkbox" name="returnItems[' + rowIndex + '][vendor_id]" value="' + productDetailResponseGlobal['vendor_id'] + '"></p>',
                                    '<p>' + barcode + '<input type="hidden" name="returnItems[' + rowIndex + '][barcode]" value="' + barcode + '"/></p>',
                                    '<p>' + productDetailResponseGlobal['vendor_name'] + '<input type="hidden" name="returnItems[' + rowIndex + '][vendor_name]" value="' + productDetailResponseGlobal['vendor_name'] + '" /></p>',
                                    '<p>' + productDetailResponseGlobal['name'] + '<input type="hidden" name="returnItems[' + rowIndex + '][product_name]" value="' + productDetailResponseGlobal['name'] + '" /><input type="hidden" name="returnItems[' + rowIndex + '][product_description]" value="' + productDetailResponseGlobal['description'] + '" /></p>',
                                    '<p>' + productDetailResponseGlobal['item_id'] + '<input type="hidden" name="returnItems[' + rowIndex + '][product_code]" value="' + productDetailResponseGlobal['item_id'] + '" /></p>',
                                    '<p>' + $('#productDetailsReason').val() + '<input type="hidden" name="returnItems[' + rowIndex + '][reason_for_return]" value="' + $('#productDetailsReason').val() + '"/></p>',
                                    '<p class="text-center"><input type="hidden" name="returnItems[' + rowIndex + '][sku]" value="' + productDetailResponseGlobal['sku'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][so_return_id]" value="' + so_return_id + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][inventory_type]" value="' + productDetailResponseGlobal['request_type'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][pickup_id]" value="' + productDetailResponseGlobal['pickup_id'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][vendor_contact]" value="' + productDetailResponseGlobal['vendor_contact'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][placement_status]" value="297"/>' +
                                    '<input type="hidden" name="returnItems[' + so_return_id + '][' + productDetailResponseGlobal['sku'] + ']" value="so_sku_uniqueID"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][vendor_address]" value="' + productDetailResponseGlobal['vendor_address'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][so_return_quantity]" value="' + productDetailResponseGlobal['return_quantity'] + '"/>' +
                                    '<button class="btn btn-xs remove-item" type="button" name="button"><i class="fa fa-close"></i></button></p>']).draw(false);
                            } else {
                                // Add item
                                $('#dataTable').DataTable().row.add([
                                    '<p class="text-center"><input type="checkbox" name="returnItems[' + rowIndex + '][vendor_id]" value="' + productDetailResponseGlobal['vendor_id'] + '"></p>',
                                    '<p>' + barcode + '<input type="hidden" name="returnItems[' + rowIndex + '][barcode]" value="' + barcode + '"/></p>',
                                    '<p>' + productDetailResponseGlobal['vendor_name'] + '<input type="hidden" name="returnItems[' + rowIndex + '][vendor_name]" value="' + productDetailResponseGlobal['vendor_name'] + '" /></p>',
                                    '<p>' + productDetailResponseGlobal['name'] + '<input type="hidden" name="returnItems[' + rowIndex + '][product_name]" value="' + productDetailResponseGlobal['name'] + '" /><input type="hidden" name="returnItems[' + rowIndex + '][product_description]" value="' + productDetailResponseGlobal['description'] + '" /></p>',
                                    '<p>' + productDetailResponseGlobal['item_id'] + '<input type="hidden" name="returnItems[' + rowIndex + '][product_code]" value="' + productDetailResponseGlobal['item_id'] + '" /></p>',
                                    '<p>' + $('#productDetailsReason').val() + '<input type="hidden" name="returnItems[' + rowIndex + '][reason_for_return]" value="' + $('#productDetailsReason').val() + '"/></p>',
                                    '<p class="text-center"><input type="hidden" name="returnItems[' + rowIndex + '][sku]" value="' + productDetailResponseGlobal['sku'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][so_return_id]" value="' + so_return_id + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][inventory_type]" value="' + productDetailResponseGlobal['request_type'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][pickup_id]" value="' + productDetailResponseGlobal['pickup_id'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][vendor_contact]" value="' + productDetailResponseGlobal['vendor_contact'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][placement_status]" value="297"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][vendor_address]" value="' + productDetailResponseGlobal['vendor_address'] + '"/>' +
                                    '<input type="hidden" name="returnItems[' + rowIndex + '][so_return_quantity]" value="' + productDetailResponseGlobal['return_quantity'] + '"/>' +
                                    '<button class="btn btn-xs remove-item" type="button" name="button"><i class="fa fa-close"></i></button></p>']).draw(false);
                            }
                        } else {
                            resetProductDetail();
                            alert('This item has already been added.');
                        }

                        // Add to vendor name list
                        // TODO: change to filter
                        if ($('#vendorNameLists option[value="' + productDetailResponseGlobal['vendor_id'] + '"]').length == 0) {
                            $('#vendorNameLists').append('<option value="' + productDetailResponseGlobal['vendor_id'] + '">' + productDetailResponseGlobal['vendor_name'] + '</option>');
                        }

                        // set resposnse to null
                        resetCheckboxes();
                    } else if ($('#addItem').attr('data-add-to') == 'inventory') {

                        if (!isRowExists($('#dataTableReturnInventory'), $('#productDetailsBarcode').val())) {

                            var formData = new FormData();
                            formData.append('_token', $('input[name="_token"]').val());
                            formData.append('vendor_id', productDetailResponseGlobal['vendor_id']);
                            formData.append('barcode', barcode);
                            formData.append('pickup_id', productDetailResponseGlobal['pickup_id']);
                            formData.append('product_code', productDetailResponseGlobal['item_id']);
                            formData.append('sku', productDetailResponseGlobal['sku']);
                            formData.append('vendor_name', productDetailResponseGlobal['vendor_name']);
                            formData.append('product_name', productDetailResponseGlobal['name']);

                            $.ajax({
                                url: '/ajax/return-desk-inventory/add',
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: 'json'
                            }).done(function (response) {
                                if (!response.rowExists) {
                                    $('#dataTableReturnInventory').DataTable().row.add([
                                        '<p><input type="hidden" name="[barcode]" value="' + response.theRow['barcode'] + '" />' + response.theRow['barcode'] + '</p>',
                                        '<p>' + response.theRow['vendor_name'] + '</p>', '<p>' + response.theRow['product_name'] + '</p>',
                                        '<p>' + response.theRow['product_code'] + '</p>', '<p>' + response.theRow['inventory_type'] + '</p>']).draw(false);
                                } else {
                                    alert('Selected items were already in the database.');
                                }
                            });
                        } else {
                            alert('This item has already been added.');
                        }
                    }
                }
            });

            // set resposnse to null
            resetProductDetail();
            productDetailResponseGlobal = null;
        }
    });

    // Reset product details form
    $('form').on('reset', function (e) {
        resetProductDetail();
    });

    // Remove row
    $('#dataTable tbody, #dataTableInventoryMovementtems tbody').on('click', '.remove-item', function () {
        if (confirm('Are you sure to continue with this?')) {
            $('#dataTable').DataTable().row($(this).parents('tr')).remove().draw();
            $('#dataTableInventoryMovementtems').DataTable().row($(this).parents('tr')).remove().draw();
        }
    });

    // Select identical vendor rows
    $(document).on('change', '#vendorNameLists', function (e) {
        resetCheckboxes();
        $('input:checkbox[value="' + $(this).val() + '"]', $('#dataTable').DataTable().rows().nodes().to$()).prop('checked', true);
    });

    // Check if checkboxes are idential
    $(document).on('click', '#form-return-items input[type="checkbox"]', function (e) {
        var $this = $(this);
        $('#dataTable').DataTable().rows().nodes().to$().find('input[type="checkbox"]:checked').not($(this)).each(function (key, value) {
            if ($this.val() != $(value).val()) {
                alert('Please select same vendor');
                e.preventDefault();
                return false;
            }
        });
    });

    $('#form-return-items [type="submit"]').on('click', function (e) {
        e.preventDefault();

        if ($('#dataTable').DataTable().rows().nodes().to$().find('input[type="checkbox"]:checked').length == 0) {
            alert('Please select a vendor');
            return false;
        }

        $('#form-return-items').submit();
        $('#dataTable').DataTable().rows($('input:checked').parents('tr')).remove().draw();
    });

    // Clear return list items
    $('.clear-return-list-items').on('click', function () {
        $('#dataTable').DataTable().clear().draw();
    });

    /*=============================================
    == /return-desk/refuse
    =============================================*/

    var toggleVendorDetailBarcodeStatus = function toggleVendorDetailBarcodeStatus(status) {
        $('#vendorDetailBarcode').prop('disabled', status);
        $('#vendorDetailReasonForRefusal').prop('disabled', status);
    };

    // get product detail - return page
    $('#vendorDetailReturnID').on('change', function (e) {
        var $this = $(this),
            returnID = $this.val(),
            $vendorDetailReturnAdviceID = $('#vendorDetailReturnAdviceID'),
            $vendorDetailVendorName = $('#vendorDetailVendorName'),
            $vendorDetailVendorAddress = $('#vendorDetailVendorAddress'),
            $vendorDetailReturnAdviceGeneratedDate = $('#vendorDetailReturnAdviceGeneratedDate'),
            $vendorDetailVendorID = $('#vendorDetailVendorID');

        $.ajax({
            url: '/ajax/return-desk/vendor-detail',
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                returnID: returnID
            }
        }).done(function (response) {
            $('#dataTableRefuseItems').DataTable().clear().draw();
            if (response.returnItems.length) {
                var returnAdviceDate = '';

                // Add items
                $.each(response.returnItems, function (index, value) {
                    $('#dataTableRefuseItems').DataTable().row.add([
                        '<p><input type="hidden" name="returnItems[' + value.barcode + '][barcode]" value="' + value.barcode + '" />' + value.barcode + '</p>',
                        '<p><input type="hidden" name="returnItems[' + value.barcode + '][sku]" value="' + value.sku + '" />' + value.sku + '</p>',
                        '<p><input type="hidden" name="returnItems[' + value.barcode + '][refusal_status]" value="Not Refused"  />' + value.refusal_status + '</p>',
                        '<p><input type="hidden" name="returnItems[' + value.barcode + '][reason_for_refusal]" value="' + value.reason_for_refusel + '"  />' + (value.reason_for_refusel == null ? '' : value.reason_for_refusel) + '</p>',
                        '<p class="text-center"><button type="button" class="btn btn-xs" disabled><i class="fa fa-refresh"></i></button></p>']).draw(false);

                    returnAdviceDate = value.created_at;
                });

                $vendorDetailReturnAdviceID.html($this.val());
                $vendorDetailReturnAdviceGeneratedDate.html(returnAdviceDate);
                $vendorDetailVendorName.html(response.vendorInfo.vendor_name);
                $vendorDetailVendorAddress.html(response.vendorInfo.vendor_address);
                $vendorDetailVendorID.html(response.vendorInfo.vendor_id);

                // Reset barcode
                toggleVendorDetailBarcodeStatus(false);

                productDetailResponseGlobal = response.returnItems;
            } else {
                alert('This Return ID is not valid');
                toggleVendorDetailBarcodeStatus(true);
                resetProductDetail();
            }
        });
    });

    /**
     *
     */
    $('#vendorDetailBarcode').on('change', function (e) {

        if ($('#vendorDetailReasonForRefusal').val() == '') {
            alert('Please select Reason first');
            $('#vendorDetailBarcode').val('');
            return false;
        }

        var theTable = $('#dataTableRefuseItems');
        var $this = $(this);

        if (isRowExists(theTable, $(this).val())) {
            theTable.DataTable().rows().nodes().to$().each(function (index, value) {
                if ($this.val() == $(value).find('[name$="[barcode]"]').val()) {
                    var rowData = theTable.DataTable().row(value).data();
                    var uniqueIndex = $(value).find('[name$="[barcode]"]').val();
                    rowData[2] = $(rowData[2]).html('<p><input type="hidden" name="returnItems[' + uniqueIndex + '][refusal_status]" value="Refused" />Refused</p>').html();
                    rowData[3] = $(rowData[3]).html('<p><input type="hidden" name="returnItems[' + uniqueIndex + '][updated]" value="1" /><input type="hidden" name="returnItems[' + uniqueIndex + '][reason_for_refusal]" value="' + $('#vendorDetailReasonForRefusal').val() + '" />' + $('#vendorDetailReasonForRefusal').val() + '</p>').html();
                    rowData[4] = $(rowData[4]).html('<p class="text-center"><button type="button" class="btn btn-xs reset-row"><i class="fa fa-refresh"></i></button></p>').html();
                    rowData[5] = $(rowData[5]).html('<input type="hidden" name="returnItems[' + uniqueIndex + '][return_id]" value="' + $('#vendorDetailReturnID').val() + '"  />').html();
                    theTable.DataTable().row(value).data(rowData).draw();
                }
            });
        } else {
            alert('Barcode has already been scanned. Try a different one !!!');
        }
        $this.val('');
    });

    /**
     *
     */
    $('#dataTableRefuseItems tbody').on('click', '.reset-row', function () {
        var theTable = $('#dataTableRefuseItems').DataTable();
        var theRow = $(this).parents('tr');
        var rowData = theTable.row(theRow).data();
        var index = theTable.row(theRow).index();

        rowData[2] = $(rowData[2]).html('<p><input type="hidden" name="returnItems[' + index + '][refusal_status]" value="Not Refused"/>Not Refused</p>').html();
        rowData[3] = $(rowData[3]).html('<p><input type="hidden" name="returnItems[' + index + '][updated]" value="1" /><input type="hidden" name="returnItems[' + index + '][reason_for_refusal]" /></p>').html();
        rowData[4] = $(rowData[4]).html('<p class="text-center"><button type="button" class="btn btn-xs" disabled><i class="fa fa-refresh"></i></button></p>').html();
        rowData[5] = $(rowData[5]).html('<input type="hidden" name="returnItems[' + index + '][return_id]" value="' + $('#vendorDetailReturnID').val() + '"  />').html();

        theTable.row(theRow).data(rowData).draw();
    });

    /*=============================================
    == /return-desk/inventory-movement
    =============================================*/

    // Date picker
    $('#inventoryMovementDecisionFrom, #inventoryMovementDecisionTo').datepicker({
        autoclose: true
    });

    // get put away inventory
    $('#formInventoryMovement [type="submit"]').on('click', function (e) {
        e.preventDefault();

        var $inventoryMovementStatus = $('#inventoryMovementStatus'),
            $inventoryMovementDecisionFrom = $('#inventoryMovementDecisionFrom'),
            $inventoryMovementDecisionTo = $('#inventoryMovementDecisionTo');

        $.ajax({
            url: '/ajax/return-desk/inventory-movement-items',
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                status: $inventoryMovementStatus.val(),
                decisionFrom: $inventoryMovementDecisionFrom.val(),
                decisionTo: $inventoryMovementDecisionTo.val()
            }
        }).done(function (response) {
            $('#dataTableInventoryMovementtems').DataTable().clear().draw();

            if (response) {
                // Add items
                $.each(response, function (index, value) {
                    $('#dataTableInventoryMovementtems').DataTable().row.add(['<p><input type="hidden" name="returnItems[' + index + '][barcode]" value="' + value.barcode + '" />' + value.barcode + '</p>', '<p><input type="hidden" name="returnItems[' + index + '][created_at]" />' + value.created_at + '</p>', '<p><input type="hidden" name="returnItems[' + index + '][inventory_status]" />' + value.inventory_status + '</p>', '<p><input type="hidden" name="returnItems[' + index + '][placement_status]" />' + (value.placement_status == null ? '' : 'Active') + '</p>', '<p class="text-center"><button type="button" class="btn btn-xs" disabled><i class="fa fa-refresh"></i></button></p>']).draw(false);
                });
            } else {
                alert('No data found.');
            }
        });
    });

    /**
     *
     */
    $('#inventoryMovementBarcode').on('change', function (e) {
        if (!isRowExists($('#dataTableInventoryMovementtems'), $(this).val())) {
            $.ajax({
                url: '/ajax/return-desk/inventory-movement-items',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    barcode: $(this).val()
                }
            }).done(function (response) {
                //$('#dataTableInventoryMovementtems').DataTable().clear().draw();

                var itemsCount = $('#dataTableInventoryMovementtems').DataTable().data().length;

                if (response.length != 0) {
                    // Add items
                    $.each(response, function (index, value) {
                        $('#dataTableInventoryMovementtems').DataTable().row.add(['<p>' +
                        '<input type="hidden" name="returnItems[' + itemsCount + '][barcode]" value="' + value.barcode + '" />' + value.barcode + '</p>', '<p>' +
                        '<input type="hidden" name="returnItems[' + itemsCount + '][created_at]" />' + value.created_at + '</p>', '<p>' +
                        '<input type="hidden" name="returnItems[' + itemsCount + '][inventory_status]" value="Done" />' + 'Done' + '</p>', '<p>' +
                        '<input type="hidden" name="returnItems[' + itemsCount + '][placement_status]" value="297" />' + 'Active - R' + '</p>', '<p class="text-center">' +
                        '<button class="btn btn-xs remove-item" type="button" name="button"><i class="fa fa-close"></i></button></p>']).draw(false);
                    });
                } else {
                    alert('Please enter valid barcode');
                }
            });
        } else {
            alert('Barcode has already been scanned. Try a different one !!!');
        }

        $(this).val('');
    });

    /**
     *
     */
    $('#dataTableInventoryMovementtems tbody').on('click', '.reset-row', function () {
        var theTable = $('#dataTableInventoryMovementtems').DataTable();
        var theRow = $(this).parents('tr');
        var rowData = theTable.row(theRow).data();
        var index = theTable.row(theRow).index();

        rowData[2] = $(rowData[2]).html('<p><input type="hidden" name="returnItems[' + index + '][inventory_status]" value="Pending"/>Pending</p>').html();
        rowData[3] = $(rowData[3]).html('<p><input type="hidden" name="returnItems[' + index + '][updated]" value="1" /><input type="hidden" name="returnItems[' + index + '][placement_status]" /></p>').html();
        rowData[4] = $(rowData[4]).html('<p class="text-center"><button type="button" class="btn btn-xs" disabled><i class="fa fa-refresh"></i></button></p>').html();

        theTable.row(theRow).data(rowData).draw();
    });
})(jQuery);

/***/ }),

/***/ 78:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(20);


/***/ })

/******/ });