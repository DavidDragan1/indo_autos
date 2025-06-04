<!-- breadcumb_search-area start  -->
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/global_search.php"; ?>
<!-- breadcumb_search-area end  -->
<!-- search_post-area start  -->
<div class="search_post-area pb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="fs-24 fw-500 mb-15"><?=$meta_title?></h1>
                <div class="search_post-filter-wrap">
                    <h2 class="fs-16 fw-500 color-seconday mb-0">Showing From <?=!empty($this->input->get('page')) ? ($this->input->get('page')-1) * 30 : 0?> To <?=!empty($this->input->get('page')) ? $this->input->get('page')* 30 : 30?> of <?=number_format($total)?> Results</h2>
                </div>
                <div class="row">

                    <?php
                    echo $html;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- search_post-area end  -->
