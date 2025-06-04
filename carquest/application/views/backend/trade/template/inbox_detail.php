<?php
     $user_id = getLoginUserData('user_id');
?>
<div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">
    <div class="d-flex flex-wrap justify-content-between mb-20">
        <h4 class="fw-500 fs-18">
            <a class="d-flex align-items-center" href="<?php echo site_url('admin/mails')?>">
                <span class="material-icons mr-20"> arrow_back</span>
                <?php
                    echo $subject;
                ?>
            </a>
        </h4>
        <ul class="d-flex">
            <li>
                <button  type="submit" onclick="deleteMail(<?php echo $id; ?>)">
                    <span class="material-icons">delete </span>
                </button>
            </li>
        </ul>
    </div>
    <div class="author_info d-flex flex-wrap align-items-center">
        <span class="author_name_cut author_name_cut_parent">as</span>
        <span id="author_name_parent" style="display: none"><?php echo ucfirst(substr(str_replace('.',' ',$mail_from),0,strpos($mail_from,'@'))); ?></span>
        <div class="author_content">
            <h5 class="fs-18 fw-500 mb-0"><?php echo $subject; ?></h5>
            <p>
                <?php echo $mail_from; ?>
                <span><?php echo \Illuminate\Support\Carbon::parse($created)->format('d/m/Y').' at '. \Illuminate\Support\Carbon::parse($created)->format('H:i a');?></span>
            </p>
        </div>
    </div>
    <div class="inbox_content mb-25">
        <?php echo $body; ?>
            <?php
            if ($attachments):
                foreach ($attachments as $attachment):
                ?>
                <div class="inbox_image ">
                    <img style="margin-top: 10px;" src="<?php echo $attachment->filelocation;?>" alt="">
                </div>
            <?php endforeach;endif;?>
    </div>
    <?php if($child_mails): ?>
        <?php foreach($child_mails as $replyMail): ?>
            <div class="reply_email-box">
                <div class="author_info d-flex flex-wrap align-items-center collups_btn">
                    <span class="author_name_cut_child author_name_cut">sd</span>
                    <div class="author_content">
                        <h5 id="" class="fs-18 fw-500 mb-0 author_name"><?php echo ucfirst(substr(str_replace('.',' ',$replyMail->mail_from),0,strpos($replyMail->mail_from,'@'))); ?></h5>
                        <p>
                            <?php echo $replyMail->mail_from; ?>
                            <span><?php echo \Illuminate\Support\Carbon::parse($replyMail->created)->isoFormat('DD/MM/YYYY').' at '. \Illuminate\Support\Carbon::parse($replyMail->created)->format('H:i a');?></span>
                        </p>
                    </div>
                </div>
                <div class="inbox_content mb-25" style="display: none;">
                    <p class="fs-14 mb-10"><?php echo $replyMail->body;?></p>
                    <div class="inbox_image">
                        <?php
                            $attach_file = get_all_attachments($replyMail->id);
                            if ($attach_file):
                                foreach ($attach_file as $attach):
                        ?>
                        <img src="<?php echo $attach->filelocation?>" alt="<?php echo $attach->filename?>">
                        <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        <?php endforeach;  ?>
    <?php endif;  ?>

    <div id="attachment-mail">
        <form id="mail_reply_form" action="admin/mails/reply_mail_action_trader"  method="post"  class="post-review" enctype="multipart/form-data">
          <div class="input-field">
              <textarea id="reply_body" name="message" class="browser-default" placeholder="Type here"></textarea>
             <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $id; ?>">
             <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
              </div>
          <div class="d-flex align-items-center justify-content-between">
              <div class="rating-input">
                  <div class="file-field">
                      <div class="file-btns hover-theme_bg bg-grey waves-effect">
                          <span class="material-icons">attachment</span>
                          <input name="attachment" type="file" />
                          </div>
                      </div>
                  </div>
              <div class="d-flex align-items-center justify-content-end">
                  <a href="" style="cursor: pointer;" id="cancle_reply" class="color-theme mr-20">Cancel</a>
                  <button type="submit" class="waves-effect btnStyle">Send</button>
                  </div>
              </div>
        </form>
    </div>
    <style>
        .products-statistics-wrap ul li button{
            background: transparent;
            border: 0;
            cursor: pointer;
        }
        .products-statistics-wrap ul li button:hover{
            color: #F05C26;
        }
    </style>
</div>

<script>

    function nameSplit(str) {
        let names = str.split(' '),
            initials = names[0].substring(0, 1).toUpperCase();
        if (names.length > 1) {
            initials += names[names.length - 1].substring(0, 1).toUpperCase();
        }
        return initials;
    }

    let author_name = $('.author_name').text()
    $('.author_name_cut_child').text(nameSplit(author_name));

    let authorNameParent = $('#author_name_parent').text();
    $('.author_name_cut_parent').text(nameSplit(authorNameParent));

    $('#reply').on('click', function () {
        $(this).css('display', 'none')
        $('#replyBox').slideToggle();
    });
    function deleteMail(id){
        var yes = confirm('Are you sure?');
        var type = "<?php echo $type; ?>";
        if (yes) {
            jQuery.ajax({
                type: "POST",
                url: "admin/mails/delete",
                dataType: 'json',
                data: {
                    "id" : id,
                },
                success: function(jsonData) {
                    jQuery('#msg').html(jsonData.Msg).slideDown('slow');
                    if(jsonData.Status === 'OK'){
                        jQuery('#msg').delay(1000).slideUp('slow');
                        if (type === "Inbox") {
                            window.location.href = '<?php echo  site_url(Backend_URL.'mails'); ?>'
                        } else {
                            window.location.href = '<?php echo  site_url(Backend_URL.'mails/sent'); ?>'
                        }
                    } else {
                        jQuery('#msg').delay(5000).slideUp('slow');
                    }
                }
            });
        }
    }
</script>
<script>
    $(document).on('click', '.collups_btn', function () {
        $(this).parent('.reply_email-box').find('.inbox_content').slideToggle();
    })
    $(window).on('load',function (){
        $('.reply_email-box').last().find('.inbox_content').show();
    });
</script>