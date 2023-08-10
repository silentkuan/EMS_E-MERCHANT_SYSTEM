<?php
require('connection.inc.php');
require('functions.inc.php');
$name=get_safe_value($con,$_POST['name']);
$email=get_safe_value($con,$_POST['email']);
$mobile=get_safe_value($con,$_POST['mobile']);
$profile_image=get_safe_value($con,$_POST['profile_image']);
$uid=get_safe_value($con,$_POST['uid']);
$added_on=date('Y-m-d h:i:s');
if (isset($_GET['merchant_name']))
{
    

    $merchant_name = get_safe_value($con,$_GET['merchant_name']);
    

    $get_merchant = "select * from merchant  where merchant_name='$merchant_name'";

    $run_merchant = mysqli_query($con, $get_merchant);

    $row_merchant = mysqli_fetch_array($run_merchant);

    $merchant_logo = $row_merchant['merchant_logo'];

    $merchant_id = $row_merchant['merchant_id'];

    $merchant_favicon = $row_merchant['merchant_favicon_logo'];
    

}
$uid=get_safe_value($con,$_POST['uid']);


$res=mysqli_query($con,"select * from users where uid='$uid' and merchant_id='$merchant_id'");
$check_user=mysqli_num_rows($res);
if($check_user>0){
	$row=mysqli_fetch_assoc($res);
	setcookie('USER_LOGIN', 'yes', time() + (86400 * 30), "/"); 
	setcookie('USER_ID', $row['uid'], time() + (86400 * 30), "/"); 
	setcookie('USER_NAME', $row['name'], time() + (86400 * 30), "/"); 
	setcookie('PROFILE_IMAGE', $row['profile_image'], time() + (86400 * 30), "/"); 
	setcookie('MERCHANT_ID', $merchant_id, time() + (86400 * 30), "/"); 
	
	
	if(isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID']!=''){
		wishlist_add($con,$_COOKIE['USER_ID'],$_SESSION['WISHLIST_ID']);
		unset($_SESSION['WISHLIST_ID']);
	}
	
	echo "valid";
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
	echo "wrong";
}
?>