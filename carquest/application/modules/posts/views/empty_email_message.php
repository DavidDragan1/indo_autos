<div class="modal fade modalWrapper" id="quote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <h2 class="modal-title">Make an Offer</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="contactSeller-wrap">
                <div id="ajax_respond"></div>
                    <div class="modalTextarea">
                        <p class="alert alert-warning">
                            <b>Kindly update your email to make an Offer</b><br/>
                            Please <a href="admin/profile"> click here</a> to update email. </p>
                    </div>
                    <ul class="contact-sell-btn-wrap">
                        <li><button class="close-btn default-btn" type="button" data-dismiss="modal"
                                    aria-label="Close">Close</button></li>
                    </ul>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery('#quote').modal({
        show: true
    });
</script>