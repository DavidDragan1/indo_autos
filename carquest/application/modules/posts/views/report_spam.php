<div class="modal fade modalWrapper" id="manageRepo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <?php echo form_open('mail', ['id' => 'report_spam']) ?>
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" >
            <h2 class="modal-title">Report this Advert</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="contactSeller-wrap">
                <div id="ajax_respond"></div>
                <form>
                    <div class="modalInput">
                        <label for="name">Your Email</label>
                        <input type="text" name="your_mail" value="<?php echo $your_email; ?>" placeholder="mail@example.com">
                    </div>
                    <div class="modalTextarea">
                        <label for="message">message</label>
                        <textarea class="form-control" rows="10" name="report_msg" style="margin-top: 0px; margin-bottom: 0px; height: 141px;">Hello Admin
    I have found some objectionable information at your listing. I request you to pay attention regarding this advertisement.
    Link: <?php echo base_url('post/') . $this->input->get('slug'); ?></textarea>
                    </div>
                    <ul class="contact-sell-btn-wrap">
                        <li><button class="close-btn default-btn" type="button" data-dismiss="modal"
                                    aria-label="Close">Close</button></li>
                        <li><button data-toggle="modal" data-dismiss="modal" aria-label="Close" type="button" class="default-btn" onclick="submit_report();"><i class="fa fa-save"></i> Submit</button></li>
                    </ul>
                </form>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    jQuery('#manageRepo').modal({
        show: true
    });
</script>

