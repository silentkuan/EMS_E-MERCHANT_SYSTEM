<?php
require "functions.inc.php";
isAdmin();
require('top.inc.php');
$merchantName = '';
$merchantLogo = '';
$aboutUs = '';
$address = '';
$googleMap = '';
$email = '';
$phoneNumber = '';
$paymentApiKey = '';
$paymentCategoryCode = '';
$merchantFaviconLogo = '';
$googleMapIframe = '';
$facebookLink = '';
$whatsappLink = '';
$instagramLink = '';
$websiteLink = '';
$msg = "";
// $merchant_id = 2;
$image_required = 'required';

$image_required = '';
$stmt = mysqli_prepare($con, "SELECT * FROM merchant where merchant_id = ?");
mysqli_stmt_bind_param($stmt, "s", $merchant_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$check = mysqli_num_rows($result);

mysqli_stmt_close($stmt);

if ($check > 0) {
    $row = mysqli_fetch_assoc($result);
    $merchantName = $row['merchant_name'];
    $merchantLogo = $row['merchant_logo'];
    $aboutUs = $row['about_us'];
    $address = $row['address'];
    $googleMap = $row['google_map'];
    $email = $row['email'];
    $phoneNumber = $row['phone_number'];
    $paymentApiKey = $row['payment_apikey'];
    $paymentCategoryCode = $row['payment_category_code'];
    $merchantFaviconLogo = $row['merchant_favicon_logo'];
    $googleMapIframe = $row['google_map_iframe'];
    $facebookLink = $row['facebook_link'];
    $whatsappLink = $row['whatsapp_link'];
    $instagramLink = $row['instagram_link'];
    $websiteLink = $row['website_link'];
} else {
    echo "<script>location.href='manage_merchant.php?merchant_name=$merchant_name'</script>";

    die();
}

if (isset($_POST['submit'])) {
    $merchantName = get_safe_value($con, $_POST['merchant_name']);
    $aboutUs = get_safe_value($con, $_POST['about_us']);
    $address = get_safe_value($con, $_POST['address']);
    $googleMap = get_safe_value($con, $_POST['google_map']);
    $email = get_safe_value($con, $_POST['email']);
    $phoneNumber = get_safe_value($con, $_POST['phone_number']);
    $paymentApiKey = get_safe_value($con, $_POST['payment_apikey']);
    $paymentCategoryCode = get_safe_value($con, $_POST['payment_category_code']);
    $googleMapIframe = get_safe_value($con, $_POST['google_map_iframe']);
    $facebookLink = get_safe_value($con, $_POST['facebook_link']);
    $whatsappLink = get_safe_value($con, $_POST['whatsapp_link']);
    $instagramLink = get_safe_value($con, $_POST['instagram_link']);
    $websiteLink = get_safe_value($con, $_POST['website_link']);
    // $merchant_id=2;
    // Update the merchant details in the database
    // $stmt = mysqli_prepare($con, "UPDATE merchant SET merchant_name=?, about_us=?, address=?, google_map=?,
    //  email=?, phone_number=?, payment_apikey=?, payment_category_code=?, google_map_iframe=?, facebook_link=?,
    //   whatsapp_link=?, instagram_link=?, website_link=? WHERE merchant_id=?");

    // mysqli_stmt_bind_param($stmt, "sssssssssssssi", $merchantName, $aboutUs, $address, $googleMap, $email,
    //  $phoneNumber, $paymentApiKey, $paymentCategoryCode, $googleMapIframe, $facebookLink, $whatsappLink,
    //   $instagramLink, $websiteLink, $merchant_id);

    //  // Execute the statement
    //  mysqli_stmt_execute($stmt);

    //  // Close the statement
    //  mysqli_stmt_close($stmt);
    if ($_FILES['merchantLogo']['name'] != '' && $_FILES['merchantFaviconLogo']['name'] != '') {
        $imagemerchantLogo = rand(111111111, 999999999) . '_' . $_FILES['merchantLogo']['name'];
        move_uploaded_file($_FILES['merchantLogo']['tmp_name'], '../media/logo/' . $imagemerchantLogo);
        $imagemerchantFaviconLogo = rand(111111111, 999999999) . '_' . $_FILES['merchantFaviconLogo']['name'];
        move_uploaded_file($_FILES['merchantFaviconLogo']['tmp_name'], '../media/logo/' . $imagemerchantFaviconLogo);

        $stmt = mysqli_prepare(
            $con,
            "UPDATE merchant SET merchant_name=?, about_us=?, address=?, google_map=?,
                email=?, phone_number=?, payment_apikey=?, payment_category_code=?, google_map_iframe=?, facebook_link=?,
                whatsapp_link=?, instagram_link=?, website_link=?, merchant_logo=?, merchant_favicon_logo=? WHERE merchant_id=?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssssi",
            $merchantName,
            $aboutUs,
            $address,
            $googleMap,
            $email,
            $phoneNumber,
            encrypt($paymentApiKey),
            encrypt($paymentCategoryCode),
            htmlentities($googleMapIframe),
            $facebookLink,
            $whatsappLink,
            $instagramLink,
            $websiteLink,
            $imagemerchantLogo,
            $imagemerchantFaviconLogo,
            $merchant_id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // Check if only merchant logo is present
    elseif ($_FILES['merchantLogo']['name'] != '') {
        $imagemerchantLogo = rand(111111111, 999999999) . '_' . $_FILES['merchantLogo']['name'];
        move_uploaded_file($_FILES['merchantLogo']['tmp_name'], '../media/logo/' . $imagemerchantLogo);

        $stmt = mysqli_prepare(
            $con,
            "UPDATE merchant SET merchant_name=?, about_us=?, address=?, google_map=?,
                email=?, phone_number=?, payment_apikey=?, payment_category_code=?, google_map_iframe=?, facebook_link=?,
                whatsapp_link=?, instagram_link=?, website_link=?, merchant_logo=? WHERE merchant_id=?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssi",
            $merchantName,
            $aboutUs,
            $address,
            $googleMap,
            $email,
            $phoneNumber,
            encrypt($paymentApiKey),
            encrypt($paymentCategoryCode),
            htmlentities($googleMapIframe),
            $facebookLink,
            $whatsappLink,
            $instagramLink,
            $websiteLink,
            $imagemerchantLogo,
            $merchant_id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // Check if only favicon logo is present
    elseif ($_FILES['merchantFaviconLogo']['name'] != '') {
        $imagemerchantFaviconLogo = rand(111111111, 999999999) . '_' . $_FILES['merchantFaviconLogo']['name'];
        move_uploaded_file($_FILES['merchantFaviconLogo']['tmp_name'], '../media/logo/' . $imagemerchantFaviconLogo);

        $stmt = mysqli_prepare(
            $con,
            "UPDATE merchant SET merchant_name=?, about_us=?, address=?, google_map=?,
                email=?, phone_number=?, payment_apikey=?, payment_category_code=?, google_map_iframe=?, facebook_link=?,
                whatsapp_link=?, instagram_link=?, website_link=?, merchant_favicon_logo=? WHERE merchant_id=?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssssi",
            $merchantName,
            $aboutUs,
            $address,
            $googleMap,
            $email,
            $phoneNumber,
            encrypt($paymentApiKey),
            encrypt($paymentCategoryCode),
            htmlentities($googleMapIframe),
            $facebookLink,
            $whatsappLink,
            $instagramLink,
            $websiteLink,
            $imagemerchantFaviconLogo,
            $merchant_id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // No logo or favicon logo present
    else {
        $stmt = mysqli_prepare(
            $con,
            "UPDATE merchant SET merchant_name=?, about_us=?, address=?, google_map=?,
                email=?, phone_number=?, payment_apikey=?, payment_category_code=?, google_map_iframe=?, facebook_link=?,
                whatsapp_link=?, instagram_link=?, website_link=? WHERE merchant_id=?"
        );
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssi",
            $merchantName,
            $aboutUs,
            $address,
            $googleMap,
            $email,
            $phoneNumber,
            encrypt($paymentApiKey),
            encrypt($paymentCategoryCode),
            htmlentities($googleMapIframe),
            $facebookLink,
            $whatsappLink,
            $instagramLink,
            $websiteLink,
            $merchant_id
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    echo "<script>location.href='manage_merchant.php?merchant_name=$merchantName'</script>";
    die();
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Edit Merchant Detai1s</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
                            <div class="form-group">
    <label for="merchantName" class="form-control-label">Merchant Name</label>
    <input onkeypress="return event.charCode != 32" type="text" name="merchant_name" placeholder="Enter merchant name" class="form-control" required value="<?php echo $merchantName; ?>" >
</div>
<div class="form-group">
    <label for="aboutUs" class="form-control-label">About Us</label>
    <input type="text" name="about_us" placeholder="Enter about us" class="form-control" required value="<?php echo $aboutUs; ?>">
</div>
<div class="form-group">
    <label for="address" class="form-control-label">Address</label>
    <input type="text" name="address" placeholder="Enter address" class="form-control" value="<?php echo $address; ?>">
</div>
<div class="form-group">
    <label for="googleMap" class="form-control-label">Google Map</label>
    <input type="text" name="google_map" placeholder="Enter Google Map" class="form-control" value="<?php echo $googleMap; ?>">
</div>
<div class="form-group">
    <label for="email" class="form-control-label">Email</label>
    <input type="email" name="email" placeholder="Enter email" class="form-control" value="<?php echo $email; ?>">
</div>
<div class="form-group">
    <label for="phoneNumber" class="form-control-label">Phone Number</label>
    <input type="text" name="phone_number" placeholder="Enter phone number" class="form-control" value="<?php echo $phoneNumber; ?>">
</div>
<div class="form-group">
    <label for="paymentApiKey" class="form-control-label">Payment API Key</label>
    <input type="text" name="payment_apikey" placeholder="Enter payment API key" class="form-control" value="<?php echo decrypt($paymentApiKey); ?>">
</div>
<div class="form-group">
    <label for="paymentCategoryCode" class="form-control-label">Payment Category Code</label>
    <input type="text" name="payment_category_code" placeholder="Enter payment category code" class="form-control" value="<?php echo decrypt($paymentCategoryCode); ?>">
</div>
<div class="form-group">
    <label for="googleMapIframe" class="form-control-label">Google Map Iframe</label>
    <textarea type="text" name="google_map_iframe" placeholder="Enter Google Map iframe" class="form-control" ><?php echo str_replace('\\', '', $googleMapIframe); ?></textarea>
</div>
<div class="form-group">
    <label for="facebookLink" class="form-control-label">Facebook Link</label>
    <input type="text" name="facebook_link" placeholder="Enter Facebook link" class="form-control" value="<?php echo $facebookLink; ?>">
</div>
<div class="form-group">
    <label for="whatsappLink" class="form-control-label">WhatsApp Link</label>
    <input type="text" name="whatsapp_link" placeholder="Enter WhatsApp link" class="form-control" value="<?php echo $whatsappLink; ?>">
</div>
<div class="form-group">
    <label for="instagramLink" class="form-control-label">Instagram Link</label>
    <input type="text" name="instagram_link" placeholder="Enter Instagram link" class="form-control" value="<?php echo $instagramLink; ?>">
</div>
<div class="form-group">
    <label for="websiteLink" class="form-control-label">Website Link</label>
    <input type="text" name="website_link" placeholder="Enter website link" class="form-control" value="<?php echo $websiteLink; ?>">
</div>
<div class="form-group">
									<label for="heading1" class=" form-control-label">Merchant's logo</label>
									<input type="file" name="merchantLogo" placeholder="Enter image" class="form-control" <?php echo $image_required; ?> value="<?php echo $image; ?>">
									<?php if ($merchantLogo != '') {
             echo "<a target='_blank' href='" . LOGO_SITE_PATH . $merchantLogo . "'><br><img width='150px' src='" . LOGO_SITE_PATH . $merchantLogo . "'/></a>";
         } ?>
								</div>

                                <div class="form-group">
									<label for="heading1" class=" form-control-label">Merchant's favicon logo</label>
									<input type="file" name="merchantFaviconLogo" placeholder="Enter image" class="form-control" <?php echo $image_required; ?> value="<?php echo $merchantFaviconLogo; ?>">
									<?php if ($merchantFaviconLogo != '') {
             echo "<a target='_blank' href='" . LOGO_SITE_PATH . $merchantFaviconLogo . "'><br><img width='150px' src='" . LOGO_SITE_PATH . $merchantFaviconLogo . "'/></a>";
         } ?>
								</div>
<button id="update-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
    <span id="update-button-amount">Update the Ecommerce</span>
</button>


<div class="field_error"><?php echo $msg; ?></div>
</div>
</form>

								
								
							
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
<?php require 'footer.inc.php';
?>
<script>
    $("textarea").each(function () {
  this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
}).on("input", function () {
  this.style.height = 0;
  this.style.height = (this.scrollHeight) + "px";
});
	// $('#desc').val(document.getElementById("desc").value.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br />").replaceAll('\\', ""));
	</script>