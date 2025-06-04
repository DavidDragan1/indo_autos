<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

 load_module_asset('gallery','css');
?>
<section class="content-header">
    <h1>Gallery <small>Settings</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php Backend_URL . 'gallery/' ?>"><i class="fa fa-dashboard"></i> Gallery</a></li>
        
        <li class="active">Settings</li>
    </ol>
</section>


<style>
.input-group .input-group-addon { min-width: 10px;  }
</style>


<section class="content">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Gallery Settings</h3>                        
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <pre style="display: none;">             
            <?php print_r($settings); ?>                       
        </pre>

        <form  action="<?php echo Backend_URL ?>gallery/saveSettings"  enctype="multipart/form-data"  class="form-horizontal" id="gellery-setting" method="post">    
            <div class="box-body">
                <?php
                if ($this->session->message) {
                    echo '<div class="alert alert-success">' . $this->session->message . '</div>';
                }
                ?>

                <div class="row">
                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <label for="limit" class="col-sm-4 control-label">View Photo Per Page :</label>
                            <div class="col-sm-8">
                                <input type="number" class="col-xs-3 form-control" name="limit" id="limit" placeholder="10" value="<?php echo $settings['limit']; ?>"  />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="caption_1" class="col-sm-4 control-label">Display Caption :</label>
                            <div class="col-sm-8" style="padding-top: 8px;">                                                                      
                                <label><input type="radio" id="caption_1" name="caption" <?php echo isCheck( $settings['caption'], 1 );?> value="1"> Yes &nbsp;&nbsp;&nbsp;</label>
                                <label><input type="radio" id="caption_0"  name="caption" <?php echo isCheck( $settings['caption'], 0 );?> value="0"> No</label>                                    
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="description_1" class="col-sm-4 control-label">Display Description :</label>
                            <div class="col-sm-8" style="padding-top: 8px;">                                                               
                                <label><input type="radio" id="description_1" name="description" <?php echo isCheck( $settings['description'], 1 );?> value="1"> Yes &nbsp;&nbsp;&nbsp;</label>
                                <label><input type="radio" id="description_0" name="description" <?php echo isCheck( $settings['description'], 0 );?> value="0"> No</label>                               
                            </div>
                        </div>




                        <div class="form-group">
                            <label for="thumb_width" class="col-sm-4 control-label"> Thumb Cropping Size :</label>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Width</span>
                                    <input name="thumb_width" id="thumb_width"  maxlength="3"  class="form-control" placeholder="120" type="text" value="<?php echo $settings['thumb_width'];  ?>">
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Height</span>
                                    <input name="thumb_height" class="form-control" maxlength="3"  placeholder="100" type="text" value="<?php echo $settings['thumb_height'];  ?>">
                                    <span class="input-group-addon">px</span>
                                </div>                         
                            </div>                                                          
                        </div>


                        <div class="form-group">
                            <label for="thumb_width" class="col-sm-4 control-label"> Medium Cropping Size :</label>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Width</span>
                                    <input name="medium_width" id="thumb_width" maxlength="3"  class="form-control" placeholder="280" type="text" value="<?php echo $settings['medium_width'];  ?>">
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Height</span>
                                    <input name="medium_height" class="form-control" maxlength="3"  placeholder="320" type="text" value="<?php echo $settings['medium_height'];  ?>">
                                    <span class="input-group-addon">px</span>
                                </div>                         
                            </div>                                                          
                        </div>

                        <div class="form-group">
                            <label for="large_width" class="col-sm-4 control-label"> Large Cropping Size :</label>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Width</span>
                                    <input name="large_width" id="thumb_width" maxlength="3" class="form-control" placeholder="900" type="text" value="<?php echo $settings['large_width'];  ?>">
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Height</span>
                                    <input name="large_height" class="form-control" maxlength="3"  placeholder="650" type="text" value="<?php echo $settings['large_height'];  ?>">
                                    <span class="input-group-addon">px</span>
                                </div>                         
                            </div>                                                          
                        </div>



                        <div class="form-group">
                            <label for="watermark_1" class="col-sm-4 control-label">Apply Watermark :</label>

                            <div class="col-md-8" style="padding-top: 8px;">
                                                                                                                                
                                <label> <input type="radio" id="watermark_1" name="watermark" <?php echo isCheck( $settings['watermark'], 1 );?> value="1" checked="checked"> Yes &nbsp;&nbsp;&nbsp; </label>                        
                                <label> <input type="radio" id="watermark_0" name="watermark" <?php echo isCheck( $settings['watermark'], 0 );?> value="0"> No</label>
                                   
                            </div>
                        </div>                    
                    </div>

                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <label for="watermark_logo" class="col-sm-4 control-label">Watermark Logo :</label>
                            <div class="col-sm-8">                                               
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Select Logo
                                    <input type="file" name="watermark_logo"  id="profilePic" value="<?php echo $settings['watermark_logo']; ?>" >                                                                                                                                     
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Image Preview :</label>
                            <div class="col-md-8">
                                <div class="watermark-preview">                                                                                                  
                                    <div id="image_preview1">                                             
                                        <img id="js_position" src="uploads/watermark_org.png" 
                                            <?php echo switchWatermakrPosition( $settings['position'] ); ?> />                                                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="watermark_opacity" class="col-sm-4 control-label">Watermark Opacity :</label>
                            <div class="col-sm-8">                                                                                                
                                <div class="input-group">
                                    <span class="input-group-addon">Min 10%</span>
                                    <input id="slider2" class="form-control js_opacity" name="watermark_opacity"type ="range" min="0.10" max="1.0" step="0.10" value ="<?php echo ( $settings['watermark_opacity'] ); ?>"/>
                                    <span class="input-group-addon">Max 100%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Watermark Position :</label>
                            <div class="col-sm-2">
                                <table id="wm_position" class="table table-bordered">
                                    <tr>
                                        <td><input type="radio" class="js_position" name="position" <?php echo isCheck( $settings['position'], 'TL' );?>  value="TL"/></td>
                                        <td></td>
                                        <td><input type="radio" class="js_position" name="position" <?php echo isCheck( $settings['position'], 'TR' );?> value="TR"/></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="radio" class="js_position" name="position" <?php echo isCheck( $settings['position'], 'C' );?> value="C"/></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" class="js_position" name="position" <?php echo isCheck( $settings['position'], 'BL' );?> value="BL"/></td>
                                        <td></td>
                                        <td><input type="radio" class="js_position" name="position" <?php echo isCheck( $settings['position'], 'BR' );?> value="BR"/></td>
                                    </tr>
                                </table>                                                                     
                            </div>
                        </div>
                        
                        
                    </div>                                        
                </div>



            </div>
            <!-- /.box-body -->


            <div class="box-footer">
                <div class="col-md-offset-2"> 
                    <button type="submit" class="btn btn-default">Back</button>
                    <input type="submit" name="btn" class="btn btn-primary"> 
                </div>
            </div>
        </form>
        <!-- /.box-footer -->
    </div>
</section>


<script>
    $('.js_position').on('click', function(){
        var position = $(this).val();        
        switch( position ){
            case 'TL' :
                $('#js_position').removeAttr('style');
                $('#js_position').css('top','0').css('left','0');
                break;
            case 'TR' :
                $('#js_position').removeAttr('style');
                $('#js_position').css('top','0').css('right','0');
                break;
            case 'BL' :
                $('#js_position').removeAttr('style');
                $('#js_position').css('bottom','0').css('left','0');
                break;
            case 'BR' :
                $('#js_position').removeAttr('style');
                $('#js_position').css('bottom','0').css('right','0');
                break;
            default :
                $('#js_position').removeAttr('style');
                $('#js_position').css('top','36%').css('left','35%');
        }      
    });
</script>


<script>
    $('.js_opacity').on('change', function(){             
        var opacity_value = $(this).val();
        $('#js_position').css('opacity',opacity_value);                                     
    });
</script>


<script>
                        
 
    $("#profilePic").change(function () {

        var file        = this.files[0];
        var imagefile   = file.type;
        var match       = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]))){
            $('#js_position').attr('src', 'noimage.png');
            return false;
        } else {
            var reader      = new FileReader();
            reader.onload   = imageIsLoaded1;
            reader.readAsDataURL(this.files[0]);
        }
    });

    function imageIsLoaded1(e) {
        $("#profilePic").css("color", "green");
        $('#image_preview1').css("display", "block");
        $('#js_position').attr('src', e.target.result);
        $('#js_position').attr('width', '180px');
    }







</script>
                       
                        
                        
