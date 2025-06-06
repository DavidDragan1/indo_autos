<div class="serach-advert" style="text-align:center;width:100%;margin-top:25px"><a target="_blank" href="http://eventpiazza.com"><img src="assets/theme/images/searchadvert.jpg" /></a></div>
<div class="search-result-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="search-result-header">
                    <h2><span>Showing </span><span id="result_count"><?php echo GlobalHelper::postByTypeId( $this->uri->segment(1) ); ?></span> result(s)</h2>
                    <select name="order_by" id="order_by" onChange="shortBy(this.value);">
                        <?php
                        $page =  $this->uri->segment(1);
                        echo GlobalHelper::getShortBy( $this->input->get('short'), $page );
                        ?>
                    </select>
                </div>
            </div>
<!--            <div class="col-12">-->
<!--                <div class="row">-->
<!--                    <div class="col-12">-->
<!--                        <h3 class="subtitle"><img src="assets/images/icons/bar.png" alt="image"> Filter Result</h3>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="col-lg-3 col-12">
                <form name="filter" id="search_form" method="post">
                    <?php  require_once( 'search-form.php' ); ?>
                </form>
            </div>
            <div id="sql_string"></div>
            <div class="col-lg-9 col-12" >
            <h1 class="seo-title"><?php $c_page = $this->uri->segment(1); ?>
                    <?php
                    if( $c_page == 'spare-parts' ){
                        $temp =  create_search_parts($c_page);
                        echo $temp;
                        $meta_description = $temp;
                    } else if( $c_page == 'automech-search' ){
                        $temp =create_search_auto($c_page);
                        echo $temp;
                        $meta_description = $temp;
                    } else if( $c_page == 'search' || $c_page == 'motorbike'){
                        $temp =create_search_tags($c_page);
                        echo $temp;
                        $meta_description = $temp;
                    } else if( $c_page == 'towing-search'){
                        $temp =create_search_towing($c_page);
                        echo $temp;
                        $meta_description = $temp;
                    } else {
                        echo isset($meta_title) ? $meta_title : 'Auction Cars Online | Vehicle Auction';
                    }
                    ?></h1>
                <div id="posts_list">
                    <?php
                    $post_slug = $this->uri->segment(1);
                    echo Modules::run('posts/posts_frontview/getPosts', $post_slug );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="manageReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<div class="modal fade" id="getQuote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

<?php $this->load->view('frontend/script_js'); ?>


<script>
    
    
    
    
    var $ = jQuery;
if ($(window).width() < 768) { 
    $('.searchbar-title').click(function(){
        $('#filter-result').slideToggle('slow');
    });
    
}


<?php 

// $pages 			= ['search','auction-cars', 'import-car', 'motorbike', 'spare-parts', 'vans'];
$pages 			= ['search','auction-cars', 'import-car', 'motorbike', 'spare-parts', 'vans'];
$current_page 	= $this->uri->segment(1);

if(in_array( $current_page, $pages )){ ?>

jQuery(document).ready( function(){     
     <?php     
        $array  = $_GET;
        $url    = $this->uri->segment(1) . '?';
        unset($array['page']);
        $array['post_slug'] = $url;
        unset($array['_']);
        if($array){
           $url .= \http_build_query($array);
        }
        $url    .= '&page=' . $this->input->get('page');               
     ?>
     var string = '<?php echo $url; ?>';
     getResult( string, false );
});
<?php } ?>    
       

    function shortBy( string  ){
       
        jQuery.ajax({
            url: 'posts/posts_frontview/getPosts/' + string,            
            type: "GET",
            dataType: "json", //need check with multi part for image upload
            cache: false,
            beforeSend: function( ){
               
                 jQuery('#posts_list').css( 'opacity', '0.5' );
                 jQuery('#loader').css( 'display', 'block' );
                  
                 jQuery('#posts_list').css( 'opacity', '0.5' );
                 jQuery('#result_count').html( '0' );
            },
            success: function(jsonRespond){
                 jQuery('#posts_list').html( jsonRespond.result );

                 jQuery('#sql_string').html( jsonRespond.sql );
                 jQuery('#result_count').html( jsonRespond.count );
                 jQuery('#loader').css( 'display', 'none' );
               
                 
                 
                 jQuery('#posts_list').css( 'opacity', '1' );                 
                 window.history.pushState("object or string", "Title", string );
            }
        });
    }
           
    // Manage Report          
    function manage_report(post_id, slug ) {   
       jQuery('#manageReport').modal({
            show: 'false'
        });
        jQuery('#manageReport').load('posts/Posts_frontview/report_spam/?post_id=' + post_id + '&slug='+slug );        
    }
    

        
    function submit_report( ) {       
       
        var formData = jQuery('#report_spam').serialize();
        var error = 0;  
   
        var your_mail = jQuery('[name=your_mail]').val();
	if(!your_mail){
            jQuery('[name=your_mail]').addClass('required');
            error = 1;
	} else{
            jQuery('[name=your_mail]').removeClass('required');
	}
        
   
        if(!error){
            jQuery.ajax({
                url: 'mail/report_spam',
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
                        }, 2000); 
                    } else {
                        jQuery('#ajax_respond').html( jsonRepond.Msg );                     
                    }                                                
                }
            });
        }
       
    }

    // Get Quote
    // Make an Office 
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
                        }, 2000); 
                    } else {
                        jQuery('.report_respond').html( jsonRepond.Msg );                     
                    }                                                
                }
            });
        }
       
    }
    function getResult( string, loader ){
        
        if(!loader ){
            loader = true;
        } else {
            loader;
        }
        
        // alert( string );
        jQuery.ajax({
            url: 'posts/posts_frontview/getPosts/' + string,            
            type: "GET",
            dataType: "json", //need check with multi part for image upload
            cache: false,
            beforeSend: function(){
                 jQuery('#posts_list').css( 'opacity', '0.5' );
                 
                
                 
                 if(loader == true ){
                     jQuery('#loader').css( 'display', 'block' );
                 }
                 
                 jQuery('#posts_list').css( 'opacity', '0.5' );
                 jQuery('#result_count').html( '0' );
            },
            success: function(jsonRespond){
                 jQuery('#posts_list').html( jsonRespond.result );

                 jQuery('#sql_string').html( jsonRespond.sql );
                 jQuery('#result_count').html( jsonRespond.count );
                 jQuery('#order_by').html( jsonRespond.orderBy );
                 
                 if(loader == true ){
                    jQuery('#loader').css( 'display', 'none' );
                 }
                 
                 
                 jQuery('#posts_list').css( 'opacity', '1' );
                 
                 window.history.pushState("object or string", "Title", string );
            }
        });
        
    }

    function getBrand(type_id) {
        $.ajax({
            url: 'brands/brands_frontview/get_brands_by_vechile/?type_id=' + type_id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                $('#home_brand_id').html('<option value="0">Loading..</option>');
            },
            success: function (response) {
                $('#home_brand_id').html(response);
            }
        });
    }

    function getModels(brand_id) {
        var type_id = $('#home_type_id').val();
        $.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model/?type_id=' + type_id + '&brand_id=' + brand_id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                $('#home_model_id').html('<option value="0">Loading..</option>');
            },
            success: function (response) {
                $('#home_model_id').html(response);
            }
        });
    }
    
       jQuery("#parts_for").change(function(){ 
            var parts_for = jQuery(this).val();
            jQuery('#parts_id').load('parts/parts_frontview/get_parts_description/' + parts_for);

        });

</script>
