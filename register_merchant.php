
<?php 



date_default_timezone_set("Asia/Kuala_Lumpur");
require('connection.inc.php');
// require('functions.inc.php');

function get_safe_value($con, $str)
{
    if ($str != '') {
        $str = trim($str);
        return mysqli_real_escape_string($con, $str);
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


// Assuming you have already established a conection to the MySQL database

// Define variables to store form data
$merchantName = '';
$aboutUs = '';
$address = '';
$googleMap = '';
$email = '';
$phoneNumber = '';
$paymentApiKey = '';
$paymentCategoryCode = '';
$googleMapIframe = '';
$facebookLink = '';
$whatsappLink = '';
$instagramLink = '';
$websiteLink = '';


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $merchantName =get_safe_value($con, $_POST['merchant_name']);
    $aboutUs =get_safe_value($con, $_POST['about_us']);
    $address =get_safe_value($con, $_POST['address']);
    $googleMap =get_safe_value($con, $_POST['google_map']);
    $email =get_safe_value($con, $_POST['email']); 
    $phoneNumber = get_safe_value($con, $_POST['phone_number']);
    $paymentApiKey =get_safe_value($con, $_POST['payment_apikey']);
    $paymentCategoryCode = get_safe_value($con, $_POST['payment_category_code']);
    $googleMapIframe =get_safe_value($con, $_POST['google_map_iframe']); 
    $facebookLink =get_safe_value($con, $_POST['facebook_link']);
    $whatsappLink =get_safe_value($con, $_POST['whatsapp_link']); 
    $instagramLink = get_safe_value($con, $_POST['instagram_link']);
    $websiteLink = get_safe_value($con, $_POST['website_link']);
    $password = get_safe_value($con, $_POST['password']);
    $username = get_safe_value($con, $_POST['username']);
    $hash_variable_salt = password_hash($password, PASSWORD_DEFAULT, ['cost' => 9]);

    // Perform data validation and error handling
    $errors = [];

    // Validate and sanitize the form inputs
    // Add your validation logic here
    // Example: if (empty($merchantName)) { $errors[] = 'Merchant Name is required.'; }

    // If there are no errors, proceed with data insertion
    if (empty($errors)) {
        // Retrieve file input fields
        $merchantLogo = $_FILES['merchant_logo']['name'];
        $merchantLogoTemp = $_FILES['merchant_logo']['tmp_name'];
        $merchantFaviconLogo = $_FILES['merchant_favicon_logo']['name'];
        $merchantFaviconLogoTemp = $_FILES['merchant_favicon_logo']['tmp_name'];

        // Move uploaded files to a desired location
        $uploadsDirectory = 'media/logo/';
        move_uploaded_file($merchantLogoTemp, $uploadsDirectory . $merchantLogo);
        move_uploaded_file($merchantFaviconLogoTemp, $uploadsDirectory . $merchantFaviconLogo);

       // Prepare the merchant insertion statement
$insert_merchant_sql = "INSERT INTO merchant (merchant_name, merchant_logo, about_us, address, google_map, email, phone_number, payment_apikey, payment_category_code, merchant_favicon_logo, google_map_iframe, facebook_link, whatsapp_link, instagram_link, website_link)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the employee insertion statement
$insert_employee_sql = "INSERT INTO employee (username, password, email, mobile, role_id, status, merchant_id)
VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare the statements to prevent SQL injection
$insert_merchant_stmt = $con->prepare($insert_merchant_sql);
$insert_employee_stmt = $con->prepare($insert_employee_sql);

// Bind parameters to the prepared statements
$insert_merchant_stmt->bind_param("sssssssssssssss", $merchantName, $merchantLogo, 
$aboutUs, $address, $googleMap, $email, $phoneNumber, encrypt($paymentApiKey), encrypt($paymentCategoryCode),
 $merchantFaviconLogo, htmlentities($googleMapIframe), $facebookLink, $whatsappLink, $instagramLink, $websiteLink);
$insert_employee_stmt->bind_param("ssssiii", $username, $hash_variable_salt, $email, $phoneNumber, 
$role_id, $status, $insertedId);

// Execute the merchant insertion statement
if ($insert_merchant_stmt->execute()) {
// echo "Data inserted successfully.";
$insertedId = $con->insert_id;

// Execute the employee insertion statement
// $username = '...'; // Set the username value
// $hash_variable_salt = '...'; // Set the password value
$role_id = 1; // Set the role_id value
$status = 1; // Set the status value

if ($insert_employee_stmt->execute()) {
// Clear the form fields after successful insertion
echo "<script>
window.location.href='admin/login.php?merchant_name=$merchantName';
</script>";
} else {
echo "Error: " . $insert_employee_sql . "<br>" . $con->error;
}
} else {
echo "Error: " . $insert_merchant_sql . "<br>" . $con->error;
}

// Close the database connection
$con->close();

    }
}

// Close the database conection



$meta_title="EMS:E-Merchant System";
$meta_desc="EMS:E-Merchant System, Simple register to get your own ecommerce website";
$meta_keyword="EMS:E-Merchant System, EMS, Ecommerce, E-commerce, Merchant, Management System";
$meta_url=SITE_PATH;
$meta_image="";

$all_merchant = mysqli_query($con, "SELECT * FROM merchant ORDER BY RAND() LIMIT 3");
$merchant_arr=array();
while($row=mysqli_fetch_assoc($all_merchant)){
	$merchant_arr[]=$row;	
}

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $meta_title?></title>
    <meta name="description" content="<?php echo $meta_desc?>">
	<meta name="keywords" content="<?php echo $meta_keyword?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta property="og:title" content="<?php echo $meta_title?>"/>
	<meta property="og:image" content="<?php echo $meta_image?>"/>
	<meta property="og:url" content="<?php echo $meta_url?>"/>
	<meta property="og:site_name" content="<?php echo SITE_PATH?>"/>
   
<link rel="icon" type="image/png" href="media/logo/ems_favico.png">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
	<script src="js/vendor/modernizr-3.5.0.min.js"></script>
	<link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.css">
	<link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css">
	<style>
	.map-contacts--2 iframe{
        width: 100%!important;
        /* height:100%!important; */
    }
	</style>
</head>
<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->  

    <!-- Body main wrapper start -->
    <div class="wrapper">
        <header id="htc__header" style="border-bottom: 1px solid #ddd;" class="htc__header__area header--one">
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="register_merchant.php"><img src="media/logo/ems_logo.png" alt="EMS LOGO" height="150px" width="150px"></a>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-5 col-sm-4 col-xs-2">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        
                                        <?php
										foreach($merchant_arr as $list){
											?>
											<li class="drop"><a href="index.php?merchant_name=<?=$list['merchant_name']?>"><?php echo $list['merchant_name']?></a>
											
											
											</li>
											<?php
										}
										?>
                                     
                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                        <ul>
                                            
                                            <?php
											foreach($merchant_arr as $list){
												?>
												<li class="drop"><a href="index.php?merchant_name=<?= $list['merchant_name']?>"><?php echo $list['merchant_name']?></a>
										
											
											</li>
												<?php
											}
											?>
                                           
                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            
                    <div class="mobile-menu-area"></div>
                </div>
				<div id="alert-message" class="alert alert-success fade in alert-place "></div>
				<div id="alert-error-message" class="alert alert-danger fade in alert-place "></div>
       
        
    </div>
            </div>
        </header>
		





        
		<!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
			<div class="container">
			
			<div class="col-md-7 col-md-offset-2">
			
		<div class="panel panel-default">
		
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Register your Ecommerce Website for your Merchant</h3>
			 	</div>
			  
                  
					<br>
					
          <form action="" method="post" enctype="multipart/form-data">
    <!-- Form fields -->
    <fieldset style="padding:10px">
        <!-- Merchant Name -->
        <div class="form-group">
            <label>Merchant Name: </label>
            <input onkeypress="return event.charCode != 32" placeholder="Gadget_shop" class="form-control" type="text" name="merchant_name" required value="<?php echo htmlspecialchars($merchantName); ?>">
        </div>

        <!-- Merchant Logo -->
        <div class="form-group">
            <label>Merchant Logo:</label>
            <input class="form-control" type="file" name="merchant_logo" required>
        </div>
  <!-- Merchant Favicon Logo -->
  <div class="form-group">
            <label>Merchant Favicon Logo:</label>
            <input class="form-control" type="file" name="merchant_favicon_logo" required>
        </div>
        <!-- About Us -->
        <div class="form-group">
            <label>About Us:</label>
            <textarea class="form-control" name="about_us" placeholder="Welcome to Gadget Shop, your ultimate destination for the latest and greatest gadgets! We offer a wide selection of high-quality tech products to satisfy all your gadget needs. Discover the future of technology at Gadget Shop!" required><?php echo htmlspecialchars($aboutUs); ?></textarea>
        </div>

        <!-- Address -->
        <div class="form-group">
            <label>Address:</label>
            <input class="form-control" type="text" name="address" placeholder="G2 Ground Floor, Square One Mall, Taman Flora Utama 83000, Batu Pahat,Johor." required value="<?php echo htmlspecialchars($address); ?>">
        </div>

        <!-- Google Map -->
        <div class="form-group">
            <label>Google Map:</label>
            <input class="form-control" type="text" name="google_map" required value="<?php echo htmlspecialchars($googleMap); ?>">
        </div>

        <div class="form-group">
            <label>Merchant's Administrator: </label>
            <input class="form-control" type="text" name="username" id="admin" placeholder="jason" required >
        </div>

        <div class="form-group">
            <label>Administrator's password</label>
            <input class="form-control" type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters" required >
        </div>

        <!-- Email -->
        <div class="form-group">
            <label>Email:</label>
            <input class="form-control" type="email" name="email" required placeholder="jason@gmail.com" value="<?php echo htmlspecialchars($email); ?>">
        </div>

        <!-- Phone Number -->
        <div class="form-group">
            <label>Phone Number:</label>
            <input class="form-control" type="text" name="phone_number" pattern="[0-9]{10,}" placeholder="60125654443" title="Please enter a valid 10-digit phone number" required value="<?php echo htmlspecialchars($phoneNumber); ?>">
        </div>

        <!-- Payment API Key -->
        <div class="form-group">
            <label>Payment API Key: (If you have)</label>
            <input class="form-control" type="text" name="payment_apikey"  value="<?php echo htmlspecialchars($paymentApiKey); ?>">
        </div>

        <!-- Payment Category Code -->
        <div class="form-group">
            <label>Payment Category Code: (If you have)</label>
            <input class="form-control" type="text" name="payment_category_code"  value="<?php echo htmlspecialchars($paymentCategoryCode); ?>">
        </div>

      

        <!-- Google Map Iframe -->
        <div class="form-group">
            <label>Google Map Iframe: </label>
            <input class="form-control" type="text" name="google_map_iframe"  value="<?php echo htmlspecialchars($googleMapIframe); ?>" required>
        </div>

        <!-- Facebook Link -->
        <div class="form-group">
            <label>Facebook Link: (If you have)</label>
            <input class="form-control" type="text" name="facebook_link"  value="<?php echo htmlspecialchars($facebookLink); ?>">
        </div>

        <!-- WhatsApp Link -->
        <div class="form-group">
            <label>WhatsApp Link: (If you have)</label>
            <input class="form-control" type="text" name="whatsapp_link"  value="<?php echo htmlspecialchars($whatsappLink); ?>">
        </div>

        <!-- Instagram Link -->
        <div class="form-group">
            <label>Instagram Link: (If you have)</label>
            <input class="form-control" type="text" name="instagram_link"  value="<?php echo htmlspecialchars($instagramLink); ?>">
        </div>

        <!-- Website Link -->
        <div class="form-group">
            <label>Website Link: (If you have)</label>
            <input class="form-control" type="text" name="website_link"  value="<?php echo htmlspecialchars($websiteLink); ?>">
        </div>

        <button type="submit" class="btn btn-success btn-block">Register an Account</button>
    </fieldset>
</form>
         
		 
			    </div>
               
                   
                        <div class="map-contacts--2">
                        
                        
                        <iframe width="760" height="315" src="https://www.youtube.com/embed/yEDmtGhHAzA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        
          
                        </div>
                  
                      
              
			</div>
</div>
</div>
		</section>
		
		
    <footer id="htc__footer">
    <div class="htc__copyright bg__cat--5">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="copyright__inner">
                                <p>Copyright© <a href="#">Kuan Jiun Ying</a> 2023. All right reserved.</p>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </footer>    
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>
	<script src="js/jquery.imgzoom.js"></script>
	<script src="js/custom.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" class="init">
	

$(document).ready(function () {
	$('#example').DataTable();
});

$(function() {
        $('#admin').on('keypress', function(e) {
            if (e.which == 32){
                console.log('Space Detected');
                return false;
            }
        });
});
	</script>
 
 <style>
    .map-contacts--2 iframe {
       
       width: 600px;
       height: 500px;
   }
    </style>