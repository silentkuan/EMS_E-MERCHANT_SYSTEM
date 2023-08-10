<?php
require "connection.inc.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
if (isset($_GET['merchant_name'])) {
	$merchant_name = get_safe_value($con, $_GET['merchant_name']);
 
	$get_merchant = "SELECT * FROM merchant WHERE merchant_name = ?";
$stmt = mysqli_prepare($con, $get_merchant);
mysqli_stmt_bind_param($stmt, "s", $merchant_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row_merchant = mysqli_fetch_array($result);
mysqli_stmt_close($stmt);

if ($row_merchant) {
    $merchant_logo = $row_merchant['merchant_logo'];
    $merchant_id = $row_merchant['merchant_id'];
    $merchant_favicon = $row_merchant['merchant_favicon_logo'];
	$merchant_payment_category_code = $row_merchant['payment_category_code'];
	$merchant_payment_apikey = $row_merchant['payment_apikey'];

    // Rest of your code handling the retrieved values
}else{
	?>

<script>
window.location.href='../register_merchant.php';
</script>


<?php	
}

}else{
	if (!isset($_GET['merchant_name'])) { 
		// echo "1111111111111111111111111111111111111111111111";
		header('Location: ../register_merchant.php');
		exit;
		
	}
}

function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($con,$str){
	if($str!=''){
		$str=trim($str);
		return mysqli_real_escape_string($con,$str);
	}
}

function encrypt($text){
    //Define cipher 
    $cipher = "aes-256-cbc"; 
    
    //Generate a 256-bit encryption key 
    //$encryption_key = //Generate a 256-bit encryption key 
    $encryption_key = hash('sha256', "CRYPTOGRAPHY"); 

    // Generate an initialization vector 
    $iv_size = openssl_cipher_iv_length($cipher); 
    $iv = '8746376827619797';
    //$iv = openssl_random_pseudo_bytes($iv_size); 

    //Data to encrypt 
    $data = $text; 
    $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv); 

    return $encrypted_data;
    //echo "Encrypted Text: " . $encrypted_data; 
}

function decrypt($text){
    //Define cipher 
    $cipher = "aes-256-cbc"; 

    //Generate a 256-bit encryption key 
    $encryption_key = hash('sha256', "CRYPTOGRAPHY"); 

    // Generate an initialization vector 
    $iv_size = openssl_cipher_iv_length($cipher); 
    $iv = '8746376827619797';
    //$iv = openssl_random_pseudo_bytes($iv_size); 
    
    //Decrypt data 
    $encrypted_data=$text;
    $decrypted_data = openssl_decrypt($encrypted_data, $cipher, $encryption_key, 0, $iv); 
    return $decrypted_data;
    //echo "Decrypted Text: " . $decrypted_data;
}

function productPendingByProductId($con,$pid){
	global $merchant_id;
	$sql = "SELECT * FROM product WHERE id = ? AND merchant_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ii", $pid, $merchant_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if ($row) {
    return $row['pending_qty'];
} else {
    return null;  // or any appropriate value indicating no result found
}

}

// function validShipRocketToken($con){
// 	date_default_timezone_set('Asia/Kolkata');
// 	$row=mysqli_fetch_assoc(mysqli_query($con,"select * from shiprocket_token"));
// 	$added_on=strtotime($row['added_on']);
// 	$current_time=strtotime(date('Y-m-d h:i:s'));
// 	$diff_time=$current_time-$added_on;
// 	if($diff_time>86400){
// 		$token=generateShipRocketToken($con);
// 	}else{
// 		$token=$row['token'];
// 	}
// 	return $token;
// }

// function generateShipRocketToken($con){
// 	date_default_timezone_set('Asia/Kolkata');
// 	$curl = curl_init();
//   curl_setopt_array($curl, array(
//     CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "POST",
//     CURLOPT_POSTFIELDS =>"{\n    \"email\": \"SHIPROCKET_TOKEN_EMAIL\",\n    \"password\": \"SHIPROCKET_TOKEN_PASSWORD\"\n}",
//     CURLOPT_HTTPHEADER => array(
//       "Content-Type: application/json"
//     ),
//   ));
//   $SR_login_Response = curl_exec($curl);
//   curl_close($curl);
//   $SR_login_Response_out = json_decode($SR_login_Response,true);
  
//   if(isset($SR_login_Response_out['token'])){
// 	  $token = $SR_login_Response_out['token'];
// 	  $added_on=date('Y-m-d h:i:s');
// 	  mysqli_query($con,"update shiprocket_token set token='$token',added_on='$added_on' where id=1");
// 	  return $token;
//   }else{
// 	  echo "<div class='shiprocket_error'>Token Error: ".$SR_login_Response_out['message'].'</div>';
//   }
// }

// function placeShipRocketOrder($con,$token,$order_id){
// 	$row_order=mysqli_fetch_assoc(mysqli_query($con,"select `order`.*,users.name,users.email,users.mobile from `order`,users where `order`.id=$order_id and `order`.user_id=users.id"));
	
// 	$order_date_str=$row_order['added_on'];
// 	$order_date_str=strtotime($order_date_str);
// 	$order_date=date('Y-m-d h:i',$order_date_str);
// 	$name=$row_order['name'];
// 	$email=$row_order['email'];
// 	$mobile=$row_order['mobile'];
// 	$address=$row_order['address'];
// 	$pincode=$row_order['pincode'];
// 	$city=$row_order['city'];
	
// 	$length=$row_order['length'];
// 	$breadth=$row_order['breadth'];
// 	$height=$row_order['height'];
// 	$weight=$row_order['weight'];
	
// 	$payment_type=$row_order['payment_type'];
// 	if($payment_type=='payu'){
// 		$payment_type='Prepaid';
// 	}
	

// 	$total_price=$row_order['total_price'];
// 	$res=mysqli_query($con,"select order_detail.*,product.name from order_detail,product where product.id=order_detail.product_id and order_detail.order_id='$order_id'");
// 	$html='';
	
// 	while($row=mysqli_fetch_assoc($res)){
// 		$sku=rand(111111,999999);
// 		$html.='{
// 		  "name": "'.$row['name'].'",
// 		  "sku": "'.$sku.'",
// 		  "units": '.$row['qty'].',
// 		  "selling_price": "'.$row['price'].'",
// 		  "discount": "",
// 		  "tax": "",
// 		  "hsn": ""
// 		},';
// 	}
// 	$html=rtrim($html,",");
	
// 	$curl = curl_init();
// 	  curl_setopt_array($curl, array(
// 		CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
// 		CURLOPT_RETURNTRANSFER => true,
// 		CURLOPT_ENCODING => "",
// 		CURLOPT_MAXREDIRS => 10,
// 		CURLOPT_TIMEOUT => 0,
// 		CURLOPT_FOLLOWLOCATION => true,
// 		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 		CURLOPT_CUSTOMREQUEST => "POST",
// 		CURLOPT_POSTFIELDS =>'{"order_id": "'.$order_id.'",
// 	  "order_date": "'.$order_date.'",
// 	  "pickup_location": "Delhi",
// 	  "billing_customer_name": "'.$name.'",
// 	  "billing_last_name": "",
// 	  "billing_address": "'.$address.'",
// 	  "billing_address_2": "",
// 	  "billing_city": "'.$city.'",
// 	  "billing_pincode": "'.$pincode.'",
// 	  "billing_state": "Delhi",
// 	  "billing_country": "India",
// 	  "billing_email": "'.$email.'",
// 	  "billing_phone": "'.$mobile.'",
// 	  "shipping_is_billing": true,
// 	  "shipping_customer_name": "",
// 	  "shipping_last_name": "",
// 	  "shipping_address": "",
// 	  "shipping_address_2": "",
// 	  "shipping_city": "",
// 	  "shipping_pincode": "",
// 	  "shipping_country": "",
// 	  "shipping_state": "",
// 	  "shipping_email": "",
// 	  "shipping_phone": "",
// 	  "order_items": [
// 		'.$html.'
// 	  ],
// 	  "payment_method": "'.$payment_type.'",
// 	  "shipping_charges": 0,
// 	  "giftwrap_charges": 0,
// 	  "transaction_charges": 0,
// 	  "total_discount": 0,
// 	  "sub_total": "'.$total_price.'",
// 	  "length": '.$length.',
// 	  "breadth": '.$breadth.',
// 	  "height": '.$height.',
// 	  "weight": '.$weight.'
// 		}',
//     CURLOPT_HTTPHEADER => array(
//       "Content-Type: application/json",
// 	   "Authorization: Bearer $token"
//     ),
//   ));
//   $SR_login_Response = curl_exec($curl);
//   curl_close($curl);
//   $SR_login_Response_out = json_decode($SR_login_Response,true);
  
//   if(isset($SR_login_Response_out['order_id']) && isset($SR_login_Response_out['shipment_id'])){
// 	  $ship_order_id=$SR_login_Response_out['order_id'];
// 	  $ship_shipment_id=$SR_login_Response_out['shipment_id'];
// 	  mysqli_query($con,"update `order` set ship_order_id='$ship_order_id', ship_shipment_id='$ship_shipment_id' where id='$order_id'");
// 	  echo "Order id:-".$ship_order_id.'<br/>';
// 	  echo "Shipment id:-".$ship_shipment_id.'<br/>';
//   }else{
// 	  $errroHTML='';
// 	  if(isset($SR_login_Response_out['errors'])){
// 		  foreach($SR_login_Response_out['errors'] as $key=>$val){
// 			  $errroHTML.=$key.' : '.$val[0].'<br/>';
// 		  }
// 	  }else{
// 		  $errroHTML="Shiprocket API: Someting went wrong";
// 	  }
// 	  echo "<div class='shiprocket_error'>".$errroHTML."</div>";
	  
//   }
// }

// function cancelShipRocketOrder($token,$ship_order_id){
// 	$curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS =>"{\n  \"ids\": [".$ship_order_id."]\n}",
//   CURLOPT_HTTPHEADER => array(
//     "Content-Type: application/json",
//     "Authorization: Bearer $token"
//   ),
// ));
// 	$response = curl_exec($curl);
// 	curl_close($curl);
// }


function isAdmin(){
	global $merchant_name;
	if(!isset($_SESSION['ADMIN_LOGIN'])){?>
		<script>
		window.location.href='login.php?merchant_name=<?=$merchant_name?>';
		</script>
	
		
		<?php
	}
	
}
?>

 <!-- if($_SESSION['ADMIN_ROLE']==1){
	 	
		<script>
		window.location.href='product.php';
	 	</script>
	 	
	 } -->