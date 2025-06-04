<div class="blog-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="latest-post">
                    <h3>Recent Posts</h3>
                    <ul class="recent-post-items">
                        <?php echo getRelatedPostWidgetByCategoryID($parent_id, 3, $id); ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="blog-details-wrap">
                    <?php echo getCMSFeaturedThumb($thumb, 'blog_details'); ?>
                    <ul class="meta">
                        <li><?php
                                 if (!empty($user_name)) {
                                     echo 'By ' . $user_name. ' on '. globalDateFormat($created);
                                 } else {
                                     echo globalDateFormat($created);
                                 }
                            ?>
                        </li>
<!--                        <li>5 Comments</li>-->
                    </ul>
                    <h2><?php echo $post_title; ?></h2>
                    <?php echo $content; ?>
                    <ul class="nextPrev">
                        <li>
                            <?php $prev_page = getPrevPost($parent_id, $id);
                                if (!is_null($prev_page)) {
                                    echo '<a href="blog/'.$prev_page.'"><i class="fa fa-angle-left"></i> Prev Post</a>';
                                }
                            ?>
                        </li>
                        <li>
                            <?php $next_page = getNextPost($parent_id, $id);
                                if (!is_null($next_page)) {
                                   echo '<a href="blog/'.$next_page.'">Next Post <i class="fa fa-angle-right"></i> </a>';
                                }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
