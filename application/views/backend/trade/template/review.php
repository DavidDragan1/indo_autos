<link rel="stylesheet" href="assets/new-theme/css/rating.min.css">
<script type="text/javascript" src="assets/new-theme/js/rating.min.js"></script>
<!-- All Adverts  -->
<div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">
    <div class="card-top d-flex align-items-center justify-content-between mb-20">
        <h2 class="fs-18 fw-500 color-seconday mb-0">Reviews</h2>
<!--        <button class="btnStyle btnStyleOutline">Next <span class="material-icons">-->
<!--                            navigate_next-->
<!--                        </span></button>-->
    </div>
    <ul class="reviews_list-item">
        <?php foreach ($reviews_data as $review) {?>
        <li class="reviews_item">
            <div class="rating_info" id="rating_<?=$review->id?>"></div>
            <p><?=$review->review?></p>
            <div class="d-flex ">
                <strong><?=$review->user_name?> <?= !empty($review->city) ? ', '.$review->city : ''?></strong>
<!--                <em>Verified Buyer</em>-->
                <?php if (empty($review->child_review)) {?>
                <span class="material-icons reply-btn">
                                reply_all
                            </span>
                <?php } ?>
            </div>
            <?php if (!empty($review->child_review)) {?>
            <div class="ml-20">
                <?=$review->child_review?>
                <span class="material-icons reply-btn">
                                border_color
                            </span>
            </div>
            <?php } ?>
            <div class="reply_form">
                <form method="post" action="admin/reviews/add_reply">
                    <input type="hidden" name="id"  value="<?=!empty($review->child_id) ? $review->child_id : 0?>">
                    <input type="hidden" name="parent_id"  value="<?=$review->id?>">
                    <input type="text" name="review" class="browser-default" placeholder="Type here" value="<?=!empty($review->child_review) ? $review->child_review : ''?>">
                    <button class="material-icons"><?=!empty($review->child_review) ? 'border_color' : 'send'?></button>
                </form>
            </div>
        </li>
            <script>
                $("#rating_"+'<?=$review->id?>').rateYo({
                    ratedFill: "#FFC20D",
                    readOnly: true,
                    rating: parseFloat('<?=$review->rate?>'),
                    spacing: "5px",
                    starWidth: "15px",
                    normalFill: "#DBDBDB"
                });
            </script>
        <?php } ?>
    </ul>
<!--    <form class="post-review">-->
<!--        <div class="input-field">-->
<!--            <textarea class="browser-default" placeholder="Type here"></textarea>-->
<!--        </div>-->
<!--        <div class="d-flex align-items-center justify-content-end">-->
<!--            <div class="d-flex align-items-center justify-content-end">-->
<!--                <button class="waves-effect btnStyle">Send</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
</div>
<!-- All Adverts  -->



<script>
    $(document).on('click', '.reply-btn', function () {
        $(this).parents('.reviews_item').find('.reply_form').slideToggle();
    })
</script>