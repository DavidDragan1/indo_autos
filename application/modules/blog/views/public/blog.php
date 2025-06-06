<!-- .blog_hero-area start  -->
<div class="blog_hero-area pt-50 pb-75">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-12">
                <div class="blog_hero-content">
                    <h1 class="fs-34 fw-500 mb-20">Welcome to CarQuest Car Blog
                        for all the Good Stuff about Cars</h1>
                    <p class="fs-16 mb-20">Every gist about cars to help maintain, buy and sell cars.</p>
                    <form class="blog_hero-search-form" action="blog/category" method="get">
                        <input placeholder="Search blog" type="search" name="search" id="search">
                        <button class="material-icons">search</span></button>
                    </form>
                </div>

            </div>
            <div class="col-lg-5 col-12">
                <img class="blog_hero-img" src="assets/new-theme/images/blog.jpg" alt="">
            </div>
        </div>
    </div>
</div>
<!-- .blog_hero-area end  -->

<div class="blog-area">
    <div class="container">
        <div class="d-flex justify-content-between align-content-center mb-20">
            <h4 class="fs-18 fw-500 mb-0">Latest Blog Posts</h4>
            <a class="fs-14 d-inline-block color-theme" href="blog/category">View All Blog Posts</a>
        </div>
        <div class="row pb-10">
            <?php foreach ($latest_posts as $k => $blog) :?>
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
        </div>
        <div class="most_read-blogs-active pb-50">
            <?php foreach ($trendings as $k => $blog) :?>
            <div class="most_read-blog-wrap d-flex flex-wrap align-items-center">
                <div class="most_read-blog-content">
                    <span class="badge-wrap bg-theme_black color-white fs-12">Most Read Blog Post</span>
                    <h4 class="fs-34 fw-600 mb-20 mt-10"><a href="blog-detail/<?=$blog->post_url?>"><?=getShortContent($blog->post_title, 20)?></a></h4>
                    <p class="fw-400 mb-20"><?=getShortContent($blog->description, 200)?></p>
                    <ul class="d-flex justify-content-between align-content-center">
                        <li class="fs-14 fw-300"><?=globalDateFormat($blog->created)?></li>
                        <li class="fw-500 fs-14"><a class="color-theme fi" href="blog-detail/<?=$blog->post_url?>">Read
                                more</a>
                        </li>
                    </ul>
                </div>
                <a href="blog-detail/<?=$blog->post_url?>" class="most_read-blog-img">
                    <?=getBlogFeaturedThumb($blog->thumb,'no_size',getShortContentAltTag($blog->post_title, 60));?>
                </a>
            </div>
            <?php endforeach; ?>
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

<script type="text/javascript" src="assets/new-theme/js/slick.min.js"></script>
<script>
    $('.most_read-blogs-active').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        focusOnSelect: true,
        arrows: true,
    });
</script>
