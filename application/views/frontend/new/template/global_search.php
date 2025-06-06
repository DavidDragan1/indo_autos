<div class="breadcumb_search-area bg-grey">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb_search-wrap">
                    <ul class="breadcumb-menu">
                        <?php
                        if (!empty($breads)) :
                        foreach ($breads as $bread) {
                        ?>
                        <li><?=$bread?></li>
                        <?php }
                        endif;?>
                    </ul>
                    <form action="buy/car/search" method="get">
                        <div class="input-field input-password">
                            <input name="global_search" value="<?=@$_GET['global_search']?>" type="text" required
                                   placeholder="Search Make, Model, Location">

                           <button type="submit" class="material-icons">search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
