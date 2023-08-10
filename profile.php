<?php
ob_start(); // Initiate the output buffer
require 'top.php';
if (!isset($_COOKIE['USER_LOGIN']) || $_COOKIE['USER_LOGIN'] == "") { ?>
	<script>
	window.location.href='index.php?merchant_name=<?= $merchant_name ?>';
	</script>
	<?php }
if (isset($_POST['submit'])) {

        $name = get_safe_value($con, $_POST['name']);
        $mobile = get_safe_value($con, $_POST['mobile_number']);
        $email = get_safe_value($con, $_POST['email']);
		$address = get_safe_value($con, $_POST['address']);
		$stateNcity = get_safe_value($con, $_POST['stateNcity']);
		$postcode = get_safe_value($con, $_POST['postcode']);
        $uid = $_COOKIE['USER_ID'];
        if ($_FILES['profile_image']['name'] != '') {
                $query = "SELECT profile_image FROM users WHERE uid = ? AND merchant_id = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("si", $uid, $merchant_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $profile_image = $row['profile_image'];
						$current_image = PROFILE_IMAGE_SITE_PATH . $profile_image;
                        unlink($current_image);
                }
                $stmt->close();
                // $check = mysqli_num_rows($delete_image_path);
                // if ($check > 0) {
                //         $row_delete_image_path = mysqli_fetch_assoc($delete_image_path);
                //         $current_image = PROFILE_IMAGE_SITE_PATH . $row_delete_image_path['profile_image'];
                //         unlink($current_image);
                // }
                $image = date("Ymd") . '_' . $_FILES['profile_image']['name'];
                move_uploaded_file($_FILES['profile_image']['tmp_name'], PROFILE_IMAGE_SITE_PATH . $image);
				$update_sql = "UPDATE users SET name=?, mobile=?, email=?, profile_image=? ,address=?,stateNcity=?, postcode=?  WHERE uid=? AND merchant_id=?";
				$stmt = $con->prepare($update_sql);
				$stmt->bind_param("ssssssssi", $name, $mobile, $email, $image,$address,$stateNcity,$postcode, $uid, $merchant_id);
				$stmt->execute();
				$stmt->close();
				
                setcookie('USER_NAME', $name, time() + 86400 * 30, "/");
                setcookie('PROFILE_IMAGE', $image, time() + 86400 * 30, "/");
        } else {
			$update_sql = "UPDATE users SET name=?, mobile=?, email=? ,address=?,stateNcity=?, postcode=? WHERE uid=? AND merchant_id=?";
			$stmt = $con->prepare($update_sql);
			$stmt->bind_param("sssssssi", $name, $mobile, $email, $address,$stateNcity,$postcode, $uid,$merchant_id);
			$stmt->execute();
			$stmt->close();
			
                setcookie('USER_NAME', $name, time() + 86400 * 30, "/");
        }
        ?>
	<script>
	window.location.href='profile.php?merchant_name=<?= $merchant_name ?>';
	</script>
<?php
}
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
		$stateNcity = $row['stateNcity'];
		$postcode = $row['postcode'];
}
?>

<!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: #eee ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php?merchant_name=<?= $merchant_name ?>">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Profile</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        
		<!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
            <div class="container">
			<div class="alert alert-success" id="success" role="alert" style="display:none;" >
  Update Profile Successfully
</div>

				
				<div class="row">
					<div class="col-md-12">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
								<div class="contact-title">
									<h2 class="title__line--6">Profile</h2>
									<?php if ($name == "null" || $email == "null" || $mobile == "null" || $profile_image == "null") { ?>
		<div class="alert alert-danger" id="alert_message" role="alert"  >Please fill your profile information complentely. </div>
	<?php } ?>
								</div>
							</div>
							<div class="col-xs-12">
							<form method="post" enctype="multipart/form-data" id="frmPassword" >
									
								<picture>
								
  <img id="profile_image_preview" src="<?= $profile_image == "null" ? PROFILE_IMAGE_SITE_PATH . 'null-user.png' : PROFILE_IMAGE_SITE_PATH . $profile_image ?>" class="img-fluid img-thumbnail" alt="<?php echo $name; ?>" style="width:150px;">
  
</picture>
<input type="file" name="profile_image" id="profile_image" class="form-control" >
<br>


									<div class="single-contact-form">
										<label class="password_label">Name</label>
										<div class="contact-box name">
											<input type="text" name="name" id="name" placeholder="Please fill in your name" style="width:100%" value="<?php if ($name != "null" && $name != "") {
                   echo $name;
           } ?>" required>
											
										</div>
										<br>
										<div class="alert alert-danger" id="name_error" role="fail" style="display:none;">
										Please enter your name
</div>
										
										
									</div>
									<div class="single-contact-form">
										<label class="password_label">Mobile Number</label>
										<div class="contact-box name">
											<input type="text" name="mobile_number" id="mobile_number" style="width:100%" placeholder="Please fill in your mobile number"  value="<?php if ($mobile != "null" && $mobile != "") {
                   echo $mobile;
           } ?>" required>
											
										</div>
										<br>
										<div class="alert alert-danger" id="mobile_error" role="fail" style="display:none;">
										Please enter your mobile number
</div>
										
									</div>
									<div class="single-contact-form">
										<label class="password_label">Email</label>
										<div class="contact-box name">
											<input type="text" name="email" id="email" style="width:100%" placeholder="Please fill in your email" value="<?php if ($email != "null" && $email != "") {
                   echo $email;
           } ?>" required>
											
										</div>
										<br>
										<div class="alert alert-danger" id="email_error" role="fail" style="display:none;">
										Please enter your email
</div>
									</div>
										<hr>
										<div class="single-contact-form">
										<label class="password_label">Address</label>
										<div class="contact-box name">
											<input type="text" name="address" id="address" style="width:100%" placeholder="Please fill in your address" value="<?php if ($address != "null" && $address != "") {
                   echo $address;
           } ?>" >
											
										</div>
										<br>
										<div class="single-contact-form">
										<label class="password_label">State / City</label>
										<div class="contact-box name">
											<input type="text" name="stateNcity" id="stateNcity" style="width:100%" placeholder="Please fill in your state/city" value="<?php if ($stateNcity != "null" && $stateNcity != "") {
                   echo $stateNcity;
           } ?>" >
											
										</div>
										<br>
										<div class="single-contact-form">
										<label class="password_label">PostCode</label>
										<div class="contact-box name">
											<input maxlength="5" type="text" name="postcode" id="postcode" style="width:100%" placeholder="Please fill in your postcode" value="<?php if ($postcode != "null" && $postcode != "") {
                   echo $postcode;
           } ?>" requied>
											
										</div>
										
									
									<div class="contact-btn">
										<button name="submit" type="submit" class="fv-btn" onclick="update_profile()" id="btn_submit">Update</button>
										
									</div>
								</form>
								
								
								
							</div>
						</div> 
                
				</div>
				

					
            </div>
        </section>

		<script>

profile_image.onchange = evt => {
  const [file] = profile_image.files
  if (file) {
    profile_image_preview.src = URL.createObjectURL(file)
  }
}
		function update_profile(){
			jQuery('.field_error').html('');
			var name=jQuery('#name').val();
			var email=jQuery('#email').val();
			var mobile_number=jQuery('#mobile_number').val();
			
			var profile_image=document.getElementById('profile_image').files[0];
			
			if(email==''){
				$("#email_error").show();
				
			}
			if(name==''){
				$("#name_error").show();
				
			}
			if(mobile_number==''){
				$("#mobile_error").show();
				
			}

		}
	
		</script>
<?php require 'footer.php'; ?>        
<?php ob_end_flush(); // Flush the output from the buffer

?>
