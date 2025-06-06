<section class="post">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9">  
                    <div class="single-post-content white">
                        <div class="col-md-6">
                            <h1><?php echo $post_title; ?></h1>
                            <h6><?php echo 'Post Date: ' . globalDateFormat($created); ?></h6>
                            <?php echo $content; ?>  
                        </div>
                        <div class="pull-right col-md-6"><?php echo getCMSFeaturedThumb($thumb, 'large'); ?></div>
                        <div class="clearfix"></div>

                    </div>
                </div>

                <div class="col-md-3 single-post-sidebar">
                
                    <div class="single-post-content white">
                        <div class="white">
                            <?php echo getRelatedPostWidgetByCategoryID($parent_id, 5); ?>   
                                              
                        </div>   
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
