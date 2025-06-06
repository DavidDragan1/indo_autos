<!-- tradesaller-area start  -->
<div class="tradesaller-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div class="tradesaller-header">
                    <h1>Search Trade Seller</h1>
                    <form method="get" action="seller">
                        <input type="text" name="q" class="browser-default" placeholder="Search Seller" value="<?php echo $this->input->get('q'); ?>"/>
                        <button  type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <p>Keyword: Trade name, Seller ID, seller first name or last name, email address, contact
                        number, business address</p>
                </div>
            </div>
            <?php
                $result     = GlobalHelper::getSellers();
                $sellers    = $result['sellers'];
                $pagination = $result['pagination'];

                if(count($sellers) == 0 ){
                    echo '<p class="text-warning"><b> <i class="fa fa-warning"></i> Sorry!</b> No Record Found.</p>';
                }
                ?>

            <?php  foreach ($sellers as $seller) { ?>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="tradesaller-wrap">
                    <a href="<?php echo $seller->post_url;?>" class="tradesaller-img">
                        <?php echo GlobalHelper::getProfilePhoto( $seller->logo,getShortContentAltTag($seller->post_title, 60) ); ?>
                    </a>
                    <div class="tradesaller-content">
                        <h4><a href="<?php echo $seller->post_url;?>"><?php if($seller->post_title) {
                            echo strtoupper(getShortContent($seller->post_title, 25));
                        } else {
                            echo "NO TITLE AVAILABLE";
                        }?></a></h4>
                        <span>#ID-<?php echo sprintf('%05d',$seller->user_id); ?></span>
                        <ul>
                            <?php if($seller->meta_value){ ?>
                                <li><strong>Location:</strong><?php echo getShortContent($seller->meta_value, 25);?></li>
                            <?php } else { ?>
                            <li><strong>Location:</strong>N/A</li>
                            <?php } ?>
                            <li><strong>Name:</strong><?php echo getShortContent($seller->first_name . ' '.$seller->last_name, 25) ;?></li>
                            <li><strong> Phone:</strong><?php echo getShortContent($seller->contact, 25);?></li>
                            <li>Listing from this seller: <span><?php echo GlobalHelper::countSellerListing($seller->user_id);?></span></li>
                        </ul>
                        <div class="text-center">
                            <a href="<?php echo $seller->post_url;?>" class="visitSeller default-btn">Visit Seller page</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-12">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
</div>
<!-- tradesaller-area end  -->

