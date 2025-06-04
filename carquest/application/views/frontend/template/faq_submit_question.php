<style type="text/css"> 
    label.control-label{ padding-top:13px;}
    p.ajax_error{
        font-size: 10pt;
        line-height: 1.3;
        font-weight: normal;
        font-family: arial;
        color: red;                    
    }
</style>    
<form id="submit_faq" method="post" onsubmit="return submitFaq(event);">

    <div class="row">

        <div class="col-md-12">
            <h4>Submit Your Question</h4>


            <div class="form-group">                                                                                                                                                            
                <label class="col-md-2 control-label" for="qustion_by_name">Full Name</label>
                <div class="col-md-10">
                    <input name="qustion_by_name" type="text" class="form-control" id="qustion_by_name" value="<?php echo set_value('qustion_by_name'); ?>" placeholder="Full Name">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label" for="question_by_email">Email<sup>*</sup></label>
                <div class="col-md-10">
                    <input name="question_by_email" type="email" class="form-control" id="question_by_email " value="<?php echo set_value('question_by_email'); ?>" placeholder="Email">
                    <?php echo form_error('question_by_email') ?>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-2 control-label" for="title">Question<sup>*</sup></label>
                <div class="col-md-10">
                    <input name="title" type="text" class="form-control" id="title" value="<?php echo set_value('title'); ?>" placeholder="Enter Your Question">
                    <?php echo form_error('title') ?>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-2 control-label" for="content">Description</label>
                <div class="col-md-10">
                    <textarea name="content" class="form-control" id="content" cols="5" rows="5" placeholder="Question Description"><?php echo set_value('content'); ?></textarea>
                </div>
            </div>                                                                                                                                          
        </div>

        <div class="col-md-12"  style="padding-top:15px; padding-bottom: 25px;">

            <div class="col-md-10 col-md-offset-2"> <div id="ajax_respond"></div></div>

            <div class="col-md-12 text-right">                    
                <a href="<?php echo site_url('faq'); ?>" class="btn btn-default">
                    <i class="fa fa-long-arrow-left"></i> Cancel & Back to List
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-location-arrow"></i> Submit
                </button>
            </div>
        </div>

    </div>                        
</form> 



<script>    
    function submitFaq(e){    
        e.preventDefault();
        var submitFAQ = $('#submit_faq').serialize();
        var error = 0;                
        var fname = $('[name=question_by_email]').val();
	if(!fname){
            $('[name=question_by_email]').addClass('required');
            error = 1;
	}else{
            $('[name=question_by_email]').removeClass('required');
	}
        
        var title = $('[name=title]').val();
	if(!title){
            $('[name=title]').addClass('required');
            error = 1;
	}else{
            $('[name=title]').removeClass('required');
	}
                                        
        if(!error){        
            $.ajax({
                url: 'submit_faq',
                type: "POST",
                dataType: "JSON", // need check with multi part for image upload
                data: submitFAQ,
                beforeSend: function(){
                    $('#ajax_respond')
                            .html( '<p class="ajax_processing">Loading... </p>')
                            .css('display','block');	
                },
                success: function(respnod){
                    $('#ajax_respond').html( respnod.Msg);
                    if(respnod.Status === 'OK'){
                        document.getElementById("submit_faq").reset();
                        setTimeout(function() {	$('#ajax_respond').slideUp('slow'); }, 5000);
                    }
                }
            });
        } else {
            $('#ajax_respond')
                .html( '<p class="ajax_error">Email & Question field are required.</p>')
                .css('display','block');
        }
        return false;
    }
</script>    