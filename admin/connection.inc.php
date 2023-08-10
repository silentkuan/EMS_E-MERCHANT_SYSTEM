<?php
session_start();


 $servername = "localhost";
$username = "root";
$password = "";
$dbname = "u910306159_ems";

// Create a database connection
$con = new mysqli($servername, $username, $password, $dbname);
define('SERVER_PATH','');
define('SITE_PATH','');

define('PRODUCT_IMAGE_SERVER_PATH','../media/product/');
define('PRODUCT_IMAGE_SITE_PATH','../media/product/');
define('LOGO_SITE_PATH','../media/logo/');
define('PRODUCT_MULTIPLE_IMAGE_SERVER_PATH','../media/product_images/');
define('PRODUCT_MULTIPLE_IMAGE_SITE_PATH','../media/product_images/');

define('BANNER_SERVER_PATH','../media/banner/');
define('BANNER_SITE_PATH','../media/banner/');

// define('SHIPROCKET_TOKEN_EMAIL','gmail');
// define('SHIPROCKET_TOKEN_PASSWORD','password');

?>