<?php
require('connection.inc.php');
// // echo "123";
// // exit();
// require('functions.inc.php');

require('add_to_cart.inc.php');
function get_safe_value($con, $str)
{
    if ($str != '') {
        $str = trim($str);
        return mysqli_real_escape_string($con, $str);
    }
}

$pid=get_safe_value($con,$_POST['pid']);
$type=get_safe_value($con,$_POST['type']);
$merchant_id=get_safe_value($con,$_POST['merchant_id']);

if(isset($_COOKIE['USER_LOGIN']) || $_COOKIE['USER_LOGIN']!=""){
	$uid=$_COOKIE['USER_ID'];
	if(mysqli_num_rows(mysqli_query($con,"select * from wishlist where user_id='$uid' and product_id='$pid'"))>0){
		//echo "Already added";
	}else{
		//$added_on=date('Y-m-d h:i:s');
		//mysqli_query($con,"insert into wishlist(user_id,product_id,added_on) values('$uid','$pid','$added_on')");
		//wishlist_add($con,$uid,$pid,$merchant_id);
		$added_on = date('Y-m-d h:i:s');
		mysqli_query($con, "insert into wishlist(user_id,product_id,added_on,merchant_id) values('$uid','$pid','$added_on','$merchant_id')");
	}
	echo $total_record=mysqli_num_rows(mysqli_query($con,"select * from wishlist where user_id='$uid' and merchant_id='$merchant_id'"));
}else{
	$_SESSION['WISHLIST_ID']=$pid;
	echo "not_login";
}
?>