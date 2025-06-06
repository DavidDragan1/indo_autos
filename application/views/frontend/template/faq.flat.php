<style>
    
    .mt0{margin-top: 0px !important;} 
    .h50{ height: 50px !important;}
    .mt25{ margin-top: 25px !important;}    
</style>

<div class="containter-fulid white_bg nopadding">
    
    <div class="container minimumheight">

      <div class="page-content cartrade">
        <h1><?php  echo $cms['post_title']; ?></h1>
        <?php                 
        
        $submit_faq = $this->input->get('submit_faq');
        $q          = $this->input->get('q');
        
        if($submit_faq == 'yes'){ 
        
            $this->load->view('frontend/template/faq_submit_question');

        } else{ ?>
                <form method="get">
                    <div class="input-group">
                        <input class="form-control mt0 h50" placeholder="Search" name="q" value="<?php echo $q; ?>" type="text">
                        <div class="input-group-btn">
                            <button class="btn btn-info h50" type="submit">
                                <i class="glyphicon glyphicon-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>

                <div class="panel-group mt25" id="accordion">
                    <?php echo Modules::run('frontend/getFAQs', $q);?>
                </div>         
                <a href="<?php echo site_url("mechanic") ?>" class="btn btn-primary pull-right" id="wire-question">Chat with Expert</a>
        <?php } ?>
        
      </div>
    </div>        
</div>

<script>

setTimeout(function(){
    $('.autohide').slideUp();
}, 5000);


function view_full_text(id){	
    $('#less'+id).toggle();
    $('#more'+id).toggle();
     
}


</script>
