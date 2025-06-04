<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<div class="clearfix">
    <div class="col-sm-12">
        <br><br>
        <div class="alert alert-warning fade in alert-dismissible">
            
            <p><strong>To chat with a mechanic, kindly make payment to any of below bank details.</strong></p>
           <br>
<p>Mcash:<br>From your mobile phone <br>Dial *402'00009856'Amount# </p>
<p>Bank Trasfer<br>* Diamond Bank - 0088265664 <br>* First Bank - 2030717208 </p>
<p>When a payment is made, simply select the package you have paid for in the dropbox below and click submit for us to activate</p>
<p>Please do use your registered name or registered email address as refrence in making payment</p>
<p>We will activate your chat as soon as we receive your payment confirmation.</p>
<p>Many thanks for using CarQuest Mechanic service </p>

            
        </div>        
    </div>
</div>
<div class="clearfix">
    <div class="col-sm-12">
        <form  action="<?php echo site_url('admin/chat/request-action'); ?>" method="POST" target="_parent">
            <div class="form-group">
                <label for="package_id">Package</label>
                <select name="package_id" class="form-control">
                    <?php echo GlobalHelper::getChatPackages(); ?>
                </select>       
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>
