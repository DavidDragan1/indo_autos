<div class="breadcumb_search-area bg-grey pt-40">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb_search-wrap">
                    <form method="get">
                        <div class="input-field input-password">
                            <input id="search" name="search" value="<?=@$_GET['search']?>" type="text"
                                   placeholder="Search Blog">
                            <button class="material-icons show-password" type="submit">search</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="blog-area">
    <div class="container">
        <ul class="d-flex flex-wrap mb-20 allblogs-tab">
            <?php if (!empty($categories)) :?>
            <li class="mr-20"><a class="<?=empty($this->uri->segment(3)) ? 'fw-500 color-theme' : ''?>" href="blog/category">All Blog Posts</a></li>
            <?php foreach ($categories as $k => $category) :?>
                    <li class="mr-20"><a class="<?=!empty($this->uri->segment(3)) && $this->uri->segment(3) == $category->slug ? 'fw-500 color-theme' : ''?>" href="blog/category/<?=$category->slug?>"><?=$category->name?></a></li>
            <?php
                endforeach;
                endif;
                if (!empty($tag)) :
                ?>
                    <li class="mr-20"><a class="fw-500 color-theme" href=javascript:void(0)"><?=$tag->name?></a></li>
            <?php endif; ?>
        </ul>
        <div class="row pb-75">
            <?php foreach ($posts as $k => $blog) :?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <div class="blog-wrap">
                    <a class="blog-img" href="blog-detail/<?=$blog->post_url?>">
                        <?=getBlogFeaturedThumb($blog->thumb,'no_size',getShortContentAltTag($blog->post_title, 60));?>
                    </a>
                    <div class="blog-content p-15 pb-20">
                        <h4 class="fs-18 fw-500 mb-15"><a href="blog-detail/<?=$blog->post_url?>"><?=getShortContent($blog->post_title, 40)?></a></h4>
                        <p class="fs-14 lh-20 mb-20 fw-300"><?=getShortContent($blog->description, 160)?></p>
                        <ul class="d-flex justify-content-between align-content-center">
                            <li class="fs-14 fw-300"><?=globalDateFormat($blog->created)?></li>
                            <li class="fw-500 fs-14"><a class="color-theme fi" href="blog-detail/<?=$blog->post_url?>">Read
                                    more</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?=$pagination?>
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
