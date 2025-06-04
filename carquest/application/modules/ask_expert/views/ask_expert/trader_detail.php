<h2 class="breadcumbTitle">Details View</h2>
<div class="row">
    <div class="col-xl-8 col-12">
        <div class="mechanic-faq-details-wrap">
            <ul class="details-info">
                <li>
                    <strong>Question</strong>
                    <span><b><?php echo $title; ?></b></span>
                </li>
                <li>
                    <strong>Description</strong>
                    <span><?php echo $description; ?></span>
                </li>
                <li>
                    <strong>Answer</strong>
                    <span><?php echo $content; ?></span>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-xl-4 col-12">
        <div class="mechanic-faq-details-wrap">
            <h4>Summer | Question By</h4>
            <ul class="faq-user-info">
                <li>
                    <strong>Name</strong>
                    <span><?php echo $qustion_by_name; ?></span>
                </li>
                <li>
                    <strong>Email</strong>
                    <span><?php echo $question_by_email; ?></span>
                </li>
                <li>
                    <strong>Status</strong>
                    <span><?php echo $status; ?></span>
                </li>
                <li>
                    <strong>Top FAQ</strong>
                    <span><?php echo $featured; ?></span>
                </li>
                <li>
                    <strong>Created</strong>
                    <span><?php echo globalDateFormat($created); ?></span>
                </li>
                <li>
                    <strong>Updated</strong>
                    <span><?php echo globalDateFormat($modified); ?></span>
                </li>
            </ul>
            <a href="admin/ask_expert" class="btn-wrap">Go Back</a>
        </div>
    </div>
</div>
