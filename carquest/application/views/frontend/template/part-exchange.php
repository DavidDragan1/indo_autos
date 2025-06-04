<style>
    .cartrade input.form-control, .cartrade select.form-control, .cartrade span{
        margin: 0;
        height: 48px;
    }
    .cartrade button {
        background-color: #2badc1;
        border: 0 none;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        margin: 10px auto;
        padding: 10px;
        width: 100%;
        text-transform: uppercase;
    }
    .cartrade span{
        min-width: 190px;
        text-align: right !important;
        text-transform: capitalize;
    }
    
</style>

<div class="containter-fulid white_bg">
    <div class="container minimumheight">
      <h2></h2>
      <div class="page-content cartrade">
        <h1>Part Exchange</h1>


        <form action="" method="post" id="mailForm">

              <div class="row">
                  <div class="col-md-6">

                      <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon">Full Name</span>
                              <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon" for="email_address">Email Address</span>
                              <input type="email" class="form-control" name="email" id="email_address" placeholder="Email Address">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon" for="contact_no">Contact Number</span>
                              <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Contact Number">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon" for="vehicle_no">Vehicle identification no</span>
                              <input type="text" class="form-control" name="vehicle_no" id="vehicle_no" placeholder="Vehicle Identification Number">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon" for="car_type">Car type</span>
                              <select  class="form-control" id="car_type" name="car_type">
                                  <option value="Brand New">Brand New</option>
                                  <option value="Used">Used</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon" for="year">Year</span>
                              <select  class="form-control" id="year" name="year">
                                  <option value="2016">2016</option>
                                  <option value="2015">2015</option>
                                  <option value="2014">2014</option>                     
                                  <option value="2013">2013</option>
                                  <option value="2012">2012</option>
                                  <option value="2011">2011</option>
                                  <option value="2010">2010</option>
                                  <option value="2009">2009</option>
                                  <option value="2008">2008</option>
                                  <option value="2007">2007</option>
                                  <option value="2006">2006</option>
                                  <option value="2005">2005</option>
                              </select>
                          </div>
                      </div>
                      
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon" for="make">Make</span>
                          <input type="text" class="form-control" id="make" placeholder="Make" name="make">
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon" for="model">Model</span>
                          <select name="model" class="form-control" id="model" name="model">
                              <option value="Toyota">Toyota</option>
                              <option value="Mazda">Mazda</option>
                              <option value="Volkwagen">Volkwagen</option>
                              <option value="Honda">Honda</option>
                              <option value="Jaguar Landrover">Jaguar Landrover</option>
                              <option value="BMW">BMW</option>
                              <option value="Mercedes Benz">Mercedes Benz</option>
                              <option value="Peugeot">Peugeot</option>
                              <option value="Audi">Audi</option>
                              <option value="Mitsubishi">Mitsubishi</option>
                              <option value="Nissan">Nissan</option>
                              <option value="Ford">Ford</option>
                              <option value="Lexus">Lexus</option>
                              <option value="Hyundai">Hyundai</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon" for="fueltype">Fuel type</span>
                          <select name="fueltype" class="form-control" id="fueltype" >
                              <option value="Petrol">Petrol</option>
                              <option value="Octen">Octen</option>
                              <option value="dizel">dizel</option>
                              <option value="gas">gas</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon" for="enginesize">Engine size</span>
                          <select name="enginesize" class="form-control" id="enginesize">
                              <option value="1.1L -1.3L">1.1L -1.3L</option>
                              <option value="1.4L -1.6L">1.4L -1.6L</option>
                              <option value="1.7L -1.9L">1.7L -1.9L</option>
                              <option value="2L -2.2L">2L -2.2L</option>
                              <option value="2.3L -2.5L">2.3L -2.5L</option>
                              <option value="2.6L -2.8L">2.6L -2.8L</option>
                              <option value="2.9L -3.1L">2.9L -3.1L</option>
                              <option value="3.2L -3.4L">3.2L -3.4L</option>
                              <option value="3.5L -3.7L">3.5L -3.7L</option>
                              <option value="3.8L -4L">3.8L -4L</option>
                              <option value="4.1L -4.3L">4.1L -4.3L</option>
                              <option value="4.4L -4.6L">4.4L -4.6L</option>
                              <option value="4.7L -4.9L">4.7L -4.9L</option>
                              <option value="5L -5.2L">5L -5.2L</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon" for="mileage">Mileage</span>
                          <select name="mileage" class="form-control" id="mileage">                
                              <option value="0-1000">0-1000</option>
                              <option value="1000-2000">1000-2000</option>
                              <option value="2000-3000">2000-3000</option>
                              <option value="3000-4000">3000-4000</option>
                              <option value="4000-5000">4000-5000</option>
                              <option value="5000-6000">5000-6000</option>
                              <option value="6000-7000">6000-7000</option>
                              <option value="7000-8000">7000-8000</option>
                              <option value="8000-9000">8000-9000</option>
                              <option value="9000-10000">9000-10000</option>
                              <option value="10000-11000">10000-11000</option>
                              <option value="11000-12000">11000-12000</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon" for="regi_no">Vehicle registration no</span>
                          <input type="text" class="form-control" id="regi_no" name="regi_no" placeholder="Vehicle Registration Number">
                      </div>
                  </div>
                  
                  <div class="form-group">
                      <button type="button" class="btn btn-primary" id="sendBtn"><i class="fa fa-envelope"></i> Send</button>
                  </div>
                  <div class="form-group">
                      <div id="status"></div>                      
                  </div>

              </div>
            </div>

        </form>
        
      </div>
    </div>
</div>


<script>
    var $ = jQuery; 
    $('#sendBtn').on('click', function(){
        var formData = $('#mailForm').serialize();
        var error = 0;

        var full_name =  $('#full_name').val();
        if(!full_name){
             $('#full_name').addClass('required');        
            error = 1;
        } else{
             $('#full_name').removeClass('required');        
        }
        
        var email_address =  $('#email_address').val();
        if(!email_address){
             $('#email_address').addClass('required');        
            error = 1;
        } else{
             $('#email_address').removeClass('required');        
        }
        
        var contact_no =  $('#contact_no').val();
        if(!contact_no){
             $('#contact_no').addClass('required');        
            error = 1;
        } else{
             $('#contact_no').removeClass('required');        
        }
        
        var vehicle_no =  $('#vehicle_no').val();
        if(!vehicle_no){
             $('#vehicle_no').addClass('required');        
            error = 1;
        } else{
             $('#vehicle_no').removeClass('required');        
        }
        
        var make =  $('#make').val();
        if(!make){
             $('#make').addClass('required');        
            error = 1;
        } else{
             $('#make').removeClass('required');        
        }
        
        var regi_no =  $('#regi_no').val();
        if(!regi_no){
             $('#regi_no').addClass('required');        
            error = 1;
        } else{
             $('#regi_no').removeClass('required');        
        }
        
        

        if(!error){
            $.ajax({
                url: 'mail/part_exchange',
                type: "POST",
                dataType: "json",
                data: formData,
                beforeSend: function(){
                    $('#status').html('<div class="alert alert-success" role="alert"> Sending... </div>').css('display','block');
                },

                success: function(jsonRespond){
                if(jsonRespond.Status == 'OK'){
                    $('#status').html( jsonRespond.Msg );
                    setTimeout(function() {	
                        document.getElementById("mailForm").reset();
                        $('#status').fadeOut('slow');
                    }, 3000);
                }
                
            }
            });
        }
});
    
</script>