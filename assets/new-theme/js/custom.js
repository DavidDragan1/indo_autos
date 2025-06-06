
jQuery(document).ready(function () {

    jQuery(document).on('click', "#btn_subscribe_no", function (event) {

        event.preventDefault();
        var email = jQuery("#newsletter_email").val();
        var error = 0;
        console.log(validateEmail(email))
        if (validateEmail(email) == false || !email) {
            jQuery('#newsletter-msg').html('Invalid Email').show();
            error = 1;
        } else {
            jQuery('#newsletter-msg').hide();
        }

        if (error == 0) {
            jQuery.ajax({
                type: "POST",
                url: "newsletter_subscriber/Newsletter_subscriber_frontview/create_action_ajax",
                dataType: 'json',
                data: { email: email },
                success: function (jsonData) {
                    if (jsonData.Status === 'OK') {
                        jQuery('#msg').html(jsonData.Msg).slideDown('slow');
                        jQuery('#msg').delay(5000).slideUp('slow');
                        jQuery("#newsletter_email").val('');
                    } else {
                        jQuery('#newsletter-msg').html(jsonData.Msg).slideDown('slow');
                        jQuery('#newsletter-msg').delay(5000).slideUp('slow');
                    }
                    console.log(jsonData);
                }
            });
        }
    });

    jQuery(document).on('click', "#btn_subscribe_n", function (event) {

        event.preventDefault();
        var email = jQuery("#newsletter_email_temp").val();
        var error = 0;

        if (validateEmail(email) == false || !email) {
            jQuery('#newsletter-msg-t').html('Invalid Email').show();
            error = 1;
        } else {
            jQuery('#newsletter-msg-t').hide();
        }

        if (error == 0) {
            jQuery.ajax({
                type: "POST",
                url: "newsletter_subscriber/Newsletter_subscriber_frontview/create_action_ajax",
                dataType: 'json',
                data: { email: email },
                success: function (jsonData) {
                    if (jsonData.Status === 'OK') {
                        jQuery('#msg-t').html(jsonData.Msg).slideDown('slow');
                        jQuery('#msg-t').delay(5000).slideUp('slow');
                        jQuery("#newsletter_email_temp").val('');
                    } else {
                        jQuery('#newsletter-msg-t').html(jsonData.Msg).slideDown('slow');
                        jQuery('#newsletter-msg-t').delay(5000).slideUp('slow');
                    }
                }
            });
        }
    });



    jQuery("#SendNow").click(function (event) {
        event.preventDefault();

        var formData = jQuery('#sendMail').serialize();

        var name = jQuery("#SendMail_name").val();
        var email = jQuery("#SendMail_email").val();
        var message = jQuery("#SendMail_comments").val();

        var error = 0;

        if (validateEmail(email) == false || !email) {
            jQuery('#SendMail_mail_msg').html('Invalid Email').show();
            error = 1;
        } else {
            jQuery('#SendMail_mail_msg').hide();
        }
        if (!name) {
            jQuery('#SendMail_name_msg').html('Name is required').show();
            error = 1;
        } else {
            jQuery('#SendMail_name_msg').hide();
        }
        if (!message) {
            jQuery('#SendMail_comments_msg').html('Message is required').show();
            error = 1;
        } else {
            jQuery('#SendMail_comments_msg').hide();
        }
        if (error == 0) {
            jQuery.ajax({
                type: "POST",
                url: "mail/send_a_message",
                dataType: 'json',
                data: formData,

                beforeSend: function () {
                    jQuery('#ajax_respond').html('<p class="ajax_processing">Sending...</p>');
                },
                success: function (jsonData) {
                    if (jsonData.Status === 'OK') {
                        document.getElementById("sendMail").reset();
                        setTimeout(function () { $('#ajax_respond').slideUp('slow') }, 2000);
                    }
                    jQuery('#ajax_respond').html(jsonData.Msg);
                }
            });
        }
    });


    /*ION Slider*/

    //jQuery(".select2").select2();
    //jQuery("#compose-textarea").wysihtml5();



    /*on change effect*/
    jQuery("#location").change(function () {
        var address = jQuery(this).val();
        if (address.length >= 3) {
            afunction();
        }
    });

    /*on change effect*/
    jQuery("#global_search").change(function () {
        var address = jQuery(this).val();
        if (address.length >= 3) {
            afunction();
        }
    });

    jQuery("#global_search").on('keypress',function(e) {
        if(e.which == 13) {
            change_url_without_page_reload();
            var address = jQuery(this).val();
            if (address.length >= 3) {
                afunction();
            }
        }
    });

    jQuery("#type_id").change(function () {
        var type_id = jQuery(this).val();
        jQuery('#brand_id').load('brands/brands_frontview/get_brands_by_vechile/?type_id=' + type_id);
        jQuery('#model_id').html('<option value="0">Please Select Brand</option>');
        setTimeout(function () { afunction(); }, 100);
    });



    jQuery("#brand_id").change(function () {
        var type_id = jQuery('#type_id').val();
        var brand_id = jQuery('#brand_id').val();

        jQuery('#model_id').load('brands/brands_frontview/brands_by_vehicle_model/?type_id=' + type_id + '&brand_id=' + brand_id);
        afunction();
    });

    jQuery("#model_id").change(function () { afunction(); });
    //getDropDownModel

    jQuery("#condition").change(function () { afunction(); });
    jQuery("#year").change(function () { afunction(); });
    jQuery("#from_year").change(function () { afunction(); });
    jQuery("#to_year").change(function () { afunction(); });

    jQuery("#from_year_h, #from_year").change(function () {
        var min_value = parseInt(jQuery(this).val()) || 0;
        var max_value = 2020;

        jQuery("#to_year_h, #to_year").empty()
            .append("<option value=0>--Any--</option>");
        while (min_value <= max_value) {
            jQuery("#to_year_h, #to_year").append('<option value="' + max_value + '">' + max_value + '</option>');
            max_value--;
        }
    });





    jQuery("#location_id").change(function () { afunction(); });
    jQuery("#body_type").change(function () { afunction(); });
    jQuery("#latitude").change(function () { afunction(); });

    jQuery("#fuel_type").change(function () { afunction(); });
    jQuery("#engine_size").change(function () { afunction(); });
    jQuery("#gear_box").change(function () { afunction(); });
    jQuery("#seats").change(function () { afunction(); });
    jQuery("#color_id").change(function () { afunction(); });
    jQuery("#parts_id").change(function () { afunction(); });
    jQuery("#s_parts_id").change(function () { afunction(); });
    jQuery("#parts_for").change(function () { afunction(); });
    jQuery("#category_id").change(function () { afunction(); });
    jQuery("#parts_description").change(function () { afunction(); });
    jQuery("#wheelbase").change(function () { afunction(); });
    jQuery("#seller").change(function () { afunction(); });

    jQuery("#specialist").change(function () { afunction(); });
    jQuery("#repair_type").change(function () { afunction(); });
    jQuery("#service").change(function () { afunction(); });


    // towing strat
    jQuery("#towing_service_id").change(function () { afunction(); });
    jQuery("#vehicle_type").change(function () { afunction(); });
    jQuery("#type_of_service").change(function () { afunction(); });
    jQuery("#availability").change(function () { afunction(); });
    // towing end

    jQuery("#age_from").change(function () {
        var fromValue = parseInt(jQuery(this).val());
        var toValue = parseInt(jQuery('#age_to').val());
        var maxValue = 10;
        var value = fromValue + 1;
        jQuery("#age_to").empty();
        if (fromValue <= toValue) {
            while (value <= maxValue) {
                jQuery("#age_to").append("<option value=" + value + ">Upto " + value + " Year(s) old</option");
                value = value + 1;
            }
            jQuery("#age_to option").each(function () {
                if (jQuery(this).val() == toValue) { // EDITED THIS LINE
                    jQuery(this).attr("selected", "selected");
                }
            });
        } else {
            while (value <= maxValue) {
                jQuery("#age_to").append("<option value=" + value + ">Upto " + value + " Year(s) old</option");
                value = value + 1;
            }
        }

        afunction();
    });

    jQuery("#age_to").change(function () {
        var toValue = parseInt(jQuery(this).val());
        var fromValue = parseInt(jQuery('#age_from').val());
        var minValue = 0;
        var value = toValue - 1;
        jQuery("#age_from").empty();
        if (toValue >= fromValue) {
            while (minValue <= value) {
                jQuery("#age_from").append("<option value=" + minValue + ">Upto " + minValue + " Year(s) old</option");
                minValue = minValue + 1;
            }
            jQuery("#age_from option").each(function () {
                if (jQuery(this).val() == fromValue) { // EDITED THIS LINE
                    jQuery(this).attr("selected", "selected");
                }
            });

        } else {
            while (minValue <= value) {
                jQuery("#age_from").append("<option value=" + minValue + ">Upto " + minValue + " Year(s) old</option");
                minValue = minValue + 1;
            }
        }
        afunction();
    });

    jQuery("#price_from").change(function () {
        var fromValue = parseInt(jQuery(this).val());
        var toValue = parseInt(jQuery('#price_to').val());
        var maxValue = 10000000;
        var value = fromValue + 10000;
        jQuery("#price_to").empty();
        if (fromValue <= toValue) {
            while (value <= maxValue) {
                jQuery("#price_to").append("<option value=" + value + ">" + value + "</option");
                value = value + 10000;
            }
            jQuery("#price_to option").each(function () {
                if (jQuery(this).val() == toValue) { // EDITED THIS LINE
                    jQuery(this).attr("selected", "selected");
                }
            });
        } else {
            while (value <= maxValue) {
                jQuery("#price_to").append("<option value=" + value + ">" + value + "</option");
                value = value + 10000;
            }
        }

        afunction();
    });

    jQuery("#price_to").change(function () {
        var toValue = parseInt(jQuery(this).val());
        var fromValue = parseInt(jQuery('#price_from').val());
        var minValue = 50000;
        var value = toValue - 10000;
        jQuery("#price_from").empty();
        if (toValue >= fromValue) {
            while (minValue <= value) {
                jQuery("#price_from").append("<option value=" + minValue + ">" + minValue + "</option");
                minValue = minValue + 10000;
            }
            jQuery("#price_from option").each(function () {
                if (jQuery(this).val() == fromValue) { // EDITED THIS LINE
                    jQuery(this).attr("selected", "selected");
                }
            });

        } else {
            while (minValue <= value) {
                jQuery("#price_from").append("<option value=" + minValue + ">" + minValue + "</option");
                minValue = minValue + 10000;
            }
        }
        afunction();
    });

    jQuery("#mileage_from").change(function () {
        var fromValue = parseInt(jQuery(this).val());
        var toValue = parseInt(jQuery('#mileage_to').val());
        var maxValue = 100000;
        var value = fromValue + 1000;
        jQuery("#mileage_to").empty();
        if (fromValue <= toValue) {
            while (value <= maxValue) {
                jQuery("#mileage_to").append("<option value=" + value + ">" + value + "</option");
                value = value + 1000;
            }
            jQuery("#mileage_to option").each(function () {
                if (jQuery(this).val() == toValue) { // EDITED THIS LINE
                    jQuery(this).attr("selected", "selected");
                }
            });
        } else {
            while (value <= maxValue) {
                jQuery("#mileage_to").append("<option value=" + value + ">" + value + "</option");
                value = value + 1000;
            }
        }

        afunction();
    });

    jQuery("#mileage_to").change(function () {
        var toValue = parseInt(jQuery(this).val());
        var fromValue = parseInt(jQuery('#mileage_from').val());
        var minValue = 1000;
        var value = toValue - 1000;
        jQuery("#mileage_from").empty();
        if (toValue >= fromValue) {
            while (minValue <= value) {
                jQuery("#mileage_from").append("<option value=" + minValue + ">" + minValue + "</option");
                minValue = minValue + 1000;
            }
            jQuery("#mileage_from option").each(function () {
                if (jQuery(this).val() == fromValue) { // EDITED THIS LINE
                    jQuery(this).attr("selected", "selected");
                }
            });

        } else {
            while (minValue <= value) {
                jQuery("#mileage_from").append("<option value=" + minValue + ">" + minValue + "</option");
                minValue = minValue + 1000;
            }
        }
        afunction();
    });

    /*end on change effect*/




    // jQuery('.carousel').carousel('pause');


});

function change_url_without_page_reload() {
    var urlPram = jQuery('#search_form').serialize();

    // hack search with dynamice .....
    // var url = document.URL;
    // var id = url.substring(url.lastIndexOf('/') + 1);

    // var page = window.location.pathname.split( '/' )[2];
    var temp = window.location.pathname.split( '/' );
    var page = temp[temp.length -1];

    console.log(page);

    if(page == 'search' || page == 'spare-parts'|| page == 'motorbike'|| page == 'towing-search'|| page == 'automech-search'){
         window.history.pushState("object or string", "Title", page +'?'+urlPram );
    }
}




function afunction() {
    var formData = jQuery('#search_form').serialize();
    jQuery.ajax({
        url: 'posts/posts_frontview/getPosts',
        type: "GET",
        dataType: "json", //need check with multi part for image upload
        data: formData,
        cache: false,
        beforeSend: function () {
            jQuery('#loader').css('display', 'block');
            jQuery('#posts_list').css('opacity', '0.5');
            jQuery('#result_count').html('0');
        },
        success: function (jsonRespond) {
            jQuery('#posts_list').html(jsonRespond.result);
            jQuery('#sql_string').html(jsonRespond.sql);
            jQuery('#result_count').html(jsonRespond.count);
            jQuery('#order_by').html(jsonRespond.orderBy);

            jQuery('#posts_list').css('opacity', '1');
            jQuery('#loader').css('display', 'none');
            change_url_without_page_reload();
        }
    });
}


function validateEmail(sEmail) {
    var filter = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}