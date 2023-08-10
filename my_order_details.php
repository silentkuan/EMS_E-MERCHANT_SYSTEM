<?php 
require('top.php');

if(!isset($_COOKIE['USER_LOGIN']) || $_COOKIE['USER_LOGIN']==""){
    
	?>
	<script>
	window.location.href='index.php?merchant_name=<?=$merchant_name?>';
	</script>
	<?php
}
if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']!=""){
    checkProfileInformation($con,$_SESSION['USER_LOGIN'],$_SESSION['USER_ID'],$_SESSION['MERCHANT_ID']);}

$order_id=get_safe_value($con,$_GET['order_id']);

$stmt = $con->prepare("SELECT coupon_value, added_on, order_id, payment_status, payment_type, order_status.name as order_status_str 
	FROM `order`, order_status 
	WHERE `order`.order_id = ? AND `order`.merchant_id = ? AND order_status.id = `order`.order_status");
$stmt->bind_param("ss", $order_id, $merchant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $order_details = $result->fetch_assoc()) {
	$coupon_value = $order_details['coupon_value'];
	// Retrieve other data from the $order_details array as needed
}

if($coupon_value==''){
	$coupon_value=0;	
}

?>
<div class="ht__bradcaump__area" style="background: #eee; ">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php?merchant_name=<?=$merchant_name?>">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Thank You for your support</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                <div class=" pb--20">
    <div class="col-md-6"> <h3 style="font-size:18px; font-weight:bold;">Order ID: <?php echo $order_details['order_id']; ?></h3></div>
    
    <div class="col-md-6 text-right"> <h3 style="font-size:18px; font-weight:bold;">Order's Date: <?php echo $order_details['added_on']; ?></h3></div>
    <br>
  </div>
                                    <table>
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
											$uid=$_COOKIE['USER_ID'];
                                            $stmt = $con->prepare("SELECT DISTINCT order_detail.order_id, order_detail.*, product.id AS product_id, product.name, product.image 
                                            FROM order_detail
                                            INNER JOIN product ON order_detail.product_id = product.id
                                            INNER JOIN `order` ON order_detail.order_id = `order`.order_id
                                            WHERE order_detail.order_id = ? AND `order`.user_id = ?");
                                        $stmt->bind_param("ss", $order_id, $uid);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        $total_price = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $total_price += ($row['qty'] * $row['price']);
                                            // Process each row of the result
                                            // You can access the data using $row['column_name']
                                        
                                        
											?>
                                            <tr>
												<td class="font-50"><a href="product.php?id=<?php echo $row['product_id']?>&merchant_name=<?=$merchant_name?>" target=”_blank” ><?php echo $row['name']?><a/></td>
                                                <td class="product-name"> <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$row['image']?>"></td>
												<td class="product-name"><?php echo $row['qty']?></td>
												<td class="product-name">RM<?php echo $row['price']?></td>
												<td class="product-name">RM<?php echo $row['qty']*$row['price']?></td>
                                                
                                            </tr>
                                            <?php } 
											if($coupon_value!='0'){
											?>
											<tr>
												<td colspan="3" ></td>
												<td class="product-name">Coupon Value</td>
												<td class="product-name"><?php echo $coupon_value?></td>
                                                
                                            </tr>
											<?php } ?>
											<tr>
												<td colspan="3" rowspan="4"></td>
												<td class="product-name">Total Price</td>
												<td class="product-name">
												RM<?php 
												echo $total_price-$coupon_value;
												?></td>
                                                
                                            </tr>
                                            <tr>
												
												<td class="product-name">Payment Type</td>
												<td class="product-name">
												<?php 
												echo $order_details['payment_type'];
												?></td>
                                                
                                            </tr>
                                            <tr>
												
												<td class="product-name">Payment Status</td>
												<td class="product-name">
												<?php 
												echo $order_details['payment_status'];
												?></td>
                                                
                                            </tr>
                                            <tr>
												
												<td class="product-name">Order Status</td>
												<td class="product-name">
												<?php 
												echo $order_details['order_status_str'];
												?></td>
                                                
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                    
                                    <a class="fr__btn" href="order_pdf.php?order_id=<?php echo $order_id?>&merchant_name=<?=$merchant_name?>" target="_blank">Download Invoice as PDF</a>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        						
<?php require('footer.php')?>        