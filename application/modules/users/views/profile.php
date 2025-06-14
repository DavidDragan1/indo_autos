<?php

defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('users','css');
load_module_asset('users','js');

?>

<section class="content-header">
    <h1>User Details <small>of</small> <?php echo $first_name . ' ' . $last_name; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin </a></li>
        <li class="active">User list</li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-md-12"> <?php echo Users_helper::makeTab($id,  'profile' ); ?></div>
    <div class="col-md-9">


        <div class="box box-primary no-border">
            <div class="box-body">

                <div class="row">
                    <div class="col-md-2">Full Name</div>
                    <div class="col-md-4">: <?php echo $title . ' ' . $first_name . ' ' . $last_name; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Email Address</div>
                    <div class="col-md-4">: <?php echo $email; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-2"> Contact Number 01 </div>
                    <div class="col-md-4">: <?php echo $contact; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-2"> Contact Number 02 </div>
                    <div class="col-md-4">: <?php echo $contact1; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-2"> Contact Number 03 </div>
                    <div class="col-md-4">: <?php echo $contact2; ?></div>
                </div>

                 <div class="row">
                    <div class="col-md-2">Registration Date </div>
                    <div class="col-md-4">: <?php echo globalDateFormat($created); ?>


                        <em><a> [ counting <?php echo sinceCalculator($created); ?> ] </a></em>
                    </div>
                </div>


                <div class="row" style="padding-top: 20px">
                    <div class="col-md-2">Address Line 1</div>
                    <div class="col-md-4">: <?php echo $add_line1; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Address Line 2</div>
                    <div class="col-md-4">: <?php echo $add_line2; ?></div>
                </div>

                <div class="row">
                    <div class="col-md-2">City</div>
                    <div class="col-md-4">: <?php echo $city; ?></div>
                </div>


                <div class="row">
                    <div class="col-md-2">State/Region </div>
                    <div class="col-md-4">: <?php echo $state; ?></div>
                </div>


                <div class="row">
                    <div class="col-md-2">Postcode</div>
                    <div class="col-md-4">: <?php echo $postcode; ?></div>
                </div>


                <div class="row">
                    <div class="col-md-2">Country</div>
                    <div class="col-md-4">: <?php echo $country_id; ?></div>
                </div>


                <br>
                <?php if (in_array($role, [4, 5])) { ?>
                    <div class="row" id="">


                        <div class="col-md-2">Seller Status</div>
                        <div class="col-md-4">:
                            <select name="seller_tag" class="" onchange="selectStatus(this.value, <?php echo $id; ?>);">
                                <?php echo GlobalHelper::seller_status($id);  ?>
                            </select>
                        </div><div class="col-md-6"><div id="seller_status"></div></div>
                    </div>
                <?php } elseif (in_array($role, [8])) { ?>
                    <div class="row" id="">
                        <div class="col-md-2">Verification Status</div>
                        <div class="col-md-4">:
                            <select name="mechanicStatus" class="" onchange="changeVerificationStatus(this.value, <?php echo $id; ?>);">
                                <?php echo GlobalHelper::mechanicVerificationStatus($id);  ?>
                            </select>
                        </div><div class="col-md-6"><div id="mechanicStatus"></div></div>
                    </div>
                <?php } ?>


            </div>
        </div>
    </div>


    <div class="col-md-3">

        <div class="box box-primary">
            <div class="box-body box-profile">


              <img class="profile-user-img img-responsive lazyload img-circle" src="<?php echo Users_helper::getUserProfilePhoto( $profile_photo ); ?>" alt="Profile Picture">

              <h3 class="profile-username text-center"><?php echo $title . ' ' . $first_name . ' ' . $last_name; ?></h3>
              <p class="text-muted text-center"><?php echo $role_id; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Age</b> <a class="pull-right"><?php echo ageCalculator($dob); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Date of Birth</b> <a class="pull-right"><?php echo globalDateFormat($dob); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Status</b> <a class="pull-right"><?php echo $status; ?> </a>
                </li>
                <li class="list-group-item">
                  <b>Last Access</b> <a class="pull-right"><?php echo $last_access; ?> </a>
                </li>
              </ul>





            <form role="form" method="post">
                <label class="control-label"><b><br/>Change Password</b></label>
                <div class="input-group">
                  <input name="password" id="new_pass" class="form-control" type="text">
                  <span class="input-group-addon" style="cursor: pointer;" onclick="make_password();"><i class="fa fa-refresh"></i></span>
                </div>

                <button type="submit" class="btn btn-primary btn-block reset-btn"><i class="fa fa-send"></i> Reset & Send Notify </button>
            </form>

            </div>

            <!-- /.box-body -->
          </div>






    </div>


    </div>

</section>


<script>


function selectStatus(type, user_id) {
        var type = type;


       jQuery.ajax({
            url: "admin/users/seller_status",
            type: "POST",
            dataType: "text",
            data: {type: type, user_id: user_id},
            beforeSend: function () {
                jQuery('#seller_status').html('Loading...');
            },
            success: function (data) {
                jQuery('#seller_status').html(data);
               // settimeout();
            }
        });

}

function changeVerificationStatus(status, user_id) {
    jQuery.ajax({
        url: "admin/users/mechanic-verification-status-change",
        type: "POST",
        dataType: "text",
        data: {badge: status, user_id: user_id},
        beforeSend: function () {
            jQuery('#mechanicStatus').html('Loading...');
        },
        success: function (data) {
            jQuery('#mechanicStatus').html(data);
            // settimeout();
        }
    });

}

</script>
