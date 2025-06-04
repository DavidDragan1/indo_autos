<div class="serach-advert" style="text-align:center;width:100%;margin-top:25px">
    <a target="_blank" href="http://eventpiazza.com">
        <img src="assets/theme/images/searchadvert.jpg" />
    </a>
</div>
<!-- search-result-area start  -->
<div class="search-result-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="search-result-header">
                    <h2><span>Showing</span> <span id="result_count"><?php echo GlobalHelper::postByTypeId( $this->uri->segment(1) ); ?></span> result(s)</h2>
                    <select name="order_by" id="order_by" onChange="shortBy(this.value);">
                        <?php
                        $page =  $this->uri->segment(1);
                        echo GlobalHelper::getShortBy( $this->input->get('short'), $page ); ?>
                    </select>
                </div>
            </div>
            <div id="sql_string"></div>
            <div class="col-lg-3 col-12">
                <h3 class="subtitle toggle-filtar"><img src="assets/theme/new/images/icons/bar.png" alt="image"> Filter Result</h3>
                <form name="filter" id="search_form" method="post">
                    <?php  require_once( 'search-form.php' ); ?>
                </form>

            </div>

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
</div>
<!-- search-result-area end  -->

<!-- Modal -->
<div id="manageReport"></div>
<div id="getQuote"></div>

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
$pages 			= ['search','auction-cars', 'import-car', 'motorbike',  'vans'];
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
                //  $('.grayscale').watermark({
                //     path: 'assets/theme/new/images/watermarke/whitetext-logo.svg',
                //     gravity: 'c',
                //     opacity: .7,
                //     margin: 12
                // });
                 
                 jQuery('#posts_list').css( 'opacity', '1' );                 
                 window.history.pushState("object or string", "Title", string );
            }
        });
    }
   
   
     
    // Manage Report          
    function manage_report(post_id, slug ) {
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

 
    // jQuery('.toggle-filtar').on("click", function () {
    //     jQuery('.rearch-result-sidebar .accordion').slideToggle();
    // });
</script>


<script>
        // Get  Quote          
    function get_quote(post_id, seller_id, post_slug ) {
        jQuery('#getQuote').load('posts/Posts_frontview/getQuote/?post_id=' + post_id  + '&seller_id='+ seller_id +'&slug='+post_slug );        
    }
  

</script>
