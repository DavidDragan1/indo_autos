<!-- breadcumb_search-area start  -->
<div class="breadcumb_search-area bg-grey pt-40">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb_search-wrap">
                    <div class="input-field input-password">
                        <input id="search" name="search" type="search" required
                               placeholder="Search Make, Model, Location">
                        <i class="material-icons show-password">search</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcumb_search-area end  -->

<div class="blog-area">
    <div class="container">
        <span class="d-block mb-20 fs-14"><a href="blog">Blog/</a><a href="blog/category/<?=$post->category_slug?>"><?=$post->category_name?>/</a><?=$post->post_title?></span>
        <div class="blog-details-wrap mb-50">
            <?=getBlogFeaturedThumb($post->thumb,'no_size',getShortContentAltTag($post->post_title, 60), 'blog_details-img w-100 mb-30');?>
            <h1 class="fs-40 fw-700"><?=$post->post_title?></h1>
            <ul class="d-flex flex-wrap pb-10 mb-20 bb-1">
                <li class="fw-500 color-black mr-30">Written by <a class="color-theme" href="javascript:void(0)"><?=!empty($post->user_name) ? $post->user_name : 'Unknown'?></a></li>
                <li><?=globalDateFormat($post->created)?></li>
            </ul>
            <p class="fs-14"><?=$post->description?></p>
            <ul class="d-flex flex-wrap mt-25 pb-15 bb-1">
                <li class="mr-10 color-black fs-14">Tags</li>
                <?php foreach ($tags as $k => $tag) {?>
                <li class="mr-10"><a class="badge-wrap theme-badge" href="blog/tag/<?=$tag->slug?>"><?=$tag->name?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="row pb-50">
            <div class="col-xl-9 col-12">
                <h4 class="mb-20 fs-18 fw-500">Featured Blog Post</h4>
                <div class="row">
                    <?php foreach ($trendings as $k => $blog) :?>
                        <div class="col-md-6 col-12">
                            <div class="featured_blog-wrap d-flex flex-wrap align-items-center">
                                <a class="featured_blog-img" href="blog-detail/<?=$blog->post_url?>">
                                    <?=getBlogFeaturedThumb($blog->thumb,'no_size',getShortContentAltTag($blog->post_title, 60));?>
                                </a>
                                <div class="featured_blog-content  p-20">
                                    <h4 class="fs-18 fw-500 mb-10"><a href="blog-detail/<?=$blog->post_url?>"><?=getShortContent($blog->post_title, 35)?></a></h4>
                                    <p class="fs-14 fw-400 lh-20 mb-10"><?=getShortContent($blog->description, 80)?></p>
                                    <span class="fs-12">By <?=$blog->user_name?> | <?=globalDateFormat($blog->created)?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-xl-3 col-lg-5 col-md-6 col-12">
                <div class="d-flex justify-content-between align-content-center mb-20">
                    <h4 class="fs-18 fw-500 mb-0">Trending</h4>
                    <a class="fs-14 d-inline-block color-theme" href="blog/category">View All</a>
                </div>
                <ul class="trending_blog-wrap p-20">
                    <?php foreach ($trendings as $k => $blog) :?>
                        <li>
                            <a class="fs-500 fw-600 color-theme" href="blog-detail/<?=$blog->post_url?>"><?=getShortContent($blog->post_title, 20)?></a>
                            <p class="fs-14"><?=getShortContent($blog->description, 30)?></p>
                            <span class="fs-12">By <?=$blog->user_name?> | <?=globalDateFormat($blog->created)?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
