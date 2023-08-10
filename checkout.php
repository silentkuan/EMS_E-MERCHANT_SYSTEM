<?php


require 'top.php';
define("SHOWERROR", "NO");
// define("PATH", $http.$_SERVER["HTTP_HOST"]."/");
define("PAYMENTURL", 'https://dev.toyyibpay.com/');
define("SECRETKEY", $merchant_payment_apikey);
define("CATEGORYCODE", $merchant_payment_category_code);
// if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']!=""){
//     checkProfileInformation($con,$_COOKIE['USER_LOGIN'],$_COOKIE['USER_ID'],$_COOKIE['MERCHANT_ID']);}
if (!empty($_GET['order_id']) && !empty($_GET['status_id']) && !empty($_GET['billcode']) && !empty($_GET['transaction_id'])) {
    $order_id = get_safe_value($con, $_GET['order_id']);
    $status_id = get_safe_value($con, $_GET['status_id']);
    $billcode = get_safe_value($con, $_GET['billcode']);
    $transaction_id = get_safe_value($con, $_GET['transaction_id']);

    switch ($status_id) {
        case 1:
            $status = "Paid";
            break;
        case 2:
            $status = 'Pending';
            break;
        default:
            $status = "Unpaid";
            break;
    }
    if (!empty($billcode)) { ?>
	<?php
 $stmt = $con->prepare("UPDATE `order` SET txnid=?, payment_status=?, billcode=? WHERE order_id=?");
 $stmt->bind_param("sssi", $transaction_id, $status, $billcode, $order_id);

 if ($stmt->execute()) {

     unset($_SESSION['cart']);
     if ($status == "Unpaid") { ?>
		<script>
			
			window.location.href='sorry.php?merchant_name=<?= $merchant_name ?>';
			
		</script>
		<?php } else {sentInvoice($con, $order_id); ?>
			<script>
			
			window.location.href='thank_you.php?merchant_name=<?= $merchant_name ?>';
			
		</script>
		<?php }
     ?>
	<?php
 } else {
     unset($_SESSION['cart']); ?>
		<script>
			window.location.href='sorry.php?merchant_name=<?= $merchant_name ?>';
		</script>
<?php
 }

 $stmt->close();
 }
}
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) { ?>
	<script>
		window.location.href='index.php?merchant_name=<?= $merchant_name ?>';
	</script>
	<?php }

$cart_total = 0;
$errMsg = "";
$stmt = $con->prepare("SELECT * FROM users WHERE uid = ? AND merchant_id = ?");
$stmt->bind_param("si", $_COOKIE['USER_ID'], $merchant_id);
$stmt->execute();
$res = $stmt->get_result();
$check = mysqli_num_rows($res);
$stmt->close();

if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $profile_image = $row['profile_image'];
		$address = $row['address'];
        $mobile = $row['mobile'];
		$stateNcity = $row['stateNcity'];
		$postcode = $row['postcode'];
}
if (isset($_POST['submit'])) {
    $address = get_safe_value($con, $_POST['address']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $city = get_safe_value($con, $_POST['city']);
    $pincode = get_safe_value($con, $_POST['pincode']);
    $payment_type = get_safe_value($con, $_POST['payment_type']);
    $user_id = $_COOKIE['USER_ID'];
    foreach ($_SESSION['cart'] as $key => $val) {
        $productArr = get_product($con, '', '', $key);
        $price = $productArr[0]['price'];
        $qty = $val['qty'];
        $cart_total = $cart_total + $price * $qty;
    }
    $total_price = $cart_total;
    $payment_status = 'Pending';
    if ($payment_type == 'cod') {
        $payment_status = 'success';
    }
    $order_status = '1';
    $added_on = date('Y-m-d h:i:s');

    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

    if (isset($_SESSION['COUPON_ID'])) {
        $coupon_id = $_SESSION['COUPON_ID'];
        $coupon_code = $_SESSION['COUPON_CODE'];
        $coupon_value = $_SESSION['COUPON_VALUE'];
        $total_price = $total_price - $coupon_value;
        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_CODE']);
        unset($_SESSION['COUPON_VALUE']);
    } else {
        $coupon_id = '';
        $coupon_code = '';
        $coupon_value = '';
    }
    $create_order_id = rand(1, 10) . date("Ymdhis");
    $query = "INSERT INTO `order` (order_id, user_id, address, city, pincode,phone_number, payment_type, payment_status, order_status, 
	added_on, total_price, txnid, coupon_id, coupon_code, coupon_value, merchant_id,billcode) 
	VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?,'null')";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssssssssdssdss", $create_order_id, $user_id, $address, $city, $pincode,$mobile, $payment_type, 
    $payment_status, $order_status, $added_on, $total_price, $txnid, $coupon_id, $coupon_code, $coupon_value, $merchant_id);
    $stmt->execute();

    $order_get_id = mysqli_insert_id($con);

    $query = "SELECT * FROM `order` WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $order_get_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        $order_id = $order['order_id'];
        // Process the order data as needed
    }
    foreach ($_SESSION['cart'] as $key => $val) {
        $productArr = get_product($con, '', '', $key);
        $price = $productArr[0]['price'];
        $qty = $val['qty'];

        $query1 = "INSERT INTO `order_detail` (order_id, product_id, qty, price, merchant_id) VALUES (?, ?, ?, ?, ?)";
        $stmt1 = $con->prepare($query1);
        $stmt1->bind_param("sssss", $create_order_id, $key, $qty, $price, $merchant_id);
        $stmt1->execute();

        $query2 = "UPDATE `product` SET `pending_qty` = `pending_qty` + ? WHERE id = ?";
        $stmt2 = $con->prepare($query2);
        $stmt2->bind_param("ii", $qty, $key);
        $stmt2->execute();

        $stmt1->close();
        $stmt2->close();
    }

    if ($payment_type == 'Online Banking') {
        $query = "SELECT * FROM users WHERE uid = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $userArr = $result->fetch_assoc();

        $stmt->close();

        // print_r($userArr);exit;
        $some_data = [
            'userSecretKey' => SECRETKEY,
            'categoryCode' => CATEGORYCODE,
            'billName' => 'Payment for KJY',
            'billDescription' => 'Payment for KJY',
            'billPriceSetting' => 1,
            'billPayorInfo' => 0,
            'billAmount' => $total_price * 100,
            'billReturnUrl' => "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'billCallbackUrl' => "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'billExternalReferenceNo' => $order_id,
            'billTo' => $userArr['name'],
            'billEmail' => $userArr['email'],
            'billPhone' => $userArr['mobile'],
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => '0',
            'billContentEmail' => 'Thank you for purchasing our product!',
            'billChargeToCustomer' => 1,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, PAYMENTURL . 'index.php/api/createBill');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $obj = json_decode($result, true);

        if (!empty($obj[0]['BillCode'])) { ?>
				<script type="text/javascript">
    //redirect to payment gateway
   window.location.href="https://dev.toyyibpay.com/<?php echo $obj[0]['BillCode']; ?>"; 
 </script>
				
			<?php }
    } else {

        sentInvoice($con, $order_id);
        unset($_SESSION['cart']);
        ?>
		<script>
			window.location.href='thank_you.php?merchant_name=<?= $merchant_name ?>';
		</script>
		<?php
    }
}
?>

<div class="ht__bradcaump__area" style="background: #eee">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php?merchant_name=<?= $merchant_name ?>">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="checkout-wrap ptb--100">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
						<?php echo $errMsg; ?>
                        <div class="checkout__inner">
                            <div class="accordion-list">
                                <div class="accordion">
                                    
									<?php
         $accordion_class = 'accordion__title';

         if (!isset($_COOKIE['USER_LOGIN']) || $_COOKIE['USER_LOGIN'] == "") { ?>
									<div class="alert alert-danger" id="alert" role="alert"  >Please login or register your account. </div>
                                    <script>
	window.location.href='login.php?merchant_name=<?=$merchant_name?>';
	</script>
									<?php
                               
                                }
         ?><form method="post">
                                    <div class="<?php echo $accordion_class; ?>">
                                        Address Information
                                    </div>
									
										<div class="accordion__body">
											<div class="bilinfo">
												
													<div class="row">
														<div class="col-md-12">
															<div class="single-input">
																<input type="text" name="address" placeholder="Street Address: 11, TAMAN JUNID" value="<?php if ($address != "null" && $address != "") {
                   echo $address;
           } ?>" required>
															</div>
														</div>
														<div class="col-md-6">
															<div class="single-input">
																<input type="text" name="city" placeholder="City/State: MUAR, JOHOR." value="<?php if ($stateNcity != "null" && $stateNcity != "") {
                   echo $stateNcity;
           } ?>" required>
															</div>
														</div>
														<div class="col-md-6">
															<div class="single-input">
																<input maxlength="5" type="text" name="pincode" placeholder="Postcode: 84000 " value="<?php if ($postcode != "null" && $postcode != "") {
                   echo $postcode;
           } ?>" required>
															</div>
														</div>
                                                        <div class="col-md-12">
															<div class="single-input">
																<input type="text" name="mobile" placeholder="60123456789" value="<?php if ($mobile != "null" && $mobile != "") {
                   echo $mobile;
           } ?>" required>
															</div>
														</div>
														
													</div>
												
											</div>
										</div>
										<div class="<?php echo $accordion_class; ?>">
											payment information
										</div>
										<div class="accordion__body">
											<div class="paymentinfo">
												<div class="single-method">
													COD <input type="radio" name="payment_type" value="COD" required/>
                                                    <?php 
                                                    if($merchant_payment_apikey){
                                                        if($merchant_payment_category_code){ ?>
                                                            &nbsp;&nbsp;Online Banking (FPX) 
                                                    <input type="radio" name="payment_type" value="Online Banking" required/>
                                                    <?php    }
                                                    }
													?>
												</div>
												<div class="single-method">
												  
												</div>
											</div>
										</div>
										 <input type="submit" name="submit" class="fv-btn"/>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="order-details">
                            <h5 class="order-details__title">Your Order</h5>
                            <div class="order-details__item">
                                <?php
                                $cart_total = 0;
                                foreach ($_SESSION['cart'] as $key => $val) {

                                    $productArr = get_product($con, '', '', $key);
                                    $pid = $productArr[0]['id'];
                                    $pname = $productArr[0]['name'];
                                    $mrp = $productArr[0]['mrp'];
                                    $price = $productArr[0]['price'];
                                    $image = $productArr[0]['image'];
                                    $qty = $val['qty'];
                                    $cart_total = $cart_total + $price * $qty;
                                    ?>
								<div class="single-item">
                                    <div class="single-item__thumb">
                                        <img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $image; ?>"  />
                                    </div>
                                    <div class="single-item__content">
                                        <a href="product.php?id=<?= $pid ?>&merchant_name=<?= $merchant_name ?>"><?php echo $pname; ?></a>
										<span ><?php echo "x" . $qty; ?></span>
                                        <span class="price">RM<?php echo $price * $qty; ?></span>
                                    </div>
                                    <div class="single-item__remove">
                                        <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key; ?>','remove')"><i class="icon-trash icons"></i></a>
                                    </div>
                                </div>
								<?php
                                }
                                ?>
                            </div>
							<div class="ordre-details__total" id="coupon_box">
                                <h5>Coupon Value</h5>
                                <span class="price" id="coupon_price"></span>
                            </div>
                            <div class="ordre-details__total">
                                <h5>Order total</h5>
                                <span class="price" id="order_total_price">RM<?php echo $cart_total; ?></span>
                            </div>
							
							<div class="ordre-details__total bilinfo">
                                <input type="textbox" id="coupon_str" class="coupon_style mr5"/> <input type="button" name="submit" class="fv-btn coupon_style" value="Apply Coupon" onclick="set_coupon('<?= $merchant_name ?>')"/>
								
                            </div>
							<div id="coupon_result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
			function set_coupon(merchant_name){
				var coupon_str=jQuery('#coupon_str').val();
				if(coupon_str!=''){
					jQuery('#coupon_result').html('');
					jQuery.ajax({
						url:'set_coupon.php?merchant_name='+merchant_name,
						type:'post',
						data:'coupon_str='+coupon_str,
						success:function(result){
							var data=jQuery.parseJSON(result);
							if(data.is_error=='yes'){
								jQuery('#coupon_box').hide();
								jQuery('#coupon_result').html(data.dd);
								jQuery('#order_total_price').html(data.result);
							}
							if(data.is_error=='no'){
								jQuery('#coupon_box').show();
								jQuery('#coupon_price').html(data.dd);
								jQuery('#order_total_price').html(data.result);
							}
						}
					});
				}
			}
		</script>		
<?php
if (isset($_SESSION['COUPON_ID'])) {
    unset($_SESSION['COUPON_ID']);
    unset($_SESSION['COUPON_CODE']);
    unset($_SESSION['COUPON_VALUE']);
}
require 'footer.php';
?>        