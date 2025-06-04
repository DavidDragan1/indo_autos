<?php if (!empty($photoes)) : ?>


<style>
    
    
#playVideo {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1050;
    display: none;
    overflow: hidden;
    -webkit-overflow-scrolling: touch;
    outline: 0;
	background:rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
}

.videoSpace {
	width: 650px;
    margin: 0 auto;
    background: #FFF;
    padding: 15px;
    top: 50px;
    border: 1px solid #444;
    box-shadow: 0 0 3px #868686;
}

.closePopup {
	float: right;
    right: -30px;
    top: -25px;
    font-size: 12pt;
    color: white;
    position: absolute;
    background: #000;
    padding: 5px 10px;
    border-radius: 50px;
    font-weight: bold;
    cursor: pointer;
}

.videoGallery span img.img-responsive {
    width: 100%;
    min-height: 180px;
    border: 6px solid #ddd;
}



</style>
<div class="row">
    <div class="col-md-12">
        <div class="white_bg">
            <h4>Photo Gallery</h4>
            <hr/>
            <div class="panel-body">
                <div class="videoGallery">
                    <?php foreach ($photoes as $pic) : ?>
                    <div class="col-md-4" style="margin-bottom: 15px; "> <span data-id="<?php echo $pic->id ?>" class="thumbnail text-center viewPhoto" style="border: none !important; cursor:pointer;"> <img src="uploads/gallery/<?php echo $pic->photo ?>" class="img-responsive"><br>
                        <?php // echo $service_name; ?> </span> </div>
                    <?php endforeach; ?>
                    <div class="row"></div>
                </div>
                <style>
                    .modal-content{
                        background-color: transparent !important;
                        padding: 0px !important;
                        border-radius: 0 !important;
                        box-shadow: none !important;
                        border: none;
                    }
                </style>
                <div id="playVideo" style="display:none;">
                    <div class="modal-dialog videoSpace">
                        <div class="modal-content"> <span class="closePopup" onClick="closePopup();">X</span>
                            <div class="modal-body" style="padding:0;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var $ = jQuery;
    //jQuery.noConflict();
    jQuery(".viewPhoto").click( function () {
        var picID = jQuery(this).attr("data-id");
        var userId = "<?php  echo $seller['user_id']; ?>";
        
        jQuery.ajax({
            url: 'profile/profile_frontview/getPhoto/' + userId + '/' + picID,
            type: "GET",
            dataType: "text",
            data: {videoID: picID},
            beforeSend: function () {
                jQuery('#playVideo').css('display', 'block');
                jQuery('.modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
            },
            success: function (msg) {
                jQuery('.modal-body').html(msg);
            },
            cache: false
        });
    });

    function closePopup() {
        $('#playVideo').css('display', 'none');
        $('.modal-body').empty();
    }

</script>

<?php endif; ?>



