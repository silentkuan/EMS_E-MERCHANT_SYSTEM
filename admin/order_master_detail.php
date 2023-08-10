<?php
require "functions.inc.php";
isadmin();
require('top.inc.php');
$order_id = get_safe_value($con, $_GET['order_id']);
$stmt = $con->prepare("SELECT coupon_value, coupon_code FROM `order` WHERE order_id = ?");
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$coupon_details = $result->fetch_assoc();
$stmt->close();


$coupon_value = $coupon_details['coupon_value'];
if ($coupon_value == '') {
    $coupon_value = 0;
}
$coupon_code = $coupon_details['coupon_code'];
if (isset($_POST['update_order_status'])) {
    $update_order_status = $_POST['update_order_status'];

	$stmt = $con->prepare("UPDATE `order` SET order_status=?, payment_status='Paid' WHERE order_id=?");
	$stmt->bind_param("is", $update_order_status, $order_id);
	$stmt->execute();
	
	

$update_qty_stmt = $con->prepare("SELECT DISTINCT (order_detail.order_id), order_detail.*, product.name, product.image, `order`.address, `order`.city, `order`.pincode
FROM order_detail
INNER JOIN product ON order_detail.product_id = product.id
INNER JOIN `order` ON order_detail.order_id = `order`.order_id
WHERE order_detail.order_id = ? ");
	$update_qty_stmt->bind_param("s", $order_id);
	$update_qty_stmt->execute();
	$update_qty_result = $update_qty_stmt->get_result();
	
	while ($row_update_qty = $update_qty_result->fetch_assoc()) {
		$qty = $row_update_qty['qty'];
		$key = $row_update_qty['product_id'];
		$update_product_stmt = $con->prepare("UPDATE `product` SET sales_qty = sales_qty + ?, qty = qty - ?,pending_qty = pending_qty - ? WHERE id = ?");
		$update_product_stmt->bind_param("iiii", $qty, $qty,$qty, $key);
		$update_product_stmt->execute();
	}
	


    // if($update_order_status==3){
    // 	$token=validShipRocketToken($con);
    // 	if($token!=''){
    // 		placeShipRocketOrder($con,$token,$order_id);
    // 	}
    // }

    // if($update_order_status==4){
    // 	$ship_order=mysqli_fetch_assoc(mysqli_query($con,"select ship_order_id from `order` where id='$order_id'"));
    // 	if($ship_order['ship_order_id']>0){
    // 		$token=validShipRocketToken($con);
    // 		cancelShipRocketOrder($token,$ship_order['ship_order_id']);
    // 	}
    // }
}
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Order Detail </h4>
				   <h7 >Order Id: <?php echo $order_id; ?></h7>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
								<thead>
									<tr>
										<th class="product-thumbnail">Product Name</th>
										<th class="product-thumbnail">Product Image</th>
										<th class="product-name">Qty</th>
										<th class="product-price">Price</th>
										<th class="product-price">Total Price</th>
									</tr>
								</thead>
								<tbody>
									<?php
									
		//$stmt = $con->prepare("select distinct(order_detail.order_id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id=? and order_detail.product_id=product.id");
         $stmt = $con->prepare("SELECT (order_detail.order_id), order_detail.*, product.name, product.image, `order`.address, `order`.city, `order`.pincode FROM order_detail, product, `order` WHERE order_detail.order_id = ? AND order_detail.product_id = product.id GROUP BY order_detail.product_id");
		$stmt->bind_param("s", $order_id);
		$stmt->execute();
		$res = $stmt->get_result();
		$stmt->close();
		
         $total_price = 0;
         while ($row = mysqli_fetch_assoc($res)) {

			$stmt = $con->prepare("SELECT * FROM `order` WHERE order_id = ?");
			$stmt->bind_param("s", $order_id);
			$stmt->execute();
			$res1 = $stmt->get_result();
			$userInfo = mysqli_fetch_assoc($res1);
			$stmt->close();
			

             $address = $userInfo['address'];
             $city = $userInfo['city'];
             $pincode = $userInfo['pincode'];
			 $phonenumber= $userInfo['phone_number'];

             $total_price = $total_price + $row['qty'] * $row['price'];
             ?>
									<tr>
										<td class="product-name"><?php echo $row['name']; ?></td>
										<td class="product-name"> <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image']; ?>"></td>
										<td class="product-name"><?php echo $row['qty']; ?></td>
										<td class="product-name"><?php echo $row['price']; ?></td>
										<td class="product-name"><?php echo $row['qty'] * $row['price']; ?></td>
										
									</tr>
									<?php
         }
         if (!empty($coupon_value)) { ?>
									<tr>
										<td colspan="3"></td>
										<td class="product-name">Coupon Value</td>
										<td class="product-name">
										<?php echo $coupon_value . "($coupon_code)"; ?></td>
										
									</tr>
									<?php }
         ?>
									<tr>
										<td colspan="3"></td>
										<td class="product-name">Total Price</td>
										<td class="product-name"><?php echo $total_price - $coupon_value; ?></td>
										
									</tr>
								</tbody>
							
						</table>
						<div id="address_details">
							<strong>Address:</strong>
							<?php echo $address; ?>, <?php echo $city; ?>, <?php echo $pincode; ?><br/><br/>
							<strong>Mobile Number:</strong>
							<?php echo $phonenumber ?><br/><br/>
							<strong>Order Status: </strong>
							<?php
       $stmt = $con->prepare("SELECT order_status.name, order_status.id AS order_status FROM order_status, `order` WHERE `order`.order_id = ? AND `order`.order_status = order_status.id");
	   $stmt->bind_param("s", $order_id);
	   $stmt->execute();
	   $res = $stmt->get_result();
	   $order_status_arr = mysqli_fetch_assoc($res);
	   $stmt->close();
	   $order_status=$order_status_arr['name'];

       echo $order_status;
       echo "<br><br>";
       ?>
							
							<div>
								<form method="post">
								<?php if($order_status!="Complete"){ ?>
								<select class="form-control mb-1" name="update_order_status"  required>
										<option value="">Select Status</option>
										<?php
          $res = mysqli_query($con, "select * from order_status");
          while ($row = mysqli_fetch_assoc($res)) {
              echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
          }
          ?>
									</select>
									
									<!-- <div id="shipped_box" style="display:none">
										<table>
											<tr>
												<td><input type="text" class="form-control" name="length" placeholder="length"/></td>
												<td><input type="text" class="form-control" name="breadth" placeholder="Breadth"/></td>
												<td><input type="text" class="form-control" name="height" placeholder="height"/></td>
												<td><input type="text" class="form-control" name="weight" placeholder="weight"/></td>
											</tr>
										</table>
									</div> -->
									
									<input type="submit" class="form-control"/>
									<?php } ?>
								</form>
							</div>
						</div>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>

<?php require 'footer.inc.php';
?>
