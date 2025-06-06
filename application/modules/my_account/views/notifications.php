<?php load_module_asset('my_account', 'css' );?>
<style>
    .spare_parts { display: none;}
</style>

<div class="my_account">
   <div class="container">
      <div class="col-md-12">
          <div class="row">
              <div class="col-md-6"><h1><small>Welcome</small> <?php echo getLoginUserData('name'); ?> </h1></div>

          </div>

      </div>
      <div class="row">
         <div class="col-md-3">
            <?php echo Modules::run('my_account/menu'); ?>
         </div>
         <?php
            $user_id    = getLoginUserData('user_id');

            $notifications       = Modules::run('my_account/getUserNotifications', $user_id ); ?>



         <div class="col-md-9 ">
            <div class="col-md-12 no-padding">
               <div class="panel panel-default no-padding">
                  <div class="panel-heading">
                      <h4 class="title">Notification Settings &nbsp;&nbsp;<small>(Be the first to know when  your prefered product is posted on carquest)</small></h4>
                  </div>
                   <div id="response"></div>
                  <form method="post" id="update_notification">
                      <div class="panel-body">
                          <div class="col-md-12">
                              <div id="ajax_respond"></div>
                          </div>
                          <div class="col-md-12">
                              <table class="table table-bordered table-hover" id="tab_logicX">
                                  <thead>
                                      <tr>
                                          <th class="text-center">Vehicle</th>
                                          <th class="text-center">Brand</th>
                                          <th class="text-center">Model</th>
                                          <th class="text-center">Location</th>
                                          <th class="text-center">year</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                    <tr>
                                        <td>
                                            <select name="type_id" id="type_id" class="form-control">
                                                <?php echo GlobalHelper::getDropDownVehicleType(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="brand_id" id="brand_id" class="form-control">
                                                <?php echo GlobalHelper::getAllBrands(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="model_id" id="model_id" class="form-control">
                                                <option value="0">--Select Brand--</option>
                                                <?php // echo GlobalHelper::getAllBrand(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="location_id" id="location_id" class="form-control">
                                                <?php echo GlobalHelper::all_location(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="year" id="year" class="form-control">
                                                <option value="">Please Select</option>
                                                <?php echo numericDropDown(2000, date('Y'), 1, 0); ?>
                                            </select>
                                        </td>
                                        <td><span class="btn btn-primary" onclick="update_notification()"><i class="fa fa-bell"></i> Set Alert</span></td>
                                    </tr>
                                    <tr class="spare_parts">
                                        <td colspan="5">
                                            <select name="parts_description" class="form-control" id="parts_description">
                                                <option value="0"> --Any Part Name-- </option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>



                                  </tbody>
                              </table>



                          </div>



                      </div>





                     </div>
                  </form>


                   <?php $notifications = Modules::run('my_account/getUserNotifications', getLoginUserData('user_id')); ?>
                              <?php if($notifications): ?>
                    <div class="panel panel-default no-padding">
                  <div class="panel-heading">
                     <h4 class="title">My Notifications</h4>
                  </div>
                   <div class="panel-body">

                          <div class="col-md-12">

                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th class="text-center">Vehicle</th>
                                          <th class="text-center">Brand</th>
                                          <th class="text-center">Model</th>
                                          <th class="text-center">Location</th>
                                          <th class="text-center">year</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php foreach($notifications as $notification ) : ?>
                                    <tr>

                                        <td><?php echo GlobalHelper::getProductTypeById($notification->type_id); ?></td>
                                        <td><?php echo GlobalHelper::getBrandNameById($notification->brand_id); ?>
                                        <?php if($notification->parts_description) :  ?>
                                            <br> Parts: <?php  echo GlobalHelper::getParts_description($notification->parts_description); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo GlobalHelper::getBrandNameById($notification->model_id); ?></td>
                                        <td><?php echo GlobalHelper::getLocationById($notification->location_id); ?></td>
                                        <td><?php echo $notification->year; ?></td>
                                        <td><span class="btn btn-danger" onclick="delete_notification( <?php echo $notification->id; ?> )"><i class="fa fa-remove"></i> Remove</span></td>
                                        <?php endforeach; ?>
                                    </tr>

                                  </tbody>
                              </table>




                          </div>



                      </div>
                    </div>
                   <?php endif;  ?>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php load_module_asset('my_account', 'js' );?>







<script>
    var $ = jQuery;
function update_notification(){
    var formData = jQuery('#update_notification').serialize();
    jQuery.ajax({
            url: 'my_account/notifications',
            type: "POST",
            dataType: 'json',
            data: formData,
            beforeSend: function () {
                jQuery('#response').html('<p class="ajax_processing">Updating...</p>').css('display','block');
            },
            success: function ( jsonRespond ) {
                if( jsonRespond.Status === 'OK'){
                    jQuery('#response').html( jsonRespond.Msg );
                    setTimeout(function(){
                       location.href = 'my_account?tab=notifications';
                    }, 1000);

                } else {
                    jQuery('.formresponse').html( jsonRespond.Msg );
                }
            }
        });

}
function delete_notification( id ){
    jQuery.ajax({
            url: 'my_account/delete_notification',
            type: "POST",
            dataType: 'json',
            data: { id: id },
            success: function ( jsonRespond ) {
                if( jsonRespond.Status === 'OK'){
                    jQuery('#response').html( jsonRespond.Msg );
                    setTimeout(function(){
                       location.href = 'my_account?tab=notifications';
                    }, 1000);
                } else {
                    jQuery('.formresponse').html( jsonRespond.Msg );
                }
            }
        });

}

$("#type_id").change(function(){
    var type_id = jQuery(this).val();
    if(type_id  == 4){
        $('.spare_parts').slideDown();
        // $('#parts_description').load('parts/parts_frontview/get_parts_description/' + 1);
        $('#parts_description').load('parts/parts_frontview/get_parts_description2/');
    } else{
        $('.spare_parts').slideUp();
    }

});
</script>

