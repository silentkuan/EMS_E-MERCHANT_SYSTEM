<?php
//$con=mysqli_connect("ntn.h.filess.io","FINALEMS_wavecutget","b935576cc4a3b53af67a2f8717347f2cdd361b73","FINALEMS_wavecutget","3307");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u910306159_ems";

// Create a database connection
$con = new mysqli($servername, $username, $password, $dbname);
define('SERVER_PATH','');
define('SITE_PATH','');
$http = "http://";
define("PATH", $http.$_SERVER["HTTP_HOST"]."/");
define('PRODUCT_IMAGE_SERVER_PATH','media/product/');
define('PRODUCT_IMAGE_SITE_PATH','media/product/');
define('PROFILE_IMAGE_SITE_PATH','media/profile/');
define('MERCHANT_LOGO_SITE_PATH','media/logo/');
define('PRODUCT_MULTIPLE_IMAGE_SERVER_PATH','media/product_images/');
define('PRODUCT_MULTIPLE_IMAGE_SITE_PATH','media/product_images/');
define('LOGO_IMAGE_SITE_PATH','media/logo/');

define('BANNER_SERVER_PATH','media/banner/');
define('BANNER_SITE_PATH','media/banner/');

// define('INSTAMOJO_KEY','key');
// define('INSTAMOJO_TOKEN','token');
 //https://www.youtube.com/watch?v=zWLKQ_loJqI&list=PLWCLxMult9xfYlDRir2OGRZFK397f3Yeb&index=24


 define('SMTP_EMAIL','emerchant888@gmail.com');
 define('SMTP_PASSWORD','yykjyciajkubgbqr');
//https://www.youtube.com/watch?v=aBbmo1pi5B0&list=PLWCLxMult9xfY_dsYicKGcCLhlZ6YXFMh&index=1


// define('SMS_KEY','sms_key');
 //https://www.youtube.com/watch?v=_XaaIJlkNV4&list=PLWCLxMult9xfYlDRir2OGRZFK397f3Yeb&index=27
?>