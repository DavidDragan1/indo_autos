
<div class="panel panel-default">

    <div class="panel-body user_profile_form">
        <div id="success_report"></div>

        <form id="add_product" method="post" class="form-horizontal"  action="<?php echo $action; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="verifier_id" value="<?php echo $verifier_id; ?>" />
            <input name="isRobot" type="hidden" value="0"/>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Title<sup>*</sup> :<?php echo form_error('title') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" />

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country_id" class="col-sm-3 control-label">Country<sup>*</sup> :<?php echo form_error('country_id') ?></label>
                        <div class="col-sm-9">
                            <select name="country_id" class="form-control" id="country_id" onchange="countryChangeState(this.value)">
                                <?php echo getDropDownCountries($country_id); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location_id" class="col-sm-3 control-label">State<sup>*</sup> :<?php echo form_error('location_id') ?></label>
                        <div class="col-sm-9">
                            <select name="location_id" class="form-control" id="location_id">
                                <?php echo GlobalHelper::all_location($location_id, 'Select State', $country_id); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product_status" class="col-sm-3 control-label">Status<sup>*</sup> :<?php echo form_error('product_status') ?></label>
                        <div class="col-sm-9">
                            <select name="product_status" class="form-control" id="product_status">
                                <option value="Active" <?=$product_status == 'Active' ? 'selected' : ''?>>Active</option>
                                <option value="Inactive" <?=$product_status == 'Inactive' ? 'selected' : ''?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description :<?php echo form_error('description') ?></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="5" name="description"
                                      id="description" placeholder="Description"><?=$description?></textarea>
                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="total_amount" class="col-sm-3 control-label">Total Amount :<?php echo form_error('total_amount') ?></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php echo $total_amount; ?>" />

                        </div>
                    </div>
                </div>
            </div>       
            <button type="submit" class="btn btn-primary pull-right">
                <i class="fa fa-save"></i>
                Update
            </button>             
        </form>
    </div>

</div>
</section>

<script type="text/javascript" src="assets/new-theme/js/select2.min.js"></script>
<script>
    function countryChangeState(countryId){

        if (countryId !== ''){
            $.ajax({
                url: 'post_area/Post_area_frontview/get_state_by_country?countryId='+countryId,
                type: "GET",
                dataType: "text",
                success: function (response) {
                    $('#location_id').html(response);
                }
            });
        }
    }
</script>
