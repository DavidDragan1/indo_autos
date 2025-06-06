<div class="blog-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="blog-title">
                    <h1>Latest News</h1>
                    <p>for our clients</p>
                </div>
            </div>
            <?php

            $html = '';
            foreach ($posts as $post){
                $html .= '<div class="col-lg-4 col-md-6 col-12">';
                $html .= '<div class="blog-wrap">';
                $html .= '<div class="blog-img">';
                $html .= '<a href="blog/'. $post->post_url .'">';
                $html .= getCMSFeaturedThumb ( $post->thumb,null,getShortContentAltTag($post->post_title, 60) );
                $html .= '</a>';
                $html .= '</div>';

                $html .= '<div class="blog-content">';
                $html .= '<span>' . globalDateFormat($post->created) .'</span>';
                $html .= '<h3><a href="blog/'. $post->post_url .'">'. getShortContent($post->post_title, 20) .'</a></h3>';
                $html .= '<p>'. getShortContent($post->content,100) .'</p>';
                $html .= '<a href="blog/'. $post->post_url .'" class="readmore">Read more</a>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
            echo  $html;
            ?>
            <?php echo $pagination; ?>
        </div>
    </div>
</div>
