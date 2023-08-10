<?php 
require('top.php');

if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']=='yes'){

	?>

	<script>
	window.location.href='my_order.php';
	</script>
	<?php
}
?>


        
		<!-- Start Contact Area -->
        <section class="htc__contact__area ptb--100 bg__white">
			<div class="container">
			<div class="col-md-7 col-md-offset-2">
		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Register Your Account</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" action="#">
                    <fieldset>
			    	  	<div class="form-group">
                          <label>Your Name:</label>
			    		    <input class="form-control" placeholder="Vincent Goh" name="name" type="text">
			    		</div>
			    		<div class="form-group">
                        <label>Password:</label>
			    			<input id="inputPassword" class="form-control" placeholder="********" name="password" type="password" value="">
			    		</div>
                        <div class="form-group">
                        <label>Repeat Password:</label>
			    			<input class="form-control" placeholder="********" name="repeat_password" type="password" value="">
			    		</div>
                        <div class="form-group">
                          <label>Your Email:</label>
			    		    <input id="inputEmail" class="form-control" placeholder="yourmail@example.com" name="email" type="email">
			    		</div>
                        <div class="form-group">
                          <label>Your Mobile Number:</label>
			    		    <input class="form-control" placeholder="+60123434343" name="name" type="text">
			    		</div>

			    		<div class="text-center pb--15">
			    	    	
			    	    		<a href="login_test.php" >Login your Account</a>
			    	    	
			    	    </div>
			    		<button id="loginbtn" class="btn btn-success btn-block" >Register an Account</button>
			    	</fieldset>
			      	</form>
                      <hr/>
                    <center><h4>OR</h4></center>
                    <br>
                    <input class="btn btn-facebook btn-block" type="submit" value="Sign in with Facebook">
					<input class="btn btn-google btn-block" type="submit" value="Sign in with Google">
			    </div>

          <!-- The surrounding HTML is left untouched by FirebaseUI.
     Your app may use that space for branding, controls and other customizations.-->

			</div>
</div>
</div>
		</section>

		
<?php require('footer.php')?>        

