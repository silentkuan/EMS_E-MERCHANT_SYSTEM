<?php
require('functions.inc.php');
if(!isset($_COOKIE['USER_LOGIN']) || $_COOKIE['USER_LOGIN']==""){
	?>
	<script>
	window.location.href='index.php?merchant_name=<?=$merchant_name?>';
	</script>
	<?php
}
$name=get_safe_value($con,$_POST['name']);
$mobile=get_safe_value($con,$_POST['mobile']);
$email=get_safe_value($con,$_POST['email']);
$uid=$_COOKIE['USER_ID'];

mysqli_query($con,"update users set name='$name', mobile='$mobile',email='$email' where uid='$uid' and merchant_id='$merchant_id'");
setcookie('USER_NAME', $name, time() + (86400 * 30), "/"); 

echo "Your name updated";
?>