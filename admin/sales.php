<?php
require "functions.inc.php";
isAdmin();
require('top.inc.php');?>

<script>
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
  }
</script>
<!-- <iframe src="sales_iframe.php" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; "></iframe> -->
<iframe src="sales_iframe.php?merchant_name=<?=$merchant_name?>" frameborder="0" scrolling="no" onload="resizeIframe(this)" frameborder="0"  style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe>
<?php
require('footer.inc.php');
?>

