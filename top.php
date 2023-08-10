<?php
session_start();

date_default_timezone_set("Asia/Kuala_Lumpur");
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
$wishlist_count=0;
$cat_res=mysqli_query($con,"select id, categories  from categories where status=1 and merchant_id='$merchant_id' order by categories asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
	$cat_arr[]=$row;	
}


$totalProduct=totalProduct();

if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
	
	$uid=$_COOKIE['USER_ID'];
	
	
	if(isset($_GET['wishlist_id'])){
		$wid=get_safe_value($con,$_GET['wishlist_id']);
		$query = "DELETE FROM wishlist WHERE id = ? AND user_id = ? AND merchant_id = ?";
		$stmt = $con->prepare($query);
		$stmt->bind_param("sss", $wid, $uid, $merchant_id);
		$stmt->execute();

		$stmt->close();

	}

	$wishlist_count=mysqli_num_rows(mysqli_query($con,"select product.name,product.image,product.price,product.mrp,wishlist.id from product,wishlist where wishlist.product_id=product.id and wishlist.user_id='$uid'"));
}
$res_merchant=mysqli_query($con,"select * from merchant where merchant_id='$merchant_id'");
$check=mysqli_num_rows($res_merchant);
if($check>0){
	$row_merchant=mysqli_fetch_assoc($res_merchant);
	$address_merchant=$row_merchant['address'];
	$email_merchant=$row_merchant['email'];
	$mobile_merchant=$row_merchant['phone_number'];
	$google_map_merchant=$row_merchant['google_map'];
	$google_map_iframe_merchant=$row_merchant['google_map_iframe'];
	$whatsapp_merchant=$row_merchant['whatsapp_link'];
	$instagram_merchant=$row_merchant['instagram_link'];
	$facebook_merchant=$row_merchant['facebook_link'];
	$about_us_merchant=$row_merchant['about_us'];
	$website_merchant=$row_merchant['website_link'];
   
}
$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/',$script_name);
$mypage=$script_name_arr[count($script_name_arr)-1];


$meta_title=$merchant_name;
$meta_desc=$merchant_about_us;
$meta_keyword=$merchant_name;
$meta_url=SITE_PATH;
$meta_image="";
if($mypage=='product.php'){
	$product_id=get_safe_value($con,$_GET['id']);
	$product_meta=mysqli_fetch_assoc(mysqli_query($con,"select meta_title,meta_desc,meta_keyword,image from product where id='$product_id'"));
	$meta_title=$product_meta['meta_title'];
	$meta_desc=$product_meta['meta_desc'];
	$meta_keyword=$product_meta['meta_keyword'];
	$meta_url=SITE_PATH."product.php?id=".$product_id;
	$meta_image=PRODUCT_IMAGE_SITE_PATH.$product_meta['image'];
}if($mypage=='contact.php'){
	$meta_title='Contact Us';
}


?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $meta_title?></title>
    <meta name="description" content="<?php echo $meta_desc?>">
	<meta name="keywords" content="<?php echo $meta_keyword?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta property="og:title" content="<?php echo $meta_title?>"/>
	<meta property="og:image" content="<?php echo $meta_image?>"/>
	<meta property="og:url" content="<?php echo $meta_url?>"/>
	<meta property="og:site_name" content="<?php echo SITE_PATH?>"/>
	<link rel="icon" type="image/png" href="media/logo/<?=$merchant_favicon?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
	<script src="js/vendor/modernizr-3.5.0.min.js"></script>
	<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.css">
	<link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css">
	<style>
	
	</style>
</head>
<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->  

    <!-- Body main wrapper start -->
    <div class="wrapper">
        <header id="htc__header" class="htc__header__area header--one">
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="index.php?merchant_name=<?=$merchant_name?>"><img src="<?=  LOGO_IMAGE_SITE_PATH.$merchant_logo ?>" alt="logo images" width="80px" ></a>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-5 col-sm-4 col-xs-2">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        <li class="drop"><a href="index.php?merchant_name=<?=$merchant_name?>">Home</a></li>
                                        <?php
										foreach($cat_arr as $list){
											?>
											<li class="drop"><a href="categories.php?id=<?php echo $list['id']?>&merchant_name=<?=$merchant_name?>"><?php echo $list['categories']?></a>
											<?php
											$cat_id=$list['id'];
											$sub_cat_res=mysqli_query($con,"select id, sub_categories from sub_categories where status='1' and categories_id='$cat_id' and merchant_id='$merchant_id'");
											if(mysqli_num_rows($sub_cat_res)>0){
											?>
											
											   <ul class="dropdown">
													<?php
													while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)){
														echo '<li><a href="categories.php?id='.$list['id'].'&sub_categories='.$sub_cat_rows['id'].'&merchant_name='.$merchant_name.'">'.$sub_cat_rows['sub_categories'].'</a></li>
													';
													}
													?>
												</ul>
												<?php } ?>
											</li>
											<?php
										}
										?>
                                        <li><a href="contact.php?merchant_name=<?=$merchant_name?>">contact</a></li>
                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
										
                                        <ul>
										<li><a> Hi <?php echo $_COOKIE['USER_NAME']?></a></li>
                                            <li><a href="index.php?merchant_name=<?=$merchant_name?>">Home</a></li>
                                            <?php
											foreach($cat_arr as $list){
												?>
												<li class="drop"><a href="categories.php?id=<?php echo $list['id']?>&merchant_name=<?=$merchant_name?>"><?php echo $list['categories']?></a>
											<?php
											$cat_id=$list['id'];
											$sub_cat_res=mysqli_query($con,"select id, sub_categories from sub_categories where status='1' and categories_id='$cat_id' and merchant_id='$merchant_id'");
											if(mysqli_num_rows($sub_cat_res)>0){
											?>
											
											   <ul class="dropdown">
													<?php
													while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)){
														echo '<li><a href="categories.php?id='.$list['id'].'&sub_categories='.$sub_cat_rows['id'].'&merchant_name='.$merchant_name.'">'.$sub_cat_rows['sub_categories'].'</a></li>
													';
													}
													?>
												</ul>
												<?php } ?>
											</li>
												<?php
												
											}?>
											<li><a href="contact.php?merchant_name=<?=$merchant_name?>">contact</a></li>
											<?php
											 if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
												
											?>
											

											 <li> <a class="dropdown-item" href="my_order.php?merchant_name=<?=$merchant_name?>">Order</a></li>
													  
											<li>  <a class="dropdown-item" href="profile.php?merchant_name=<?=$merchant_name?>">Profile</a></li>
                                            
											<li><a class="dropdown-item" href="logout.php?merchant_name=<?=$merchant_name?>" >Logout</a></li>
											<?php }?>
                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            <div class="col-md-4 col-lg-5 col-sm-5 col-xs-5">
                                <div class="header__right">
									<?php 
									$class="mr15";
									if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
										$class="";
									}
									?>
									<div class="header__search search search__open <?php echo $class?>">
                                        <a href="#"><i class="icon-magnifier icons"></i></a>
                                    </div>
									<?php if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
											?>
									<img src="<?= $_COOKIE['PROFILE_IMAGE'] == "null" ? PROFILE_IMAGE_SITE_PATH.'null-user.png'  :  PROFILE_IMAGE_SITE_PATH.$_COOKIE['PROFILE_IMAGE']; ?>" class="img-fluid img-thumbnail" alt="Profile Picture" style="width:50px;">
										<?php }?>
                                    <div class="header__account">
										<?php if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
											?>
											
											<nav class="navbar navbar-expand-lg navbar-light bg-light">
											   <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
												<span class="navbar-toggler-icon"></span>
											  </button> -->
<br>
											  <div class="collapse navbar-collapse" id="navbarSupportedContent">
											  
  

												<ul class="navbar-nav mr-auto">
												  <li class="nav-item dropdown">
													
													<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													  Hi <?php echo $_COOKIE['USER_NAME']?>
													</a>
													<div class="dropdown-menu" aria-labelledby="navbarDropdown">
													  <a class="dropdown-item" href="my_order.php?merchant_name=<?=$merchant_name?>">Order</a>
													  <a class="dropdown-item" href="profile.php?merchant_name=<?=$merchant_name?>">Profile</a>
													  <div class="dropdown-divider"></div>
													  <a class="dropdown-item" href="logout.php?merchant_name=<?=$merchant_name?>" >Logout</a>
													</div>
												  </li>
												  
												</ul>
											  </div>
											</nav>
											<?php
										}else{
											echo '<a href="login.php?merchant_name='.$merchant_name.'" class="mr15">Login/Register</a>';
										}
										?>
									
                                        
										
                                    </div>
                                    <div class="htc__shopping__cart">
										<?php
										if(isset($_COOKIE['USER_ID'])){
										?>
										
										<a href="wishlist.php?merchant_name=<?=$merchant_name?>" class="mr15"><i class="icon-heart icons"></i></a>
                                        <a href="wishlist.php?merchant_name=<?=$merchant_name?>"><span class="htc__wishlist"><?php echo $wishlist_count?></span></a>
										<?php } ?>
                                        <a href="cart.php?merchant_name=<?=$merchant_name?>"><i class="icon-handbag icons"></i></a>
                                        <a href="cart.php?merchant_name=<?=$merchant_name?>"><span class="htc__qua"><?php echo $totalProduct?></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
				<div id="alert-message" class="alert alert-success fade in alert-place "></div>
				<div id="alert-error-message" class="alert alert-danger fade in alert-place "></div>
       
        
    </div>
            </div>
        </header>
		<div class="body__overlay"></div>
		<div class="offset__wrapper">
            <div class="search__area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
						
                            <div class="search__inner">
                                <form action="search.php" method="get">
								<input  type="hidden" name="merchant_name" value="<?=$merchant_name?>">
                                    <input placeholder="Search here... " type="text" name="str">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>