<?php
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
if (isset($_GET['merchant_name'])) {
	if(isset($_GET['merchant-admin'])){?>
	<script>
	window.location.href='admin/login.php?merchant_name=<?=$_GET['merchant_name']?>';
	</script>
	<?php
	}
    $merchant_name = get_safe_value($con, $_GET['merchant_name']);

    $get_merchant = "select * from merchant  where merchant_name='$merchant_name'";

    $run_merchant = mysqli_query($con, $get_merchant);
	
	if($run_merchant->num_rows==1){
		$row_merchant = mysqli_fetch_array($run_merchant);

		$merchant_logo = $row_merchant['merchant_logo'];
	
		$merchant_id = $row_merchant['merchant_id'];
	
		$merchant_favicon = $row_merchant['merchant_favicon_logo'];
		$merchant_about_us = $row_merchant['about_us'];
		$merchant_payment_category_code = decrypt($row_merchant['payment_category_code']);
		$merchant_payment_apikey = decrypt($row_merchant['payment_apikey']);
		
	}else{
		?>
	
	<script>
	window.location.href='register_merchant.php';
	</script>
	
	
	<?php	
	}
}else{
	if (!isset($_GET['merchant_name'])) { ?>
	
		<script>
		window.location.href='register_merchant.php';
		</script>
		
		
		<?php	
		}
}


function pr($arr)
{
    echo '<pre>';
    print_r($arr);
}

function prx($arr)
{
    echo '<pre>';
    print_r($arr);
    die();
}

function get_safe_value($con, $str)
{
    if ($str != '') {
        $str = trim($str);
        return mysqli_real_escape_string($con, $str);
    }
}

function get_product($con, $limit = '', $cat_id = '', $product_id = '', $search_str = '',
 $sort_order = '', $is_best_seller = '', $sub_categories = '')
{
    global $merchant_id;
    global $merchant_name;

    $sql = "SELECT product.*, categories.categories FROM product, 
	categories WHERE product.status = 1 AND product.merchant_id = ?";

    $params = [$merchant_id];

    if ($cat_id !== '') {
        $sql .= " AND product.categories_id = ?";
        $params[] = $cat_id;
    }

    if ($product_id !== '') {
        $sql .= " AND product.id = ?";
        $params[] = $product_id;
    }

    if ($sub_categories !== '') {
        $sql .= " AND product.sub_categories_id = ?";
        $params[] = $sub_categories;
    }

    if ($is_best_seller !== '') {
        $sql .= " AND product.best_seller = 1";
    }

    $sql .= " AND product.categories_id = categories.id";

    if ($search_str !== '') {
        $sql .= " AND (product.name LIKE ? OR product.description LIKE ?)";
        $params[] = "%$search_str%";
        $params[] = "%$search_str%";
    }

    if ($sort_order !== '') {
        $sql .= $sort_order;
    } else {
        $sql .= " ORDER BY product.id DESC";
    }

    if ($limit !== '') {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }

    $stmt = $con->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    return $data;
}

function wishlist_add($con, $uid, $pid, $merchant_id)
{
    $added_on = date('Y-m-d h:i:s');
    mysqli_query($con, "insert into wishlist(user_id,product_id,added_on,merchant_id) values('$uid','$pid','$added_on','$merchant_id')");
}

function productPendingByProductId($con, $pid)
{
    global $merchant_id;
    global $merchant_name;

    $sql = "select * from product where id='$pid' ";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['pending_qty'];
}

function productQty($con, $pid)
{
    global $merchant_id;
    global $merchant_name;

    $sql = "select qty from product where id='$pid'  ";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['qty'];
}

function checkProfileInformation($con, $user_login, $uid, $cookies_merchant_id)
{
    global $merchant_id;
    global $merchant_name;
    if ($merchant_id === $cookies_merchant_id) {
        if (isset($user_login) && $user_login != "") {
            $res = mysqli_query($con, "select * from users where uid='$uid' and users.merchant_id='$merchant_id'");
            $check = mysqli_num_rows($res);
            if ($check > 0) {
                $row = mysqli_fetch_assoc($res);
                $name = $row['name'];
                $email = $row['email'];
                $mobile = $row['mobile'];
                $profile_image = $row['profile_image'];
            }
            if ($name == "null" || $email == "null" || $mobile == "null" || $profile_image == "null") { ?>
				<script>
			window.location.href='profile.php?merchant_name=<?= $merchant_name ?>';
			</script>
			<?php }
        }
    } else {
		$_SESSION = array();
		session_destroy();
         ?>
		<script>
			window.location.href='logout.php?merchant_name=<?= $merchant_name ?>';
			</script>
			<?php
    }
}

function sentInvoice($con, $order_id)
{
    global $merchant_id;
    global $merchant_name;

    $res = mysqli_query($con, "select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and order_detail.product_id=product.id ");

    $user_order = mysqli_fetch_assoc(mysqli_query($con, "select `order`.*, users.name,users.email  from `order`,users where users.uid=`order`.user_id and `order`.order_id='$order_id'"));

    $coupon_details = mysqli_fetch_assoc(mysqli_query($con, "select coupon_value from `order` where order_id='$order_id'"));
    $coupon_value = $coupon_details['coupon_value'];
    if ($coupon_value == '') {
        $coupon_value = 0;
    }
    $res_merchant = mysqli_query($con, "select * from merchant where merchant_id='$merchant_id'");
    $check = mysqli_num_rows($res_merchant);
    if ($check > 0) {
        $row_merchant = mysqli_fetch_assoc($res_merchant);
        $address = $row_merchant['address'];
        $email = $row_merchant['email'];
        $mobile = $row_merchant['phone_number'];
        $google_map = $row_merchant['google_map'];
        $google_map_iframe = $row_merchant['google_map_iframe'];
        $whatsapp = $row_merchant['whatsapp_link'];
        $instagram = $row_merchant['instagram_link'];
        $facebook = $row_merchant['facebook_link'];
        $about_us = $row_merchant['about_us'];
        $website = $row_merchant['website_link'];
    }
    $total_price = 0;

    $html =
        '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>
	  <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="x-apple-disable-message-reformatting" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title></title>
		<style type="text/css" rel="stylesheet" media="all">
		/* Base ------------------------------ */
		
		@import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
		body {
		  width: 100% !important;
		  height: 100%;
		  margin: 0;
		  -webkit-text-size-adjust: none;
		}
		
		a {
		  color: #3869D4;
		}
		
		a img {
		  border: none;
		}
		
		td {
		  word-break: break-word;
		}
		
		.preheader {
		  display: none !important;
		  visibility: hidden;
		  mso-hide: all;
		  font-size: 1px;
		  line-height: 1px;
		  max-height: 0;
		  max-width: 0;
		  opacity: 0;
		  overflow: hidden;
		}
		/* Type ------------------------------ */
		
		body,
		td,
		th {
		  font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
		}
		
		h1 {
		  margin-top: 0;
		  color: #333333;
		  font-size: 22px;
		  font-weight: bold;
		  text-align: left;
		}
		
		h2 {
		  margin-top: 0;
		  color: #333333;
		  font-size: 16px;
		  font-weight: bold;
		  text-align: left;
		}
		
		h3 {
		  margin-top: 0;
		  color: #333333;
		  font-size: 14px;
		  font-weight: bold;
		  text-align: left;
		}
		
		td,
		th {
		  font-size: 16px;
		}
		
		p,
		ul,
		ol,
		blockquote {
		  margin: .4em 0 1.1875em;
		  font-size: 16px;
		  line-height: 1.625;
		}
		
		p.sub {
		  font-size: 13px;
		}
		/* Utilities ------------------------------ */
		
		.align-right {
		  text-align: right;
		}
		
		.align-left {
		  text-align: left;
		}
		
		.align-center {
		  text-align: center;
		}
		/* Buttons ------------------------------ */
		
		.button {
		  background-color: #3869D4;
		  border-top: 10px solid #3869D4;
		  border-right: 18px solid #3869D4;
		  border-bottom: 10px solid #3869D4;
		  border-left: 18px solid #3869D4;
		  display: inline-block;
		  color: #FFF;
		  text-decoration: none;
		  border-radius: 3px;
		  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
		  -webkit-text-size-adjust: none;
		  box-sizing: border-box;
		}
		
		.button--green {
		  background-color: #22BC66;
		  border-top: 10px solid #22BC66;
		  border-right: 18px solid #22BC66;
		  border-bottom: 10px solid #22BC66;
		  border-left: 18px solid #22BC66;
		}
		
		.button--red {
		  background-color: #FF6136;
		  border-top: 10px solid #FF6136;
		  border-right: 18px solid #FF6136;
		  border-bottom: 10px solid #FF6136;
		  border-left: 18px solid #FF6136;
		}
		
		@media only screen and (max-width: 500px) {
		  .button {
			width: 100% !important;
			text-align: center !important;
		  }
		}
		/* Attribute list ------------------------------ */
		
		.attributes {
		  margin: 0 0 21px;
		}
		
		.attributes_content {
		  background-color: #F4F4F7;
		  padding: 16px;
		}
		
		.attributes_item {
		  padding: 0;
		}
		/* Related Items ------------------------------ */
		
		.related {
		  width: 100%;
		  margin: 0;
		  padding: 25px 0 0 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		
		.related_item {
		  padding: 10px 0;
		  color: #CBCCCF;
		  font-size: 15px;
		  line-height: 18px;
		}
		
		.related_item-title {
		  display: block;
		  margin: .5em 0 0;
		}
		
		.related_item-thumb {
		  display: block;
		  padding-bottom: 10px;
		}
		
		.related_heading {
		  border-top: 1px solid #CBCCCF;
		  text-align: center;
		  padding: 25px 0 10px;
		}
		/* Discount Code ------------------------------ */
		
		.discount {
		  width: 100%;
		  margin: 0;
		  padding: 24px;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #F4F4F7;
		  border: 2px dashed #CBCCCF;
		}
		
		.discount_heading {
		  text-align: center;
		}
		
		.discount_body {
		  text-align: center;
		  font-size: 15px;
		}
		/* Social Icons ------------------------------ */
		
		.social {
		  width: auto;
		}
		
		.social td {
		  padding: 0;
		  width: auto;
		}
		
		.social_icon {
		  height: 20px;
		  margin: 0 8px 10px 8px;
		  padding: 0;
		}
		/* Data table ------------------------------ */
		
		.purchase {
		  width: 100%;
		  margin: 0;
		  padding: 35px 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		
		.purchase_content {
		  width: 100%;
		  margin: 0;
		  padding: 25px 0 0 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		
		.purchase_item {
		  padding: 10px 0;
		  color: #51545E;
		  font-size: 15px;
		  line-height: 18px;
		}
		
		.purchase_heading {
		  padding-bottom: 8px;
		  border-bottom: 1px solid #EAEAEC;
		}
		
		.purchase_heading p {
		  margin: 0;
		  color: #85878E;
		  font-size: 12px;
		}
		
		.purchase_footer {
		  padding-top: 15px;
		  border-top: 1px solid #EAEAEC;
		}
		
		.purchase_total {
		  margin: 0;
		  text-align: right;
		  font-weight: bold;
		  color: #333333;
		}
		
		.purchase_total--label {
		  padding: 0 15px 0 0;
		}
		
		body {
		  background-color: #F4F4F7;
		  color: #51545E;
		}
		
		p {
		  color: #51545E;
		}
		
		p.sub {
		  color: #6B6E76;
		}
		
		.email-wrapper {
		  width: 100%;
		  margin: 0;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #F4F4F7;
		}
		
		.email-content {
		  width: 100%;
		  margin: 0;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		/* Masthead ----------------------- */
		
		.email-masthead {
		  padding: 25px 0;
		  text-align: center;
		}
		
		.email-masthead_logo {
		  width: 94px;
		}
		
		.email-masthead_name {
		  font-size: 16px;
		  font-weight: bold;
		  color: #A8AAAF;
		  text-decoration: none;
		  text-shadow: 0 1px 0 white;
		}
		/* Body ------------------------------ */
		
		.email-body {
		  width: 100%;
		  margin: 0;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #FFFFFF;
		}
		
		.email-body_inner {
		  width: 570px;
		  margin: 0 auto;
		  padding: 0;
		  -premailer-width: 570px;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #FFFFFF;
		}
		
		.email-footer {
		  width: 570px;
		  margin: 0 auto;
		  padding: 0;
		  -premailer-width: 570px;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  text-align: center;
		}
		
		.email-footer p {
		  color: #6B6E76;
		}
		
		.body-action {
		  width: 100%;
		  margin: 30px auto;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  text-align: center;
		}
		
		.body-sub {
		  margin-top: 25px;
		  padding-top: 25px;
		  border-top: 1px solid #EAEAEC;
		}
		
		.content-cell {
		  padding: 35px;
		}
		/*Media Queries ------------------------------ */
		
		@media only screen and (max-width: 600px) {
		  .email-body_inner,
		  .email-footer {
			width: 100% !important;
		  }
		}
		
		@media (prefers-color-scheme: dark) {
		  body,
		  .email-body,
		  .email-body_inner,
		  .email-content,
		  .email-wrapper,
		  .email-masthead,
		  .email-footer {
			background-color: #333333 !important;
			color: #FFF !important;
		  }
		  p,
		  ul,
		  ol,
		  blockquote,
		  h1,
		  h2,
		  h3 {
			color: #FFF !important;
		  }
		  .attributes_content,
		  .discount {
			background-color: #222 !important;
		  }
		  .email-masthead_name {
			text-shadow: none !important;
		  }
		}
		</style>
		<!--[if mso]>
		<style type="text/css">
		  .f-fallback  {
			font-family: Arial, sans-serif;
		  }
		</style>
	  <![endif]-->
	  </head>
	  <body>
		<span class="preheader">This is an invoice for your purchase on ' .
        $user_order['added_on'] .
        '.</span>
		<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
		  <tr>
			<td align="center">
			  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
				<tr>
				  <td class="email-masthead">
					<a href="' .
        $website .
        '" class="f-fallback email-masthead_name">
					Your Invoice from ' .
        $merchant_name .
        ' 
				  </a>
				  </td>
				</tr>
				<!-- Email Body -->
				<tr>
				  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
					<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
					  <!-- Body content -->
					  <tr>
						<td class="content-cell">
						  <div class="f-fallback">
							<h1>Hi ' .
        $user_order['name'] .
        ',</h1>
							<p>Thanks for using our website. This is an invoice for your recent purchase.</p>
							<table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
							  <tr>
								<td class="attributes_content">
								  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
									<tr>
									  <td class="attributes_item">
										<span class="f-fallback">
				  <strong>Amount Due:</strong> RM ' .
        $user_order['total_price'] .
        '
				</span>
									  </td>
									</tr>
								   
								  </table>
								</td>
							  </tr>
							</table>
							<!-- Action -->
							
							<table class="purchase" width="100%" cellpadding="0" cellspacing="0">
							  <tr>
								<td width="50%">
								  <h3>' .
        $user_order['order_id'] .
        '</h3>
								</td>
								<td width="50%">
								  <h3 class="align-right">' .
        $user_order['added_on'] .
        '</h3>
								</td>
							  </tr>
							  <tr>
								<td colspan="2">
								  <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
									<tr>
									  <th class="purchase_heading" align="left">
										<p class="f-fallback">Description</p>
									  </th>
									  <th class="purchase_heading" align="right">
										<p class="f-fallback">Amount</p>
									  </th>
									</tr>
                                    <br>
                                    <hr>
									<h4>Invoice Details </h4>
                                    <br>';
    while ($row = mysqli_fetch_assoc($res)) {
        $total_price = $total_price + $row['qty'] * $row['price'];
        $pp = $row['qty'] * $row['price'];
        $html .=
            '<tr>
										  <td width="80%" class="purchase_item"><span class="f-fallback">' .
            $row['name'] .
            '</span></td>
										  <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">' .
            $pp .
            '</span></td>
										</tr>
                                        <tr>
                                        <td>
                                        <img src="' .
            PATH .
            PRODUCT_IMAGE_SITE_PATH .
            $row['image'] .
            '" class="img-fluid img-thumbnail" alt="Profile Picture" style="width:50px;">
                                       </td> </tr>
                                        
                                       ';
    }

    if ($coupon_value != '') {
        $html .=
            ' <td width="70%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total purchase_total--label">Coupon Value</p>
									  </td>
									  <td width="30%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total">' .
            $coupon_value .
            '</p>
									  </td>
									</tr>';
    }
    $total_price = $total_price - $coupon_value;
    $html .=
        '<tr>
									  <td width="70%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total purchase_total--label">Total</p>
									  </td>
									  <td width="30%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total">' .
        $total_price .
        '</p>
									  </td>
									</tr>
									<tr>
									<td width="70%" class="purchase_footer" valign="middle">
									  <p class="f-fallback purchase_total purchase_total--label">Payment Type</p>
									</td>
									<td width="30%" class="purchase_footer" valign="middle">
									  <p class="f-fallback purchase_total">' .
        $user_order['payment_type'] .
        '</p>
									</td>
								  </tr>
                                    <tr>
									  <td width="70%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total purchase_total--label">Payment Status</p>
									  </td>
									  <td width="30%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total">' .
        $user_order['payment_status'] .
        '</p>
									  </td>
									</tr>
								  </table>
								</td>
							  </tr>
							</table>
							
							<p>Cheers,
							  <br>The Sales Team from ' .
        $merchant_name .
        ' </p>
							<!-- Sub copy -->
							
						  </div>
						</td>
					  </tr>
					</table>
				  </td>
				</tr>
				<tr>
				  
				</tr>
			  </table>
			</td>
		  </tr>
		</table>
		<table class="email-footer" align="center" cellpadding="0" cellspacing="0" role="presentation">
					  <tr>
						<td class="content-cell" align="center">
						  <p class="f-fallback sub align-center">&copy; ' .
        date("Y") .
        '. ' .
        $merchant_name .
        '. All rights reserved.</p>
						  <p class="f-fallback sub align-center">
                          ' .
        $merchant_name .
        ' 
							<br>' .
        $address .
        '
							
						  </p>
						</td>
					  </tr>
					</table>
	  </body>
	</html>';

    include 'smtp/PHPMailerAutoload.php';
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_EMAIL;
    $mail->Password = SMTP_PASSWORD;
    $mail->SetFrom(SMTP_EMAIL);
    $mail->addAddress($user_order['email']);
    $mail->IsHTML(true);
    $mail->Subject = "Invoice Details";
    $mail->Body = $html;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false,
        ],
    ];
    if ($mail->send()) {
        //echo "Please check your email id for password";
    } else {
        //echo "Error occur";
    }
}
?>
