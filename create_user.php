<?php
require('connection.inc.php');
require('functions.inc.php');
$name=get_safe_value($con,$_POST['name']);
$email=get_safe_value($con,$_POST['email']);
$mobile=get_safe_value($con,$_POST['mobile']);
$profile_image=get_safe_value($con,$_POST['profile_image']);
$uid=get_safe_value($con,$_POST['uid']);
$added_on=date('Y-m-d h:i:s');

if (isset($_GET['merchant_name'])) {
    $merchant_name = get_safe_value($con, $_GET['merchant_name']);

    $get_merchant = "select * from merchant  where merchant_name='$merchant_name'";

    $run_merchant = mysqli_query($con, $get_merchant);
	
	if($run_merchant->num_rows==1){
		$row_merchant = mysqli_fetch_array($run_merchant);

		$merchant_logo = $row_merchant['merchant_logo'];
	
		$merchant_id = $row_merchant['merchant_id'];
	
		$merchant_favicon = $row_merchant['merchant_favicon_logo'];
		$merchant_about_us = $row_merchant['about_us'];
		$merchant_payment_category_code = $row_merchant['payment_category_code'];
		$merchant_payment_apikey = $row_merchant['payment_apikey'];
	}else{
		//
		// <script>
		// window.location.href='register_merchant.php';
		// </script>
		// 
		header("HTTP/1.0 404 Not Found");
		exit;
	}
}

if(isset($_FILES['profile_image_upload']['name'])){
	$image=date("Ymd").'_'.$_FILES['profile_image_upload']['name'];
	move_uploaded_file($_FILES['profile_image_upload']['tmp_name'],PROFILE_IMAGE_SITE_PATH.$image);
	mysqli_query($con,"insert into users(name,email,mobile,uid,added_on,profile_image,merchant_id) values('$name','$email','$mobile','$uid','$added_on','$image','$merchant_id')");
	setcookie('USER_LOGIN', 'yes', time() + (86400 * 30), "/"); 
	setcookie('USER_ID', $uid, time() + (86400 * 30), "/"); 
	setcookie('USER_NAME', $name, time() + (86400 * 30), "/"); 
	setcookie('PROFILE_IMAGE', $image, time() + (86400 * 30), "/"); 
	setcookie('MERCHANT_ID', $merchant_id, time() + (86400 * 30), "/"); 
}else{

if($profile_image!="null"){
	
 $data = file_get_contents($profile_image);
 $picture_path=date("Ymd")."_".$name.".jpg";
 $picture = "media/profile/".$picture_path;

 file_put_contents($picture, $data);
}else{
	$picture_path=$profile_image;
}
mysqli_query($con,"insert into users(name,email,mobile,uid,added_on,profile_image,merchant_id) values('$name','$email','$mobile','$uid','$added_on','$picture_path','$merchant_id')");
setcookie('USER_LOGIN', 'yes', time() + (86400 * 30), "/"); 
setcookie('USER_ID', $uid, time() + (86400 * 30), "/"); 
setcookie('USER_NAME', $name, time() + (86400 * 30), "/"); 
setcookie('PROFILE_IMAGE', $picture_path, time() + (86400 * 30), "/"); 
setcookie('MERCHANT_ID', $merchant_id, time() + (86400 * 30), "/"); 
}
?>
