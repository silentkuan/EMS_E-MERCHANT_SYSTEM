

<footer id="htc__footer">
            <!-- Start Footer Widget -->
            <div class="footer__container bg__cat--1">
                <div class="container">
                    <div class="row">
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="footer">
                                <h2 class="title__line--2">ABOUT US</h2>
                                <div class="ft__details">
                                    <p><?=$about_us_merchant?></p>
                                    <div class="ft__social__link">
                                        <ul class="social__link">
                                            <?php 
                                            if($whatsapp_merchant){
                                                    echo '<li><a href="'.$whatsapp_merchant.'" target="blank"><i class="fa fa-whatsapp"></i></a></li>';
                                            }
                                            
                                            if($instagram_merchant){
                                                    echo '<li><a href="'.$instagram_merchant.'" target="blank"><i class="fa fa-instagram" ></i></a></li>';
                                            }

                                            if($email_merchant){
                                                echo '<li><a href="mailto:'.$email_merchant.'?subject=Please Help Me!" target="blank"><i class="fa fa-envelope"></i></a></li>';
                                        }
                                        if($mobile_merchant){
                                            echo '<li><a href="tel:'.$mobile_merchant.'" target="blank"><i class="fa fa-phone"></i></a></li>';
                                    }

                                    if($facebook_merchant){
                                        echo '<li><a href="'.$facebook_merchant.'" target="blank"><i class="fa fa-facebook"></i></a></li>';
                                }
                                            ?>
                                            

                                          
                                            

                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40">
                            <div class="footer">
                                <?php
                            $cat_res=mysqli_query($con,"select id, categories  from categories where status=1 and merchant_id='$merchant_id'order by categories asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
	$cat_arr[]=$row;	
} ?>


                                <h2 class="title__line--2">Products</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                   <?php foreach($cat_arr as $list){?>
                                        <li><a href="categories.php?id=<?php echo $list['id']?>&merchant_name=<?=$merchant_name?>"><?php echo $list['categories']?></a></li>
                                        <?php
										}
										?>
                                        
                                        
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-2 col-sm-6 col-xs-12 xmt-40 smt-40">
                            <div class="footer">
                                <h2 class="title__line--2">my account</h2>
                                <div class="ft__inner">
                                    <ul class="ft__list">
                                    
                                    <?php
                                    if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){ ?>
										<li><a href="profile.php?merchant_name=<?=$merchant_name?>">My Account</a></li>
                                        <li><a href="wishlist.php?merchant_name=<?=$merchant_name?>">My Wishlist</a></li>
                                        <li><a href="cart.php?merchant_name=<?=$merchant_name?>">My Cart</a></li>
                                        <li><a href="my_order.php?merchant_name=<?=$merchant_name?>">My Order</a></li>
                                        <?php
									}else{ ?>
<li><a href="contact.php?merchant_name=<?=$merchant_name?>">Contact us</a></li>
                                    <li><a href="cart.php?merchant_name=<?=$merchant_name?>">My Cart</a></li>
                                    <li><a href="login.php?merchant_name=<?=$merchant_name?>">Login/Register</a></li>
                                   <?php }
									?>
                                        
                                        
                                      
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                       
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-5 col-sm-6 col-xs-12 xmt-40 smt-40">
                            <div class="footer">
                                <h2 class="title__line--2">Our Location </h2>
                                <div class="map-footer--2">
                        
                        

                        <?=htmlspecialchars_decode(str_replace('\\', '', $google_map_iframe_merchant))?>
         
                       </div>
                                <!-- <iframe style="border:0px; height:250px;" id="googleMap"src="" ></iframe> -->
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                    </div>
                </div>
            </div>
            <!-- End Footer Widget -->
            <!-- Start Copyright Area -->
            <div class="htc__copyright bg__cat--5">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="copyright__inner">
                                <p>Copyright© <a href="#">Kuan Jiun Ying</a> 2023. All right reserved.</p>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Copyright Area -->
        </footer>
        <!-- End Footer Style -->
    </div>
    <!-- Body main wrapper end -->

    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>
	<script src="js/jquery.imgzoom.js"></script>
	<script src="js/custom.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" class="init">
	

$(document).ready(function () {
	$('#example').DataTable();
});


	</script>
    <script src="https://www.gstatic.com/firebasejs/8.2.6/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.2.6/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"></script>
  <script>

const firebaseConfig = {
    apiKey: APIKEY,
    authDomain: AUTHDOMAIN,
    projectId: PROJECTID,
    storageBucket: STORAGEBUCKET,
    messagingSenderId: MESSAGINGSENDERID,
    appId: APPID,
    measurementId: MEASUREMENTID
  }; 

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
  </script>
</body>

</html>
<style>
 .map-footer--2 iframe {
       
       width: 100%;
       height: 240px;
   }
</style>
