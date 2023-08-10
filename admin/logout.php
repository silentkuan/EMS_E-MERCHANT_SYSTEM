<?php
// session_start();
require "connection.inc.php";
require "functions.inc.php";
unset($_SESSION['ADMIN_LOGIN']);
unset($_SESSION['ADMIN_USERNAME']);
echo ("<script>location.href='login.php?merchant_name=$merchant_name'</script>");

die();
?>