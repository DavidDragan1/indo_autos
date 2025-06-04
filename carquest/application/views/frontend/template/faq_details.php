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
                <div class="ans-wrap">
                    <h2><?php echo $question; ?></h2>
                    <?php echo $answer; ?>
                </div>
            </div>
            <div class="col-12">
                <ul class="buttonStyles">
                    <li>
                    </li>
                    <li><a href="faq" class="qsBtn">Back to Home</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>