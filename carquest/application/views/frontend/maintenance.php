<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <base href="<?=base_url()?>" />
    <meta
      content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/theme/new/images/favicon.png"
      type="image/gif"
      sizes="20x20"
    />
    <title>CarQuest</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta property="og:image" content="" />
    <meta property="og:title" content="CarQuest" />
    <meta property="og:description" content="" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@CarQuest" />

    <meta name="twitter:creator" content="" />
    <meta name="twitter:title" content="CarQuest" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />

    <meta name="robots" content="max-image-preview:large" />

    <link rel="stylesheet" href="assets/theme/new/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/theme/new/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/theme/new/css/magnific-popup.css" />
    <link rel="stylesheet" href="assets/theme/new/css/select2.min.css" />
    <link rel="stylesheet" href="assets/theme/new/css/slick.css" />
    <link rel="stylesheet" href="assets/theme/new/css/dropify.min.css" />
    <link rel="stylesheet" href="assets/theme/new/css/slick-theme.css" />
    <link rel="stylesheet" href="assets/theme/new/css/datatables.min.css" />
    <link rel="stylesheet" href="assets/theme/new/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="assets/theme/new/css/style.css" />
    <script src="assets/theme/new/js/jquery-3.4.1.min.js"></script>

    <noscript>
      <img
        height="1"
        width="1"
        src="https://www.facebook.com/tr?id=3073110239476046&ev=PageView&noscript=1"
      />
    </noscript>
  </head>
  <?php
  $maintenance = maintenanceValue($maintenance);
  $date_time = (!empty($maintenance[2])) ? date('Y/m/d H:i:s',strtotime($maintenance[2])) : '';
  ?>
  <body class="maintenance-body">
    <div class="maintenance-area">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 col-12">
            <div class="maintenance-content">
              <h1>The Website is in Maintenance Mode</h1>
              <p>
                We apologise for the inconvenience. CarQuest website is currently
                under scheduled maintenance and upgrades, but will return
                shortly. Thank you for your patience. Please check back in.
              </p>
                <?php if(!empty($date_time) && $date_time > date('Y/m/d H:i:s')) { ?>
                    <div class="countdown-maintenance" id="countdown" data-countdown=""> </div>
                <?php } ?>
              <span class="content"
                >Stay with us on our social media channels</span
              >
              <ul class="social-share">
                <li>
                  <a target="_blank" href="https://www.facebook.com/"
                    ><i class="fa fa-facebook"></i
                  ></a>
                </li>
                <li>
                  <a target="_blank" href="https://twitter.com/"
                    ><i class="fa fa-twitter"></i
                  ></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    href="https://www.instagram.com/"
                    ><i class="fa fa-instagram"></i
                  ></a>
                </li>
                <li>
                  <a
                    target="_blank"
                    href="https://www.youtube.com/channel/UCmyfx9PyVYxg8G1N0hkabjQ?view_as=subscriber"
                    ><i class="fa fa-youtube-play"></i
                  ></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-7 col-12">
            <div class="maintenance-img">
              <img src="assets/theme/new/images/mantainence.svg" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="maintenance-footer">
      <div class="container">
        <div class="row align-items-center mt-50">
          <div class="col-md-6">
            <div class="logo">
              <img src="assets/theme/new/images/logo.svg" alt="" />
            </div>
          </div>
          <div class="col-md-6">
            <p class="copyright">
              &copy;
              <script>
                document.write(new Date().getFullYear());
              </script>
                CarQuest - All Rights Reserved.
            </p>
          </div>
        </div>
      </div>
    </footer>
    <script src="assets/theme/new/js/countdown.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script>
        <?php if(!empty($date_time) && $date_time > date('Y/m/d H:i:s')) { ?>
        $( document ).ready(function() {
            var stillUtc = moment.utc('<?=date('Y-m-d H:i:s',strtotime($date_time))?>').toDate();
            var dtime = moment(stillUtc).local().format('YYYY/MM/DD H:mm:ss');

            $('#countdown').attr('data-countdown',dtime);
        });
        <?php } ?>
        setTimeout(() => {
            $('#countdown').each(function () {
                var $this = $(this),
                    finalDate = $(this).data('countdown');

                $this.countdown(finalDate,
                    function (event) {
                        // if(finalDate == moment().format('YYYY/MM/DD H:mm:ss')) {
                        //     window.location.replace("/");
                        // }
                        if(event.strftime('%-D') === '0'){
                            if(event.strftime('%-H') === '0'){
                                $this.html(event.strftime('<span class="time-count">%M</span>:<span class="time-count">%S</span>'));
                            }else{
                                $this.html(event.strftime('<div class="countdown"><span class="time-count">%-H</span><p>Hours</p></div><div class="countdown"><span class="time-count">%M</span><p>Minutes</p></div><div class="countdown"><span class="time-count">%S</span><p>seconds</p></div>'));
                            }
                        }else{
                            $this.html(event.strftime('<div class="countdown"><span class="time-count">%-D</span><p>Days</p></div><div class="countdown"><span class="time-count">%-H</span><p>Hours</p></div><div class="countdown"><span class="time-count">%M</span><p>Minutes</p></div><div class="countdown"><span class="time-count">%S</span><p>seconds</p></div>'));
                        }
                    });
            });
        }, 200);
    </script>
  </body>
</html>
