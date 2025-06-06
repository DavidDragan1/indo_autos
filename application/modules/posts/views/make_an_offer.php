
<!-- Make an Offer -->

    <span class="material-icons modal-close">close</span>
    <?php echo form_open('mail', ['id' => 'get_quote']) ?>
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
        <div class="make_an_offer-form">
            <div class="offering-wrap">
                <p>Original Price </p>
                <h4><?php echo $price; ?></h4>
            </div>
            <h4>Make an Offer</h4>
            <div class="input-field">
                <input class="number" id="offer_price" name="offer_price" type="number" required>
                <label for="offer_price"><span>Enter Offer Amount</span></label>
                <input type="hidden" placeholder="" name="offer_currency" value="<?php echo $offer_currency; ?>">
                <span class="error-message enter-amount"><?php echo $offer_currency; ?></span>
                <input type="hidden" readonly value=" <?php echo getLoginUserData('name'); ?>" />
            </div>

            <div class="modalTextarea">
                <label for="message">message</label>
                <textarea name="offer_message" id="message" class="form-control" rows="6" required="required" style="margin-top: 0px; margin-bottom: 0px; height: 141px;">I saw this ads for sale at <?php echo base_url('post/'.$post_slug); ?>. I have an offer for the deal and want to discuss with you further. Would you please contact me as soon as possible?</textarea>
            </div>

            <ul class="footer-modal">
                <li><button type="button" class="modal-close">Cancel</button></li>
                <li><button type="submit" id="makeOfferBtn" class="btnStyle">Proceed to Make Offer</button></li>
            </ul>
        </div>
<!--        <div class="make_an_offer-submit">-->
<!--            <img src="assets/new-theme/images/icons/check2.svg" alt="">-->
<!--            <h5>Offer Sent to Olowo Auto</h5>-->
<!--            <ul class="make_an_offer-info">-->
<!--                <li>-->
<!--                    <span>Vehicle Name:</span>-->
<!--                    <span>Toyota Camry XLE 2015</span>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <span>Amount Offered:</span>-->
<!--                    <strong>₦21,000,000</strong>-->
<!--                </li>-->
<!--            </ul>-->
<!--            <button type="submit" class="btnStyle">Okay</button>-->
<!--        </div>-->
    <?php echo form_close(); ?>





