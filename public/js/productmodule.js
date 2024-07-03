var product = {
    loadmagnificPopup:function(){
        jQuery('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return item.el.attr('title') + '<small>by TCS Ecom</small>';
                }
            }
        });

    },
    updatecatdropdownl1: function(){
        $('#categoryl1').find("option").remove();
        $('#categoryl1').append('<option value="">Select L1 Categories</option>');
        for(var item in allcategories["l1categories"])
        {
            $('#categoryl1').append('<option value="'+item+'">'+allcategories["l1categories"][ item ]+'</option>');
        }

        $('#categoryl1').trigger("chosen:updated");
    },
    updatecatdropdownl2: function(){
        var id = $('#categoryl1').val();
        $('#categoryl2').find("option").remove();
        $('#categoryl2').append('<option value="">Select L2 Categories</option>');
        for(var item in allcategories["l2categories"])
        {
            if (allcategories["l2categories"][ item ][1] == id) {
                $('#categoryl2').append('<option value="' + item + '">' + allcategories["l2categories"][item][0] + '</option>');
            }
        }

        $('#categoryl2').trigger("chosen:updated");
    },
    updatecatdropdownl3: function(){
        var id = $('#categoryl2').val();
        $('#categories').find("option").remove();
        $('#categories').append('<option value="">Select L3 Categories</option>');
        for(var item in allcategories["l3categories"])
        {
            if (allcategories["l3categories"][ item ][1] == id)
            {
                $('#categories').append('<option value="'+item+'">'+allcategories["l3categories"][ item ][0]+'</option>');
            }

        }
        $('#categories').trigger("chosen:updated");
    },
    fillconfigurableopt : function(obj, url,token){
        jQuery.ajax({
            url: url,
            type:"post",
            dataType: "json",
            data: {
                "_token": token,
                "attr_id": jQuery(obj).val(),
            },
            success: function(data) {
                $(obj).parent().parent().find(".description").find("option").remove();
                $(obj).parent().parent().find(".description").append('<option value="">Select option</option>');
                for(var a=0; a<data.length; a++)
                {
                    $(obj).parent().parent().find(".description").append('<option value="'+data[a].option_id_yayvo+'">'+data[a].option_value +'</option>');
                }

            }
        });

    },
    showHideCSVRegion: function(downloadURLd){
        var attributeSetVal = jQuery.trim(jQuery('#attribute_sets').val());
        var categoryId 		= jQuery.trim(jQuery('#categories').val());

        var downloadURL = downloadURLd+"/"+attributeSetVal+"/"+categoryId;

        if(attributeSetVal != "" && categoryId != ""){
            jQuery('.csvUploadField>.help-block').html("Click <a href='"+downloadURL+"' target='_blank'>here</a> for Sample CSV");
            jQuery('.csvUploadField').show();
        }else{
            jQuery('.csvUploadField').hide();
        }
    },
    getattributes: function(url,token,attributeurl, downloadURLd){
        if (jQuery('#categories').val() == ""){
            return false;
        }
        var categoryId = jQuery.trim(jQuery('#categories').val());

        product.showHideCSVRegion(downloadURLd);

        //GET ASSOCIATED ATTRIBUTE Sets
        jQuery.ajax({
            url: url,
            type: "post",
            data: {
                "_token": token,
                "categoryId": categoryId
            },
            success: function(result){
                jQuery(".tab1attributearea").html('');
                jQuery(".tab2attributearea").html('');
                $(".optionalattr").find("option").remove();
                $(".optionalattr").append("<option value=''>Select Attribute</option>");
                //UPDATE ATTRIBUTES VALUE
                for(var i = 0; i < result.length; i++)
                {
                    jQuery('#attribute_sets').val(result[i].id);
                    product.attributelist(result[i].sf_attributeid,token,attributeurl);
                }

            }
        });
    },
    isWysiwygareaAvailable: function(){
        // If in development mode, then the wysiwygarea must be available.
        // Split REV into two strings so builder does not replace it :D.
        if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
            return true;
        }

        return !!CKEDITOR.plugins.get( 'wysiwygarea' );
    },
    addckeditor: function(){
        if($(".editor").length > 0)
        {
            if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
                CKEDITOR.tools.enableHtml5Elements( document );

                // The trick to keep the editor in the sample quite small
                // unless user specified own height.
            CKEDITOR.config.height = 150;
            CKEDITOR.config.width = 'auto';
            CKEDITOR.config.autoParagraph = false;
            var wysiwygareaAvailable = product.isWysiwygareaAvailable(),
                isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

            //return function() {
                for(var i = 0; i < $(".editor").length; i++)
                {
                    var editorElement = CKEDITOR.document.getById($(".editor")[i].id);
                    if ( isBBCodeBuiltIn ) {
                        editorElement.setHtml(
                            'Hello world!\n\n' +
                            'I\'m an instance of [url=http://ckeditor.com]CKEditor[/url].'
                        );
                    }
                    // Depending on the wysiwygare plugin availability initialize classic or inline editor.
                    if ( wysiwygareaAvailable ) {
                        CKEDITOR.replace($(".editor")[i].id);
                    } else {
                        editorElement.setAttribute( 'contenteditable', 'true' );
                        CKEDITOR.inline($(".editor")[i].id);

                        // TODO we can consider displaying some info box that
                        // without wysiwygarea the classic editor may not work.
                    }

                }
        }
    },
    attributelist: function(attributesets, token, attributeurl){
        //GET ASSOCIATED ATTRIBUTE Sets
        jQuery.ajax({
            url: attributeurl,
            type: "post",
            data: {
                "_token": token,
                "attribute_sets": attributesets
            },
            success: function(result){

                product.renderproductfrom(result["attr_data"],result["attr_option"], result["configurableattrs"]);
                product.productvalidate();
            }
        });
    },
    addcheckbox: function (html, attr_data, type) {
        html += '<div class="col-xs-12 col-sm-6 col-md-4">';
        html +=  '<div class="form-group">';
            html += '<div class="col-xs-12 col-sm-12 col-md-12" style="min-height: 18px;" ></div>';
            html += '<div class="col-xs-12 col-sm-12 col-md-12" "><label for="Input'+attr_data.value+'">'+attr_data.value+ (attr_data.required == 1 ?'<span style="color: red;">*</span>' : '')+'</label>';
            html += '<label class="switch">'
            if(attr_data.required == 1) {
                html += '<input required="required" type="' + type + '" class="' + attr_data.code + ' ' + attr_data.type + 'required" name="' + attr_data.id + '" id="' + attr_data.id + '" aria-describedby="' + attr_data.value + 'Help" placeholder="Enter ' + attr_data.value + '">';
            }
            else
            {
                html += '<input type="' + type + '" class="' + attr_data.code + ' ' + attr_data.type + '" name="' + attr_data.id + '" id="' + attr_data.id + '" aria-describedby="' + attr_data.value + 'Help" placeholder="Enter ' + attr_data.value + '">';
            }
            html += '<div class="slider round"></div>'
            html += '</label>'
            html += '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    },
    addtextarea: function (html,attr_data, type) {
        html += '<div class="col-xs-12 col-sm-12 col-md-12">';
        html +=  '<div class="form-group">';
            html +=  '<div class="col-xs-12 col-sm-12 col-md-12"><label for="Input'+attr_data.value+'">'+attr_data.value+(attr_data.required == 1 ?'<span style="color: red;">*</span>' : '')+'</label></div>';
            html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            if(attr_data.required == 1)
            {

                html += '<textarea rows="4" class="editor form-control '+attr_data.code+' '+ attr_data.type +'required" name="'+attr_data.id+'" id="'+attr_data.id+'" aria-describedby="'+attr_data.value+'Help" placeholder="Enter '+attr_data.value+'"></textarea>';
            }
            else
            {
                html += '<textarea rows="4" class="editor form-control '+attr_data.code+' '+ attr_data.type +'" name="'+attr_data.id+'" id="'+attr_data.id+'" aria-describedby="'+attr_data.value+'Help" placeholder="Enter '+attr_data.value+'"></textarea>';
            }

            html += '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    },
    addnumberbox: function (html,attr_data, type){
        html += '<div class="col-xs-12 col-sm-6 col-md-4">';
        html +=  '<div class="form-group">';
            html +=  '<div class="col-xs-12 col-sm-12 col-md-12"><label for="Input'+attr_data.value+'">'+attr_data.value+(attr_data.required == 1 ?'<span style="color: red;">*</span>' : '')+'</label></div>';
            var specialchar = "";

            html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            if(attr_data.required == 1)
            {

                html += '<input  type="'+ type +'" class="form-control '+attr_data.code+' '+ attr_data.type +'required numericOnlyField " name="'+attr_data.id+'" id="'+attr_data.id+'" aria-describedby="'+attr_data.value+'Help" placeholder="Enter '+attr_data.value+'" >';
            }
            else
            {
                html += '<input  type="'+ type +'" class="form-control numericfields numericOnlyField '+attr_data.code+' '+ attr_data.type +'" name="'+attr_data.id+'" id="'+attr_data.id+'" aria-describedby="'+attr_data.value+'Help" placeholder="Enter '+attr_data.value+'">';
            }

            html += '</div>';
        html += '</div>';
        html += '</div>';
        return html
    },
    addotherinputfields: function(html,attr_data, type){
        html += '<div class="col-xs-12 col-sm-6 col-md-4">';
        html +=  '<div class="form-group">';
            html +=  '<div class="col-xs-12 col-sm-12 col-md-12"><label for="Input'+attr_data.value+'">'+attr_data.value+(attr_data.required == 1 ?'<span style="color: red;">*</span>' : '')+'</label></div>';
            var specialchar = "";
            if(attr_data.value == "Name"){
                specialchar = "specialcharremovename";
            }
            if(attr_data.value == "Zcode"){
                specialchar = "spaceemovezcode";
            }
            html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            if(attr_data.required == 1)
            {

                html += '<input  type="'+ type +'" class="form-control '+specialchar+' '+attr_data.code+' '+ attr_data.type +'required" name="'+attr_data.id+'" id="'+attr_data.id+'" aria-describedby="'+attr_data.value+'Help" placeholder="Enter '+attr_data.value+'" >';
            }
            else
            {
                html += '<input  type="'+ type +'" class="form-control '+specialchar+' '+attr_data.code+' '+ attr_data.type +'" name="'+attr_data.id+'" id="'+attr_data.id+'" aria-describedby="'+attr_data.value+'Help" placeholder="Enter '+attr_data.value+'">';
            }

            html += '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    },
    addselectbox: function (html,attr_data, type, attr_option) {
        html += '<div class="col-xs-12 col-sm-6 col-md-4">';
        html +=  '<div class="form-group">';
            html +=  '<div class="col-xs-12 col-sm-12 col-md-12"><label for="Input'+attr_data.value+'">'+attr_data.value+(attr_data.required == 1 ?'<span style="color: red;">*</span>' : '')+'</label></div>';
            html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            if(attr_data.required == 1) {

                html += '<select required="required" class="chosen-select form-control ' + attr_data.code + ' ' + attr_data.type + 'required" name="' + attr_data.id + '" id="' + attr_data.id + '" aria-describedby="' + attr_data.value + 'Help" placeholder="Enter ' + attr_data.value + '">';
                html += product.adddefaultvalue(attr_data.code);
                if(product.getValueByKey( attr_data.sf_attributeid, attr_option))
                {
                    html +=  product.getoptionvalue(attr_data.sf_attributeid, attr_option);

                }

                html += '</select>';
            }
            else
            {
                html += '<select class="form-control ' + attr_data.code + ' ' + attr_data.type + '" name="' + attr_data.id + '" id="' + attr_data.id + '" aria-describedby="' + attr_data.value + 'Help" placeholder="Enter ' + attr_data.value + '">';
                html += product.adddefaultvalue(attr_data.code);
                if(product.getValueByKey( attr_data.sf_attributeid, attr_option))
                {
                    html +=  product.getoptionvalue(attr_data.sf_attributeid, attr_option);

                }

                html += '</select>';
            }
            html += '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    },
    renderproductfrom: function(attr_data,attr_option, configurableattr ){
        jQuery(".tab1attributearea").html("");
        //UPDATE ATTRIBUTES VALUE
        //var attr_data = result["attr_data"];
        //var attr_option = result["attr_option"];
        //var configurableattr = result["configurableattrs"];
        for(var i=0; i < attr_data.length; i++)
        {
            if (attr_data[i].value != "")
            {
                var type = "";
                if(attr_data[i].type == "price")
                {
                    type = "number";
                }
                else if(attr_data[i].type == "boolean")
                {
                    type = "checkbox";
                }
                else
                {
                    type =  attr_data[i].type;
                }

                var html = '';
                if (type == "checkbox")
                {
                    html = product.addcheckbox(html, attr_data[i],type);
                }
                else if (type == "select")
                {
                    html = product.addselectbox(html,attr_data[i], type, attr_option);
                }
                else if (type == "textarea")
                {
                    html = product.addtextarea(html,attr_data[i], type);
                }
                else if (type == "number")
                {
                    html = product.addnumberbox(html,attr_data[i], type);
                }
                else
                {
                    html = product.addotherinputfields(html,attr_data[i], type);
                }
                if (attr_data[i].additional_info == 0){
                    jQuery(".tab1attributearea").append(html);
                }
                else
                {
                    jQuery(".tab2attributearea").append(html);
                }
            }

        }
        product.addckeditor();
        $(".optionalattr").find("option").remove();
        $(".optionalattr").append("<option value=''>Select Attribute</option>");
        for(var ii=0; ii < configurableattr.length; ii++){
            $(".optionalattr").append("<option value="+configurableattr[ii].sf_attributeid+">"+configurableattr[ii].NAME+"</option>");

        }
    },
    productvalidate: function(){
        $("#product_data").validate({
            validateDelegate: function() { },
            onsubmit: true,
            errorElement: 'span',
            errorClass: 'help-block error-help-block',
            validClass: "has-success",
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                    // else just place the validation message immediatly after the input
                } else if (element.attr("id") == "categoryl1") {
                    error.insertAfter(element.parent().find(".chosen-container"));
                }
                else if (element.attr("id") == "categoryl2") {
                    error.insertAfter(element.parent().find(".chosen-container"));
                }
                else if (element.attr("id") == "categories") {
                    error.insertAfter(element.parent().find(".chosen-container"));
                }
                else if (element.attr("id") == "mode_of_fullfillment") {
                    error.insertAfter(element.parent().find(".chosen-container"));
                }
                else {
                    error.insertAfter(element);
                }
                //categories
            },
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // add the Bootstrap error class to the control group
            },
            focusInvalid: true, // do not focus the last invalid input
            invalidHandler: function(e, validator) {
                if(validator.errorList.length)
                {
                    $('.' + jQuery(validator.errorList[0].element).closest(".tab-pane").attr('id')).find('a').trigger('click');
                }
            },
            ignore:"ui-tabs-hide",

            rules: {
                categoryl1:"required",
                categoryl2:"required",
                categories:"required",
                mode_of_fullfillment:"required"
            },

        });
        var regexexp = "";
        jQuery.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                regexexp = regexp;
                return this.optional(element) || re.test(value);
            },
            " Please Special Character are not allowed. "
        );
        jQuery.validator.addMethod(
            "numberformat",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                regexexp = regexp;
                return this.optional(element) || re.test(value);
            },
            " you have allowed only 4 decimal places and value should be 0 - 1000000. "
        );

        jQuery.validator.addClassRules("pricerequired", {
            required: true,
            number: true,
            max:0,
            max:1000000,
            numberformat:/^\d{0,7}(?:\.\d{0,4})?$/
        });
        jQuery.validator.addClassRules("numericfields", {
            number: true,
            max:0,
            max:1000000,
            numberformat:/^\d{0,7}(?:\.\d{0,4})?$/
        });
        jQuery.validator.addClassRules("daterequired", {
            required: true,
        });
        jQuery.validator.addClassRules("textrequired", {
            required: true,
            maxlength: 255
        });
        jQuery.validator.addClassRules("textarearequired", {
            required: true,
            maxlength: 10000
        });
        jQuery.validator.addClassRules("selectrequired", {
            required: true,
        });

        jQuery.validator.addClassRules("numberrequired", {
            required: true,
            number: true,
            max:0,
            max:1000000,
            numberformat:/^\d{0,7}(?:\.\d{0,4})?$/
        });
        jQuery.validator.addClassRules("specialcharremovename", {
            required: true,
            maxlength: 255
        });
        jQuery.validator.addClassRules("spaceemovezcode", {
            maxlength: 40
        });
        jQuery.validator.addClassRules("specialcharremovesku", {
            required: true,
            regex : /(^[A-Za-z0-9]+$)+/,
            maxlength: 200
        });
    },
    numericOnlyField: function(){
        jQuery( "body" ).delegate( ".numericOnlyField", "keyup", function(e) {

            return !(e.which != 8 && e.which != 0 &&
            (e.which < 48 || e.which > 57) && e.which != 46);
        });
        jQuery( "body" ).delegate( ".numericOnlyField", "keypress", function(e) {

            return !(e.which != 8 && e.which != 0 &&
            (e.which < 48 || e.which > 57) && e.which != 46);
        });
    },
    desc_config: function(){
        jQuery( "body" ).delegate(".desc_config",'change', function(){
            for(var aa = 1; aa < jQuery(".desc_config").length; aa++)
            {
                if(jQuery(this).val() == jQuery(jQuery(".desc_config")[aa-1]).val()){
                    jQuery(this).parent().find('.dupvalue').remove();
                    jQuery(this).val('');
                    jQuery(this).parent().append("<span style='color:red;' class='dupvalue'>you already add this value</span>")
                    break;
                }
                else
                {
                    jQuery(this).parent().find('.dupvalue').remove();
                }
            }
        })
    },
    removeoptionattribute: function(){
        jQuery('.removeoptionattribute').on('click',function(){

            jQuery(this).closest(".option-attribute-inner1").remove();
            //ADD CLASS FOR MAKING CLONE
            //REMOVE CLASS FROM PREVIOUS DIV FOR CLONE
            jQuery('#tab4primary').find("div.option-attribute-inner1" ).first().addClass('option-attribute-inner');
            //HIDE AND SHOW BUTTON
            product.displayChildHideAndShowBtn('tab4primary','option-attribute-inner1','addoptionattribute','removeoptionattribute');
        });
    },
    addmachinepart:function(){

        //product.displayChildHideAndShowBtn('tab4primary','option-attribute-inner1','addoptionattribute','removeoptionattribute');
        jQuery("#tab_3").on( 'click', '.addoptionattribute', function() {
            // var pickupAddressHtml    =   jQuery('.option-attribute-inner').clone(true);
            // if(jQuery(this).parent().parent().parent().find(".optionalattr").val() == "" || jQuery(this).parent().parent().parent().find(".description").val() == "" || jQuery(this).parent().parent().parent().find(".qty").val() == "" || jQuery(this).parent().parent().parent().find(".price").val() == "")
            // {
            //     if(jQuery(this).parent().parent().parent().find(".optionalattr").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".attributemsg").remove();
            //         jQuery(this).parent().parent().parent().find(".optattrinputs").append("<span style='color:red' class='attributemsg'>Attribute Required</span>");
            //     }else {
            //         jQuery(this).parent().parent().parent().find(".attributemsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".description").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".descriptionmsg").remove();
            //         jQuery(this).parent().parent().parent().find(".descinputs").append("<span style='color:red' class='descriptionmsg'>Description Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".descriptionmsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".qty").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".qtymsg").remove();
            //         jQuery(this).parent().parent().parent().find(".qtyinputs").append("<span style='color:red' class='qtymsg'>Qty Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".qtymsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".price").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".pricemsg").remove();
            //         jQuery(this).parent().parent().parent().find(".priceinputs").append("<span style='color:red' class='pricemsg'>Description Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".pricemsg").remove();
            //     }
            //     return false;
            // }
            // else
            // {
            //     jQuery(".attributemsg").remove();
            //     jQuery(".descriptionmsg").remove();
            //     jQuery(".qtymsg").remove();
            //     jQuery(".pricemsg").remove();
            //
            // }
            var pickupAddressHtml = jQuery(this).parent().parent().parent().clone(true);
            pickupAddressHtml =   pickupAddressHtml.find(".emptyfeild").val("").end();
            pickupAddressHtml.find(".emptyfeildselect").find("option").remove();
            pickupAddressHtml.find(".emptyfeildselect").append("<option value=''>Select option</option>");
            pickupAddressHtml.appendTo('#tab_3');

            pickupAddressHtml.find(".optionalattr").val("");
            //REMOVE CLASS FROM PREVIOUS DIV FOR CLONE
            jQuery('#tab_3').find("div.pickup-address-region" ).first().removeClass('option-attribute-inner');

            //HIDE AND SHOW BUTTON
            product.displayChildHideAndShowBtn('tab_3','option-attribute-inner1','addoptionattribute','removeoptionattribute');



        });
    },
    addmachineschedule:function(){

        //product.displayChildHideAndShowBtn('tab4primary','option-attribute-inner1','addoptionattribute','removeoptionattribute');
        jQuery("#tab_4").on( 'click', '.addoptionattribute', function() {
            // var pickupAddressHtml    =   jQuery('.option-attribute-inner').clone(true);
            // if(jQuery(this).parent().parent().parent().find(".optionalattr").val() == "" || jQuery(this).parent().parent().parent().find(".description").val() == "" || jQuery(this).parent().parent().parent().find(".qty").val() == "" || jQuery(this).parent().parent().parent().find(".price").val() == "")
            // {
            //     if(jQuery(this).parent().parent().parent().find(".optionalattr").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".attributemsg").remove();
            //         jQuery(this).parent().parent().parent().find(".optattrinputs").append("<span style='color:red' class='attributemsg'>Attribute Required</span>");
            //     }else {
            //         jQuery(this).parent().parent().parent().find(".attributemsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".description").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".descriptionmsg").remove();
            //         jQuery(this).parent().parent().parent().find(".descinputs").append("<span style='color:red' class='descriptionmsg'>Description Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".descriptionmsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".qty").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".qtymsg").remove();
            //         jQuery(this).parent().parent().parent().find(".qtyinputs").append("<span style='color:red' class='qtymsg'>Qty Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".qtymsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".price").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".pricemsg").remove();
            //         jQuery(this).parent().parent().parent().find(".priceinputs").append("<span style='color:red' class='pricemsg'>Description Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".pricemsg").remove();
            //     }
            //     return false;
            // }
            // else
            // {
            //     jQuery(".attributemsg").remove();
            //     jQuery(".descriptionmsg").remove();
            //     jQuery(".qtymsg").remove();
            //     jQuery(".pricemsg").remove();
            //
            // }
            var pickupAddressHtml = jQuery(this).parent().parent().parent().clone(true);
            pickupAddressHtml =   pickupAddressHtml.find(".emptyfeild").val("").end();
            pickupAddressHtml.find(".emptyfeildselect").find("option").remove();
            pickupAddressHtml.find(".emptyfeildselect").append("<option value=''>Select option</option>");
            pickupAddressHtml.appendTo('#tab_4');

            pickupAddressHtml.find(".optionalattr").val("");
            //REMOVE CLASS FROM PREVIOUS DIV FOR CLONE
            jQuery('#tab_4').find("div.pickup-address-region" ).first().removeClass('option-attribute-inner');

            //HIDE AND SHOW BUTTON
            product.displayChildHideAndShowBtn('tab_4','option-attribute-inner1','addoptionattribute','removeoptionattribute');



        });
    },
    addoptionattribute:function(){

        //product.displayChildHideAndShowBtn('tab4primary','option-attribute-inner1','addoptionattribute','removeoptionattribute');
        jQuery(document).on( 'click', '.addoptionattribute', function() {
            // var pickupAddressHtml    =   jQuery('.option-attribute-inner').clone(true);
            // if(jQuery(this).parent().parent().parent().find(".optionalattr").val() == "" || jQuery(this).parent().parent().parent().find(".description").val() == "" || jQuery(this).parent().parent().parent().find(".qty").val() == "" || jQuery(this).parent().parent().parent().find(".price").val() == "")
            // {
            //     if(jQuery(this).parent().parent().parent().find(".optionalattr").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".attributemsg").remove();
            //         jQuery(this).parent().parent().parent().find(".optattrinputs").append("<span style='color:red' class='attributemsg'>Attribute Required</span>");
            //     }else {
            //         jQuery(this).parent().parent().parent().find(".attributemsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".description").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".descriptionmsg").remove();
            //         jQuery(this).parent().parent().parent().find(".descinputs").append("<span style='color:red' class='descriptionmsg'>Description Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".descriptionmsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".qty").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".qtymsg").remove();
            //         jQuery(this).parent().parent().parent().find(".qtyinputs").append("<span style='color:red' class='qtymsg'>Qty Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".qtymsg").remove();
            //     }
            //     if(jQuery(this).parent().parent().parent().find(".price").val() == "")
            //     {
            //         jQuery(this).parent().parent().parent().find(".pricemsg").remove();
            //         jQuery(this).parent().parent().parent().find(".priceinputs").append("<span style='color:red' class='pricemsg'>Description Required</span>");
            //     }
            //     else
            //     {
            //         jQuery(this).parent().parent().parent().find(".pricemsg").remove();
            //     }
            //     return false;
            // }
            // else
            // {
            //     jQuery(".attributemsg").remove();
            //     jQuery(".descriptionmsg").remove();
            //     jQuery(".qtymsg").remove();
            //     jQuery(".pricemsg").remove();
            //
            // }
            var pickupAddressHtml = jQuery(this).parent().parent().parent().clone(true);
            pickupAddressHtml =   pickupAddressHtml.find(".emptyfeild").val("").end();
            pickupAddressHtml.find(".emptyfeildselect").find("option").remove();
            pickupAddressHtml.find(".emptyfeildselect").append("<option value=''>Select option</option>");
            pickupAddressHtml.appendTo('#tab_3');

            pickupAddressHtml.find(".optionalattr").val("");
            //REMOVE CLASS FROM PREVIOUS DIV FOR CLONE
            jQuery('#tab_3').find("div.pickup-address-region" ).first().removeClass('option-attribute-inner');

            //HIDE AND SHOW BUTTON
            product.displayChildHideAndShowBtn('tab_3','option-attribute-inner1','addoptionattribute','removeoptionattribute');



        });
    },
    getoptionvalue: function(key, data){
        var i, len = data.length, html = "";
        for(var i = 0;  i< len; i++)
        {
            if (data[i].attribute_id == key) {
                html += '<option value="'+data[i].option_id_yayvo+'">'+data[i].option_value+'</option>';
            }
        }
        return html;
    },
    adddefaultvalue: function(key){
        return '<option value="">Select '+key+'</option>';
    },
    getValueByKey: function(key, data){
        var i, len = data.length;

        for (i = 0; i < len; i++) {
            if (data[i].attribute_id == key) {
                return data[i].attribute_id;
            }
        }

        return -1;
    },
    categoryl1change: function(){
        jQuery('#categoryl1').on('change',function(){
            product.updatecatdropdownl2();
            product.updatecatdropdownl3();
            jQuery(".tab1attributearea").html('');
            jQuery(".tab2attributearea").html('');
        });
    },
    categoryl1changeupdate: function(){
        jQuery('#categoryl1').on('change',function(){
            product.updatecatdropdownl2();
            product.updatecatdropdownl3();

        });
    },
    getalll3categories:function(url,token, vendorid){
        jQuery.ajax({
            url: url,
            type:"post",
            dataType: "json",
            data: {"_token": token,"vendor_id" : vendorid},
            success: function(data) {
                allcategories =data;
                product.updatecatdropdownl1();


            }
        });

    },
    getalll3categoriesupdate:function(url,token, vendorid){
        jQuery.ajax({
            url: url,
            type:"post",
            dataType: "json",
            data: {"_token": token,"vendor_id" : vendorid},
            success: function(data) {
                allcategories =data;
                product.updatecatdropdownl1();
                product.setselectedcategory();

            }
        });

    },
    setselectedcategory: function() {
        var l1cat = "";
        var l2cat = "";

        for(var item in allcategories["l3categories"]) {
            if(item == categoryid){
                l2cat = allcategories["l3categories"][ item ][1];
                break;
            }
        }
        for(var item in allcategories["l2categories"]) {
            if(item == l2cat){
                l1cat = allcategories["l2categories"][ item ][1];
                break;
            }
        }
        $("#categoryl1").val(l1cat);
        $("#categoryl1").change();
        $('#categoryl1').trigger("chosen:updated");

        $("#categoryl2").val(l2cat);
        $("#categoryl2").change();
        $('#categoryl2').trigger("chosen:updated");

        $("#categories").val(categoryid);
        $('#categories').trigger("chosen:updated");
    },
    getduplicatesku: function(url,token){
        jQuery.ajax({
            url: url,
            type:"post",
            data: {
                "_token": token,
                "vendor": jQuery("#vendor").val(),
                "sku": jQuery("#sku").val(),
            },
            success: function(data) {
                if(data == "this sku already exist")
                {
                    $(".flash-message").html("<div class='col-md-12'><p class='alert alert-danger'>"+data+"<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a></p></div>");
                }
                else
                {
                    $("#product_data").submit();
                }


                $(".bgcolr-orange").val('Submit');
                $(".bgcolr-orange").removeAttr('disabled');
            },
            error: function(data){
                $(".bgcolr-orange").val('Submit');
                $(".bgcolr-orange").removeAttr('disabled');
            }
        });
    },
    laradrop: function(url){
        jQuery('.laradrop').laradrop({
            fileSrc:url+"/product/imagesave",
            fileDeleteHandler: url+"/product/imagedestroy",
            containersUrl: url+"/products/containers",
            fileHandler: url+"/product/store",
        });
    },
    laradropupdate: function(url,productid){
        jQuery('.laradrop').laradrop({
            containersUrl: url+"/products/containers",
            fileHandler:url+"/product/updatestore/"+productid,
            fileSrc:url+"/product/imageupdate/"+productid,
            fileDeleteHandler: url+"/product/updateimagedestroy"
        });
    },
    universal_sku: function(url){
        jQuery("#universal_sku").autocomplete({
            source: function(request, response) {
                jQuery.ajax({
                    url: url,
                    dataType: "json",
                    data: {
                        term : request.term
                    },
                    success: function(data) {
                        response(data);

                    }
                });
            },
            min_length: 3,

        });
    },
    productcreateinit: function (options) {
        jQuery(document).ready(function() {
            product.productvalidate();
            product.categoryl1change();
            jQuery('#categoryl2').on('change',function(){
                product.updatecatdropdownl3();
            });
            jQuery('.optionalattr').on('change',function(){
                product.fillconfigurableopt(jQuery(this), options.configurableopturl,options.token);
            });

            product.getalll3categories(options.getalll3categoriesurl,options.token,options.vendor);

            jQuery('#categories').on('change',function() {
                product.getattributes(options.attributeListByCategoryurl,options.token, options.attributeListByattributeseturl,  options.sampleCSVDownloadurl);
                var url = options.baseurl+'/product/vendorbycategoryid';
                product.VendorCategorywise(jQuery('#categories').val(),url,options.token);
            });

            product.universal_sku(options.searchajax);
            product.laradrop(options.baseurl);
            $("#submit-product").click(function(){
                $('.editor').each(function () {
                    var $textarea = $(this);
                    $textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
                });

                if($("#product_data").valid() == true)
                {
                    $(".bgcolr-orange").val('Please Wait')
                    $(".bgcolr-orange").attr("disabled", "disabled");
                    product.getduplicatesku(options.duplicatesku,options.token);
                    return false;
                }
                else{
                    return false;
                }


            })
            $(".optionalattr").find("option").remove();
            $(".optionalattr").append("<option value=''>Select Attribute</option>");

            product.productvalidate();
        });
        product.addoptionattribute();
        product.removeoptionattribute();
        product.numericOnlyField();
        product.desc_config();
    },
    validationrule: function(FirstAttrId,secondAttrId, validate){
        productvalidrule.push({
            FirstAttrId : FirstAttrId,
            secondAttrId : secondAttrId,
            operation: validate
        });
    },
    productupdateinit: function (options) {
        jQuery(document).ready(function() {
            product.addckeditor();
             product.productvalidate();
             product.categoryl1changeupdate();
             jQuery('#categoryl2').on('change',function(){
                 product.updatecatdropdownl3();
             });
             jQuery('.optionalattr').on('change',function(){
                 product.fillconfigurableopt(jQuery(this), options.configurableopturl,options.token);
             });
            //
             product.getalll3categoriesupdate(options.getalll3categoriesurl,options.token,options.vendor);
            //
             jQuery('#categories').on('change',function() {
                 product.getattributes(options.attributeListByCategoryurl,options.token, options.attributeListByattributeseturl,  options.sampleCSVDownloadurl);
             });
            //
            // product.universal_sku(options.searchajax);
            product.laradropupdate(options.baseurl, options.productid);

            $("#submit-product").click(function(){
                $('.editor').each(function () {
                    var $textarea = $(this);
                    $textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
                });
                if($("#product_data").valid() == true)
                {
                    return true;
                }
                else{
                    return false;
                }


            })
            // $(".optionalattr").find("option").remove();
            // $(".optionalattr").append("<option value=''>Select Attribute</option>");
            //
            // product.productvalidate();
        });

        product.addoptionattribute();
        product.removeoptionattribute();
        product.numericOnlyField();
        product.desc_config();
        $('#categoryl1').prop('disabled', true).trigger("chosen:updated");
        $('#categoryl2').prop('disabled', true).trigger("chosen:updated");
        $('#categories').prop('disabled', true).trigger("chosen:updated");
        $('#vendor').prop('disabled', true).trigger("chosen:updated");

    },
    VendorCategorywise : function(val, url,token){
        jQuery.ajax({
            url: url,
            type:"post",
            dataType: "json",
            data: {
                "_token": token,
                "cat_id": val,
            },
            success: function(data) {
                $("#vendor").find("option").remove();
                $("#vendor").append('<option value="">Select option</option>');
                for(var a=0; a<data.length; a++)
                {
                    $("#vendor").append('<option value="'+data[a].id+'">'+data[a].vendor_name +'</option>');
                }
                $('#vendor').trigger("chosen:updated");
            }
        });

    },
    displayChildHideAndShowBtn: function(parentDiv,childRegion,addbtnClass,removeBtnClass){

        var totalChildNumber = jQuery("#"+parentDiv).children().length;
        var loop = 1;
        jQuery("#"+parentDiv).find("."+childRegion).each(function(){
            //console.log(loop);
            //console.log(totalChildNumber);
            //IF ONLY ONE ELEMENT
            if(totalChildNumber==1){
                jQuery("#"+parentDiv).find("div.box-tools" ).show();
                jQuery("#"+parentDiv).find('.'+addbtnClass).show();
                jQuery("#"+parentDiv).find('.'+removeBtnClass).hide();
            }else if(loop == totalChildNumber){
                jQuery("#"+parentDiv).find("div.box-tools" ).show();
                //DISPLAY REMOVE AND ADD ON LAST CHILD
                jQuery("#"+parentDiv).find('.'+addbtnClass).show();
                jQuery("#"+parentDiv).find('.'+removeBtnClass).show();
            }else{
                //console.log('mak');
                jQuery("#"+parentDiv).find("div.box-tools" ).hide();
            }

            loop++;
        });
    }
}
