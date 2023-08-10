<?php
require ('top.php');
if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
    checkProfileInformation($con,$_COOKIE['USER_LOGIN'],$_COOKIE['USER_ID'],$_COOKIE['MERCHANT_ID']);}

   
?>
<style>
    .map-contacts--2 iframe{
        width: 100%!important;
        /* height:100%!important; */
    }
    </style>
<div class="ht__bradcaump__area" style="background: #eee ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php?merchant_name=<?=$merchant_name?>">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Contact Us</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                        <div class="map-contacts--2">
                        
                        
                        <?=htmlspecialchars_decode(str_replace('\\', '', $google_map_iframe_merchant))?>
                        
          
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                        <h2 class="title__line--6">CONTACT US</h2>
                        <div class="address">
                            <div class="address__icon">
                                <i class="icon-location-pin icons"></i>
                            </div>
                            <div class="address__details">
                                <h2 class="ct__title">our address</h2>
                                <p><a href="<?=$google_map_merchant?> " target="_blank"><?=$address_merchant?> </a></p>
                            </div>
                        </div>
                        <div class="address">
                            <div class="address__icon">
                                <i class="icon-envelope icons"></i>
                            </div>
                            <div class="address__details">
                                <h2 class="ct__title">email</h2>
                                <p><a href="mailto:<?=$email_merchant?>?subject=Please Help Me! " target="_blank"><?=$email_merchant?> </a></p>
                            </div>
                        </div>

                        <div class="address">
                            <div class="address__icon">
                                <i class="icon-phone icons"></i>
                            </div>
                            <div class="address__details">
                                <h2 class="ct__title">Phone Number</h2>
                                <p><a href="tel:<?=$mobile_merchant?> " target="_blank"><?=$mobile_merchant?> </a></p>
                            </div>
                        </div>
                    </div>      
                </div>
                
            </div>
        </section>
        <!-- End Contact Area -->

        <style>
    .map-contacts--2 iframe {
       
        width: 600px;
        height: 500px;
    }
</style>    
<?php require ('footer.php') ?>        
