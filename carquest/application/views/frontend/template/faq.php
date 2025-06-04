<?php
    $q = $this->input->get('q');
?>
<div class="ask-an-expart-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="top-faqs">
                    <h3>Top FAQs</h3>
                    <?php echo Modules::run('frontend/getSidebarFAQ')?>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ask-an-expart-wrap">
                    <h1>FAQ</h1>
                    <form class="search-expart" method="get">
                        <input placeholder="Search FAQ" name="q" value="<?php echo $q; ?>" type="text">
                        <button><i class="fa fa-search"></i></button>
                    </form>
                    <?php echo Modules::run('frontend/getFAQs', $q);?>
                </div>
            </div>
            <div class="col-12">
                <ul class="buttonStyles">
                    <li>
                    </li>
                    <li><button data-toggle="modal" class="qsBtn" data-target="#faq">Have Questions?</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalWrapper vehicleInformationModal" id="faq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <h2 class="modal-title">Submit Your Question</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form id="submit_faq" method="post" onsubmit="return submitFaq(event);">
                <div class="vehicleInfo-form">
                    <input name="qustion_by_name" id="qustion_by_name" type="text" class="normal-input-style" value="<?php echo set_value('qustion_by_name'); ?>" placeholder="Type Your name">

                    <input name="question_by_email" id="question_by_email" type="email" class="normal-input-style" value="<?php echo set_value('question_by_email'); ?>" placeholder="Type Your email">
                    <?php echo form_error('question_by_email') ?>

                    <input name="title" id="title" type="text" class="normal-input-style" value="<?php echo set_value('title'); ?>" placeholder="Type your questions">
                    <?php echo form_error('title') ?>

                    <textarea name="content" id="content" class="normal-input-style" placeholder="Type Description"><?php echo set_value('content'); ?></textarea>

                    <div style="margin-bottom: 20px;"> <div id="ajax_respond"></div></div>

                    <div class="text-center">
                        <button class="default-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
                        setTimeout(function() {	$('#ajax_respond').slideUp('slow'); }, 2000);
                        setTimeout(function() {	 $('#askQuestion').modal('hide') }, 3000);
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