<?php


// if (isset($_SESSION["ADMIN_LOGIN"]) && $_SESSION["ADMIN_LOGIN"] != "")
// {
// }
// else
// {
//     header("location:login.php");
//     die();
// }
?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Dashboard Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
      <link rel="icon" type="image/png" href="../media/logo/<?=$merchant_favicon?>">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  


  
   </head>
   <body>
   <div id="pre-loader">
    <img src="images/loader.gif" alt="Loading..." />
</div>
      <aside id="left-panel" class="left-panel">
         <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
               <ul class="nav navbar-nav">
               <li class="menu-title">
                     <a href="../index.php?merchant_name=<?=$merchant_name?>" target="_blank">My Ecommerce Website</a>
                  </li>
                  <hr>
                  <li class="menu-title">Menu</li>
                  <li class="menu-item-has-children dropdown">
                     
                     <a href="dashboard.php?merchant_name=<?=$merchant_name?>" > Dashboard</a>
                     </li>
                  <?php if($_SESSION['ADMIN_ROLE']==1 || $_SESSION['ADMIN_ROLE']==4){ ?>
                  <li class="menu-item-has-children dropdown">
                     
                     <a href="order_master.php?merchant_name=<?=$merchant_name?>" > Order Management</a>
                     </li>

                     <li class="menu-item-has-children dropdown">
                     <a href="coupon_master.php?merchant_name=<?=$merchant_name?>" > Coupon Management</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="sales.php?merchant_name=<?=$merchant_name?>" > Generate Sales Report</a>
                  </li>
                 <?php }?>

                 <?php if($_SESSION['ADMIN_ROLE']==1 || $_SESSION['ADMIN_ROLE']==2){ ?>
                  <li class="menu-item-has-children dropdown">
                     <a href="banner.php?merchant_name=<?=$merchant_name?>" > Banner Management</a>
                  </li>

                  <li class="menu-item-has-children dropdown">
                     <a href="categories.php?merchant_name=<?=$merchant_name?>" > Categories Management</a>
                  </li>
				  <li class="menu-item-has-children dropdown">
                     <a href="sub_categories.php?merchant_name=<?=$merchant_name?>" > Sub Categories Management</a>
                  </li>
				  <li class="menu-item-has-children dropdown">
                     <a href="product.php?merchant_name=<?=$merchant_name?>" > Product Management</a>
                  </li>

                  <li class="menu-item-has-children dropdown">
                     <a href="product_review.php?merchant_name=<?=$merchant_name?>" > Product Review List</a>
                  </li>
                  <?php }?>
                  <?php if($_SESSION['ADMIN_ROLE']==1 || $_SESSION['ADMIN_ROLE']==3){ ?>
				  
				 
				   <li class="menu-item-has-children dropdown">
                     <a href="vendor_management.php?merchant_name=<?=$merchant_name?>" > Employees Management</a>
                  </li>
                  <?php }?>

                  <?php if($_SESSION['ADMIN_ROLE']==1 ){ ?>
                  
				  <li class="menu-item-has-children dropdown">
                     <a href="users.php?merchant_name=<?=$merchant_name?>" > Customer List</a>
                  </li>
                  <li class="menu-item-has-children dropdown">
                     <a href="manage_merchant.php?merchant_name=<?=$merchant_name?>" >Merchant Management</a>
                  </li>
				
				  <!-- <li class="menu-item-has-children dropdown">
                     <a href="contact_us.php" > Message List</a>
                  </li> -->
                  <?php }?>
                 
               </ul>
            </div>
         </nav>
      </aside>
      <div id="right-panel" class="right-panel">
         <header id="header" class="header">
            <div class="top-left">
               <div class="navbar-header">
                  <a class="navbar-brand" href="dashboard.php?merchant_name=<?=$merchant_name?>">
                     Admin Page
                     <!-- <img src="images/logo.png" alt="Logo"> -->
                  </a>
                  <a class="navbar-brand hidden" href="dashboard.php?merchant_name=<?=$merchant_name?>"><img src="images/logo2.png" alt="Logo"></a>
                  <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
               </div>
            </div>
            <div class="top-right">
               <div class="header-menu">
                  <div class="user-area account float-right">
                     <a  class="account active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $_SESSION["ADMIN_USERNAME"]; ?></a>
                  </div>
                  <div class="user-area account float-right">
                  <a class="account active" href="logout.php?merchant_name=<?=$merchant_name?>"><i class="fa fa-power-off pr-1"></i> Logout</a>
                  </div>
                 
               </div>
            </div>
         </header>
