<?php
require('connection.inc.php');
require('functions.inc.php');
include('vendor/autoload.php');

// if(!$_SESSION['ADMIN_LOGIN']){
// 	if(!isset($_SESSION['USER_ID'])){
// 		die();
// 	}
// }

$order_id=get_safe_value($con,$_GET['order_id']);

$order_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value,added_on, order_id, payment_status, payment_type, order_status.name as order_status_str from `order`, order_status where `order`.order_id='$order_id' and `order`.merchant_id='$merchant_id' and order_status.id=`order`.order_status"));
$coupon_value=$order_details['coupon_value'];
if($coupon_value==''){
	$coupon_value=0;	
}

// $css=file_get_contents('style.css');
$css=file_get_contents('css/style.mpdf.css');

$html='
<div style="text-align:center; font-size:14px;">
<span >Your invoice: '.$order_details['order_id'].'<span></div>
<br>
<div style="text-align:center; font-size:14px;">
<span >Order\'s date: '.$order_details['added_on'].'<span><div>
<br>
<div class="wishlist-table table-responsive">
<table >
<thead>
	<tr class="font-50" >
           
            <th class="product-thumbnail">Product Image</th>
			<th class="product-thumbnail">Product Name</th>
            <th class="product-name">Qty</th>
            <th class="product-price">Price</th>
            <th class="product-price">Total Price</th>
         </tr>
      </thead>
      <tbody>';
		
		if(isset($_SESSION['ADMIN_LOGIN'])){
			$res=mysqli_query($con,"select distinct(order_detail.order_id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and order_detail.product_id=product.id");
		}else{
			$uid=$_COOKIE['USER_ID'];
			$res=mysqli_query($con,"select distinct(order_detail.order_id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and `order`.user_id='$uid' and order_detail.product_id=product.id");
		}
		
		$total_price=0;
		if(mysqli_num_rows($res)==0){
			die();
		}
		while($row=mysqli_fetch_assoc($res)){
		$total_price=$total_price+($row['qty']*$row['price']);
		 $pp=$row['qty']*$row['price'];
         $html.='<tr>
            
            <td class="product-name"> <img src="'.PRODUCT_IMAGE_SITE_PATH.$row['image'].'" class="img-pdf"></td>
			<td class="product-name">'.$row['name'].'</td>
            <td class="product-name">'.$row['qty'].'</td>
            <td class="product-name">'.$row['price'].'</td>
            <td class="product-name">'.$pp.'</td>
         </tr>';
		 }
		 
		if($coupon_value!='0'){								
			$html.='<tr>
				<td colspan="3"></td>
				<td class="product-name">Coupon Value</td>
				<td class="product-name">'.$coupon_value.'</td>
				
			</tr>';
		}
		 
		 $total_price=(float)$total_price-(float)$coupon_value;
		 $html.='<tr>
		 <td colspan="3" rowspan="4"></td>
				<td class="product-name">Total Price</td>
				<td class="product-name">'.$total_price.'</td>
				
			</tr>
			<tr>
				
				<td class="product-name">Payment Type</td>
				<td class="product-name">'.$order_details['payment_type'].'</td>
				
			</tr>
			<tr>
				
				<td class="product-name">Payment Status</td>
				<td class="product-name">'.$order_details['payment_status'].'</td>
				
			</tr>
			<tr>
				
				<td class="product-name">Oder Status</td>
				<td class="product-name">'.$order_details['order_status_str'].'</td>
				
			</tr>
			';
		 
      $html.='</tbody>
   </table>
</div>';
$mpdf=new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
date_default_timezone_set("Asia/Kuala_Lumpur");
$file=$order_id.'-'.date("Y-m-d h:i:sa").'.pdf';
// Send HTTP response headers
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');


$mpdf->Output($file,'I');
?>
