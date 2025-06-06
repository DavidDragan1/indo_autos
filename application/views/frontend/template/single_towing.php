<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js" type="text/javascript"></script> 
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>--> 
<!--<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/dot-luv/jquery-ui.css" />-->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />

<link rel="stylesheet" href="assets_chat/css/chat.css">
<script src="assets_chat/css/date.js" type="text/javascript"></script> 

<style>
    .panel-title a {color: #ef5c26;}   
    
    .btn-100-percentage { margin-bottom: 20px; width: 100%; }
    .dia_full { background: #fff; }
    .for-chat, .for-chat .panel, .for-chat .panel .panel-heading , .panel-primary.for-chat > .panel-heading{
        border: none !important;
        text-align: center; border-radius: 4px;
    }
    .for-chat h4 a {color: #333;}  
    .for-chat h4 i {color: #eee;}  
    .for-chat h4 { margin: 0; }
    @media only screen and (max-width: 767px) {
        .col-md-9.listingleft {
            float:none !important;
        }
    }
    @media(max-width: 600px ){
        .bottom_wrapper.frontend_chatForm .message_input_wrapper {  width: calc(100% - 131px);}
        .frontend_chat_left { width: 100% !important; float: none !important;}
        .frontend_chat_right { display: none !important;}
    }
</style>


<div class="white">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="search-box singlelistingbox">
          <div class="col-md-12 search-box-content">
            <div class="col-md-9 search-box-content-left">
                <h2 style="padding-left: 0"><?php echo ($title); ?></h2>
                <p style=" color:#ef5c26;">#ID-<?php echo sprintf('%05d', $id); ?> <span style="color: #b6b6b6;">(<?php echo  GlobalHelper::getVehicleByPostId($id) ; ?>)</span></p>
                <p><?php echo getShortContent($description, 80); ?></p>
                <p class="seach-box-location"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $location; ?></p>
            </div>
            <div class="col-md-3 search-box-content-right text-right">
              <p>Price</p>
              <p class="listing-prices"> <?php echo GlobalHelper::getPrice($priceinnaira, $priceindollar, $pricein) ?></p>
              <p> <?php echo GlobalHelper::getSellerTags($user_id); ?></p>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-12"> 
           
          
          <div class="row clearfix singlegallery"> <?php echo Modules::run('posts/posts_frontview/getSlider', $id, 875); ?> </div>
          
          <!--single html Start-->
          <div class="row singlecardetails">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Details</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 single-post-content-wrapper nopadding">
                    
                    
                    <div class="descripfull">
                      <h1>Description</h1>
                      <hr class="single">
                      <div class="post-info-box"><?php echo $description; ?></div>
                    </div>
                      
                   
                    <div class="descripfull regiinfo">
                      <h1>Towing Info</h1>
                      <hr class="single">
                      <div class="col-md-6 nopadding">
                        
                        
                        <div class="border-new">
                          <div class="col-md-4 nopadding">
                            <p><strong>Brand Name</strong></p>
                          </div>
                          <div class="col-md-1"><span class="dividersepareted">:</span></div>
                          <div class="col-md-7">
                            <p><?php getVhecileDetails( $brand_id ); ?></p>
                               
                          </div>
                          <div class="clearfix"></div>
                        </div>
                          
                          <div class="border-new">
                              <div class="col-md-4 mobilepadding">
                                  <p><strong>Vehicle</strong></p>
                              </div>
                              <div class="col-md-1"><span class="dividersepareted">:</span></div>
                              <div class="col-md-7">
                                  <p><?php echo $vehicle_type_name; ?></p>                              
                              </div>
                              <div class="clearfix"></div>
                          </div> 
                          <div class="border-new">
                              <div class="col-md-4 mobilepadding">
                                  <p><strong>Service</strong></p>
                              </div>
                              <div class="col-md-1"><span class="dividersepareted">:</span></div>
                              <div class="col-md-7">
                                  <p><?php echo $towing_service_name; ?></p>                              
                              </div>
                              <div class="clearfix"></div>
                          </div>
                          
                         
                        
                      </div>
                      <div class="col-md-6 nopadding">
                       
                           <div class="border-new">
                              <div class="col-md-4 mobilepadding">
                                  <p><strong>Type Of Service</strong></p>
                              </div>
                              <div class="col-md-1"><span class="dividersepareted">:</span></div>
                              <div class="col-md-7">
                                  <p><?php echo $towing_type_of_service_name; ?></p>                              
                              </div>
                              <div class="clearfix"></div>
                          </div>
                          
                          
                          <div class="border-new">
                              <div class="col-md-4 mobilepadding">
                                  <p><strong>Condition</strong></p>
                              </div>
                              <div class="col-md-1"><span class="dividersepareted">:</span></div>
                              <div class="col-md-7">
                                  <p><?php echo $condition; ?></p>                              
                              </div>
                              <div class="clearfix"></div>
                          </div>
                          
                          
                           <div class="border-new">
                              <div class="col-md-4 mobilepadding">
                                  <p><strong>Availability</strong></p>
                              </div>
                              <div class="col-md-1"><span class="dividersepareted">:</span></div>
                              <div class="col-md-7">
                                  <p><?php echo $availability; ?></p>                              
                              </div>
                              <div class="clearfix"></div>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    
                    
                    
                  
                      
                      
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <div class="col-md-3 single-postsidebar">
        <div class="contactseller"> 
            <a href="#" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#contact_seller" data-backdrop="static"> <i class="fa fa-star"></i> Contact Seller </a> 
            <a  class="btn btn-default navbar-btn offermake" onclick="get_quote(<?php echo $id . ',' . $user_id . ',\'' . $post_slug; ?>')"><i class="fa fa-gift"></i> Make an Offer</a> 
        </div>
        <div class="panel panel-default">
           <?php  echo GlobalHelper::getSellerInfo($user_id); ?>
        </div>
          
         
                <div class="panel panel-primary for-chat">
                    <div class="panel-heading panel-heading-business-page">
                        <h4>
                        <a data-name='C' class="chatButton <?php echo $current_status;  ?>" data-label="live chat" src="<?php echo base_url( '/chat-form?vendor='.$user_id.'&token='.rand(1000, 9999) ) ?>">Chat <i class="fa fa-comments" aria-hidden="true"></i>  <small>(<?php echo $last_status; ?>)</small></a>
                        </h4>
                    </div>
                    
                </div>
         
          
          
          
                <div id="dialog"  style="padding-right: 0px; padding-left: 0px;">
    <img id="loader" style="width:100%; max-width: 496px; overflow: hidden;" src="<?php echo  base_url('assets_chat/'); ?>loader.gif">
    <iframe style="display:none; width:100%; height: 100%; overflow: hidden;" id='MainPopupIframe' src='' frameBorder='0' scrolling="no" height="0"/></iframe>    
    </div>
      
                
                
    
    
<style>
    @media( min-width: 992px ) {
         h3.panel-title { font-size: 15px;}
    }
   
</style>
    
          
          
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-bullhorn"></i> 
               Towing From This Dealer
            </h3>
          </div>
          <div class="panel-body">
            <div class="ldetailsright-box"> <?php echo Modules::run('post/posts_frontview/getFromThisSeller', $user_id); ?> </div>
          </div>
        </div>
        <!-- <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-map-marker"></i> Location Map</h3>
          </div>
          <div class="panel-body">
            <div class="ldetailsright-box"> <?php echo initGoogleMap($lat, $lng, 'Location of the Product'); ?> </div>
          </div>
        </div> -->
        

<?php echo Modules::run('posts/posts_frontview/sidebar_text' ); ?>


        <!--end cars from this dealer--> 
        
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="modal fade" id="getQuote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
    <div id="contact_seller" class="modal fade" role="dialog" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Contact Seller</h4>
          </div>
          <div class="modal-body">
            <div class="clearfix"></div>
            <form role="form" id="ContactSellerForm">
              <input type="hidden" name="seller_id" value="<?php echo $user_id; ?>"/>
              <input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
              <input type="hidden" name="listing_url" value="<?php echo $post_slug; ?>"/>
              <div class="col-lg-12">
                  
                  <div class="row contact-area">
                      <div class="col-md-4">
                          <a href="tel:<?php echo $contact_no; ?>" class="btn btn-success  btn-100-percentage"> <i class="fa fa-phone-square"></i> Phone</a>                          
                      </div>
                      <div class="col-md-4">
                          
                          <a href="whatsapp://send?text=<?php echo $title; ?>" data-action="share/whatsapp/share" class="btn btn-primary  btn-100-percentage"> <i class="fa fa-whatsapp"></i> Whatsapp</a>                          
                      </div>
                      <div class="col-md-4">
                          <a data-name='C' class="btn btn-info pop-chat chatButton btn-100-percentage <?php echo $current_status;  ?>" data-label="live chat" src="<?php echo base_url( '/chat-form?vendor='.$user_id.'&token='.rand(1000, 9999) ) ?>">Chat <i class="fa fa-comments" aria-hidden="true"></i>  <small>(<?php echo $last_status; ?>)</small></a>
                                                  
                      </div>
                  </div>
                  
                <div id="ajax_respond2"></div>
                <div class="form-group">
                  <div class="input-group"> <span class="input-group-addon">Your Name:<sup>*</sup></span>
                    <input type="text" name="senderName" class="form-control" value="<?php echo getLoginUserData('name'); ?>" />
                  </div>
                  <div id="name_msg" class="text-warning" style="display: none;"></div>
                </div>
                <div class="form-group">
                  <div class="input-group"> <span class="input-group-addon">Your Email:<sup>*</sup></span>
                    <input type="text" class="form-control"  id="InputEmail" name="email" placeholder="Enter Email" value="<?php echo getLoginUserData('user_mail'); ?>" required="">
                  </div>
                  <div id="name_msg" class="text-warning" style="display: none;"></div>
                </div>
                <div class="form-group">
                  <div class="input-group"> <span class="input-group-addon">Your Phone:<sup>*</sup></span>
                      <input type="text" class="form-control"  id="InputPhone" name="phone" placeholder="Enter Phone" value="<?php echo getUserDataByUserId(getLoginUserData('user_id'), 'contact'); ?>" required="">
                  </div>
                  <div id="phone_msg" class="text-warning" style="display: none;"></div>
                </div>
                <div class="form-group">
                  <label for="InputMessage">Message <sup>*</sup></label>
                  <textarea name="message" id="InputMessage" class="form-control" rows="5" required="">I saw this ads for sale at <?php echo base_url('post/'.$post_slug); ?>. I have an offer for the deal and want to discuss with you further. Would you please contact me as soon as possible?</textarea>
                  <div id="message_msg" class="text-warning" style="display: none;"></div>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                <button type="submit" class="btn btn-primary" id="sendToSeller"><i class="fa fa-send-o"></i> Send </button>
              </div>
            </form>
            <div class="clearfix"></div>
          </div>
          <div class="blanknoticeseller"></div>
        </div>
      </div>
    </div>
  </div>

        <?php echo Modules::run('posts/posts_frontview/getRelatedPost', $model_id, $id ); ?>
       
    
    
</div>  
 <script>
var $ = jQuery;
    if ($(window).width() > 768) {
    $("#dialog").dialog({
    width: 943,
            height: 683,
            autoOpen: false
    });
    } else {
    $("#dialog").dialog({
    width: 320,
            height: $(window).height() - 100,
            autoOpen: false
    });
    }

    $("#dialog").resizable();
    $(".chatButton").click(function() {
    $("#loader").show();
    var url = $(this).attr('src');
    $("#dialog").dialog("open");
    $('#MainPopupIframe').attr('src', url);
    $('#MainPopupIframe').on('load', function(){
    $("#loader").hide();
    $('#MainPopupIframe').show();
    });
    });
    $('.ui-dialog-titlebar-close').click(function(){
    $('#MainPopupIframe').attr('src', 'blank.php');
    $('#MainPopupIframe').hide();
    });
    var topBar = '<div class="dia_full">\n\
<div class="diaLeftSide"></div> <div class="diaRightSide"><a  class="minimize" role="button"><img src="<?php echo base_url('assets_chat/'); ?>minimize.png" /></a><a href="<?php echo base_url(uri_string()); ?>" class="ui-dialog-titlebar-close ui-corner-all" role="button"><img src="<?php echo base_url('assets_chat/'); ?>close_btn.png" /></a></div></div>';
    $(".ui-dialog-titlebar").html(topBar);

    $('.minimize').on('click', function(){
        $('.ui-draggable.ui-resizable').css('display', 'none');
        $('.minmize_bar').show();
    });

$('.pop-chat').click(function(){
    $('#contact_seller').modal('hide');
});

</script>
             


    <?php $this->load->view('frontend/script_js'); ?>
<script>   
    
   jQuery(document).ready(function() { 
    /*Contact Seller*/
    jQuery("#sendToSeller").click(function(event) { 
        event.preventDefault();
        var formData = jQuery('#ContactSellerForm').serialize();

        var senderNamex = jQuery('[name=senderName]').val();
        var emailx      = jQuery('[name=email]').val();
        var phonex      = jQuery('[name=phone]').val();
        var messagex    = jQuery('[name=message]').val();
        var error       = 0;
        
        if(validateEmail( emailx ) === false || !emailx){
            jQuery('#email_msg').html('Invalid Email.').show();
            jQuery('#InputEmail').addClass('required');
            error = 1;
        }else{
            jQuery('#email_msg').hide();
            jQuery('#InputEmail').removeClass('required');
        }
        if( !messagex){
            jQuery('#message_msg').html('Please enter your message.').show();
            jQuery('#InputMessage').addClass('required');
            error = 1;
        }else{
            jQuery('#message_msg').hide();
            jQuery('#InputMessage').removeClass('required');
        }
        if( !senderNamex){
            jQuery('#name_msg').html('Pleae enter your name').show();
            jQuery('#senderName').addClass('required');
            error = 1;
        }else{
            jQuery('#name_msg').hide();
            jQuery('#senderName').removeClass('required');
        }
        if( !phonex){
            jQuery('#phone_msg').html('Pleae enter your Phone Number').show();
            jQuery('#InputPhone').addClass('required');
            error = 1;
        }else{
            jQuery('#phone_msg').hide();
            jQuery('#InputPhone').removeClass('required');
        }
        if ( !error ) {
            jQuery.ajax({
                type: "POST",
                //url: "contact_seller",
                url: "mail/contact_seller",
                dataType: 'json',
                data: formData,
                beforeSend: function (){
                    jQuery('#ajax_respond2')
                            .html('<p class="ajax_processing"> Sending...</p>')
                            .css('display','block');
                },                
                success: function(jsonData) {                    
                    jQuery('#ajax_respond2').html(jsonData.Msg);                    
                    if(jsonData.Status === 'OK'){                        
                        document.getElementById("ContactSellerForm").reset();
                        setTimeout(function() {	jQuery('#ajax_respond2').slideUp();  }, 2500);
                        setTimeout(function() { jQuery('#contact_seller').modal('toggle'); }, 3000);
                    }
                }               
            });
        }
        return false;
    });
    /*End Contact Seller*/
    });
    
     function submit_getQuote( ) {       
       
        var formData = jQuery('#get_quote').serialize();
        var error = 0;  
   
        
        var offer_message = jQuery('[name=offer_message]').val();
	if(!offer_message){
            jQuery('[name=offer_message]').addClass('required');
            error = 1;
	} else{
            jQuery('[name=offer_message]').removeClass('required');
	}
   
        if(!error){
            jQuery.ajax({
                url: 'mail/send_offer',
                type: "POST",
                dataType: "json",
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond').html('<p class="ajax_processing">Loading...</p>');                                               
                },
                success: function ( jsonRepond ) {

                    if( jsonRepond.Status === 'OK'){
                        jQuery('#ajax_respond').html( jsonRepond.Msg ); 
                        setTimeout(function(){                             
                            jQuery('#manageReport').modal('hide');
                            jQuery('#ajax_respond').html( '' );
                            jQuery('#getQuote').modal('toggle');
                        }, 2000); 
                    } else {
                        jQuery('.report_respond').html( jsonRepond.Msg );                     
                    }                                                
                }
            });
        }
       
    }
    
    
        // Get  Quote          
    function get_quote(post_id, seller_id, post_slug ) {   
       jQuery('#getQuote').modal({
            show: 'false'
        });
        jQuery('#getQuote').load('posts/Posts_frontview/getQuote/?post_id=' + post_id  + '&seller_id='+ seller_id +'&slug='+post_slug );        
    }
    
</script>



<div class="minmize_bar" style="display: none;">
    <div class="minmize_inner">
        Maximize chat
    </div>
</div>


<script>
 jQuery('.minmize_inner').on('click', function(){
    jQuery('.ui-draggable.ui-resizable').css('display', 'block');
    jQuery('.minmize_bar').hide();
});
</script>

