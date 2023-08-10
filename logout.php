<?php
require('connection.inc.php');
require('functions.inc.php');

    setcookie('USER_LOGIN', '', time() - 3600, '/');
    setcookie('USER_ID', '', time() - 3600, '/');
    setcookie('USER_NAME', '', time() - 3600, '/');
    setcookie('MERCHANT_ID', '', time() - 3600, '/');
// unset($_SESSION['USER_LOGIN']);


echo ("<script>location.href='index.php?merchant_name=$merchant_name'</script>");

die();
?>

<script>
firebase.auth().signOut().then(function() {
  
    console.log("User signed out successfully");
   
  }).catch(function(error) {
    console.log(error.message);
  });


</script>