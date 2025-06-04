<div class="filter_row">
    <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border" style="padding: 0; ">
                <form method="get" name="report" action="">
                    <div class="filter_row" style="background: #FFEEDF; padding: 8px 0;">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Keyword -->
                                <div class="col-md-2">
                                    <select name="range" class="form-control" onchange="date_range(this.value)">
                                        <?php echo Users_helper::getRegistraionRange($range); ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="q" placeholder="Keyword" value="<?php echo $q; ?>">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="id" placeholder="Dealers ID" value="<?php echo $id; ?>">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="name" placeholder="Dealers Name" value="<?php echo $name; ?>">
                                </div>
                                <!-- Status -->
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <?php echo getPostStatusDropdown($this->input->get('status')); ?>
                                    </select>
                                </div>

                                <div class="col-md-2 text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
                                    <button type="button" class="btn btn-default" onclick="location.href = 'admin/posts';">Reset</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="custom" style="display: none;margin-top: 10px;">
                                    <div class="col-md-2">
                                        <label style="margin-left: 2px;color: #999" for="">Start Date :</label>
                                        <input type="date" value="<?php echo $fd; ?>" name="fd" placeholder="From Date"  class="form-control input-md js_datepicker">
                                    </div>
                                    <div class="col-md-2">
                                         <label style="margin-left: 2px;color: #999" for="">End Date :</label>
                                        <input type="date" name="td" value="<?php echo $td; ?>"  placeholder="To Date"  class="form-control input-md js_datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
