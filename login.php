
<?php 
require('top.php');

if(isset($_COOKIE['USER_LOGIN']) && $_COOKIE['USER_LOGIN']=='yes'){

	?>
	<script>
	window.location.href='my_order.php?merchant_name=<?=$merchant_name?>';
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
			    	<h3 class="panel-title">Login Your Account</h3>
			 	</div>
			  	<div class="panel-body">
				  <div id="firebaseui-auth-container"></div>
                      <hr/>
                    <center><h4>Register an Account</h4></center>
					<br>
					<div class="alert alert-danger" id="password_error" role="fail" style="display:none;">
					Please ensure that the password and repeat password fields match, or that both fields are not empty.
</div>
<div class="alert alert-danger" id="name_error" role="fail" style="display:none;">
Please ensure that your name is provided.
</div>
<div class="alert alert-danger" id="email_error" role="fail" style="display:none;">
Please ensure that a valid email is provided or the email field is not empty.
</div>
<div class="alert alert-danger" id="mobile_error" role="fail" style="display:none;">
										Please make sure your mobile number is valid, or the mobile number is not empty.
</div>

<div class="alert alert-danger" id="file_error" role="fail" style="display:none;">
										Please make sure your file is not empty.
</div>
<div class="alert alert-success" id="result" role="success" style="display:none;">
New user registered successfully
</div>
					<form  >
                    <fieldset>
					<div class="form-group">
                          <label>Your Profile Picture:</label>
						  <br>
						 <center> <img id="profile_image_preview" src="<?= PROFILE_IMAGE_SITE_PATH.'null-user.png' ?>" class="img-fluid img-thumbnail"
						  alt="upload your profile picture" style="width:150px;"></center>
						  <input type="file" name="profile_image_upload" id="profile_image_upload" required>
			    		</div>
			    	  	<div class="form-group">
                          <label>Your Name:</label>
			    		    <input class="form-control" placeholder="Vincent Goh" name="name" type="text" required>
			    		</div>
			    		<div class="form-group">
                        <label>Password:</label>
			    			<input id="inputPassword" class="form-control" placeholder="********" name="password" type="password" value="" required>
			    		</div>
                        <div class="form-group">
                        <label>Repeat Password:</label>
			    			<input class="form-control" placeholder="********" name="repeat_password" type="password" value="" required>
			    		</div>
                        <div class="form-group">
                          <label>Your Email:</label>
			    		    <input id="inputEmail" class="form-control" placeholder="yourmail@example.com" name="email" type="email" required>
			    		</div>
                        <div class="form-group">
                          <label>Your Mobile Number:</label>
			    		    <input class="form-control" type="tel " name="mobile_number" placeholder="60123455677" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" required>
			    		</div>

			    		
			    	<center>	<button type="button" id="signup-btn" class="btn btn-success btn-block" >Register an Account</button> </center>
			    	</fieldset>
			      	</form>
         
		 
			    </div>
			</div>
</div>
</div>
		</section>
		
		
<?php require('footer.php')?>        

  <script>
profile_image_upload.onchange = evt => {
  const [file] = profile_image_upload.files
  if (file) {
    profile_image_preview.src = URL.createObjectURL(file)
  }
}


function isValidEmail(email) {
  // Simple email validation regex
  var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return emailRegex.test(email);
}

function isValidMobileNumber(mobile) {
  // Mobile number validation regex for the provided pattern
  var mobileRegex = /^[0-9]{4}[0-9]{3}[0-9]{4}$/;
  return mobileRegex.test(mobile);
}
  
    // Firebase configuration
	function signUp(event) {
  event.preventDefault();
  var name = document.querySelector('input[name="name"]').value;
  var password = document.querySelector('input[name="password"]').value;
  var confirmPassword = document.querySelector('input[name="repeat_password"]').value;
  var email = document.querySelector('input[name="email"]').value;
  var mobile = document.querySelector('input[name="mobile_number"]').value;
  var fileInput = document.querySelector('input[name="profile_image_upload"]');
  var file = fileInput.files[0];

  // Perform input validation checks_

  if (file == null) {
    // Display error message for file upload field
    $("#file_error").show();
    return;
  } else {
    $("#file_error").hide();
  }
  if (name.trim() === "") {
    // Display error message for name field
    $("#name_error").show();
    return;
  } else {
    $("#name_error").hide();
  }

  if (password !== confirmPassword || password.trim() === "" || confirmPassword.trim() === "") {
    // Display error message for password fields
    $("#password_error").show();
    return;
  } else {
    $("#password_error").hide();
  }

  if (!isValidEmail(email) ||  email.trim() === "") {
    // Display error message for email field
    $("#email_error").show();
    return;
  } else {
    $("#email_error").hide();
  }

  if (!isValidMobileNumber(mobile)|| mobile.trim() === "") {
    // Display error message for mobile number field
    $("#mobile_error").show();
    return;
  } else {
    $("#mobile_error").hide();
  }



  // Proceed with creating the user
  firebase.auth().fetchSignInMethodsForEmail(email)
    .then(function (signInMethods) {
      if (signInMethods.length > 0) {
        jQuery('#result').html("Account already exists for email:", email);
        $("#result").show();
      } else {
        // Create user with email and password
        firebase.auth().createUserWithEmailAndPassword(email, password)
          .then(function (userCredential) {
            var user = userCredential.user;
            var uid = user.uid;

            var profile_image = "";
            var formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('profile_image_upload', file);
            formData.append('profile_image', profile_image);
            formData.append('mobile', mobile);
            formData.append('uid', uid);

            jQuery.ajax({
              url: 'create_user.php?merchant_name=<?=$merchant_name?>',
              type: 'post',
              data: formData,
              processData: false,
              contentType: false,
              success: function (result) {
                window.location.href = 'profile.php?merchant_name=<?=$merchant_name?>';
              }
            });
          })
          .catch(function (error) {
            jQuery('#result').html("Error creating account:", error.message);
            $("#result").show();
          });
      }
    })
    .catch(function (error) {
      jQuery('#result').html("Error checking email:", error.message);
      $("#result").show();
    });
}


  // Add event listener to the sign-up button
  var signupBtn = document.getElementById("signup-btn");
  signupBtn.addEventListener("click", signUp);


 // FirebaseUI configuration
var uiConfig = {
  signInSuccessUrl: 'profile.php?merchant_name=<?=$merchant_name?>', // Redirect URL after successful sign-in
  signInOptions: [
    // List of authentication providers you enabled in Firebase Console
    firebase.auth.EmailAuthProvider.PROVIDER_ID,
    firebase.auth.GoogleAuthProvider.PROVIDER_ID,
	// Phone Sign-In
    firebase.auth.PhoneAuthProvider.PROVIDER_ID,
    // Add more provider IDs if desired
  ],

  callbacks: {
    // Handle signed in user
    signInSuccessWithAuthResult: function(authResult, redirectUrl) {
      var user = authResult.user;
	  
      if (authResult.additionalUserInfo.isNewUser) {
        
          var uid=user.uid;     
	var name=user.displayName;
	var email=user.email;
	var profile_image=user.photoURL;

	var mobile=user.phoneNumber;

		jQuery.ajax({
			url:'create_user.php?merchant_name=<?=$merchant_name?>',
			type:'post',
			data:'name='+name+'&email='+email+'&profile_image='+profile_image+'&mobile='+mobile+'&uid='+uid,
			success:function(result){
				window.location.href='profile.php?merchant_name=<?=$merchant_name?>';
			}	
		});
	
      } else {

        var uid=user.uid;     
        var name=user.displayName;
	var email=user.email;
	var profile_image=user.photoURL;

	var mobile=user.phoneNumber;

		jQuery.ajax({
			url:'login_submit.php?merchant_name=<?=$merchant_name?>',
			type:'post',
			data:'name='+name+'&email='+email+'&profile_image='+profile_image+'&mobile='+mobile+'&uid='+uid,
			success:function(result){
				window.location.href='index.php?merchant_name=<?=$merchant_name?>';
			}	
		});
      }
      return false; // Prevent redirect
    }
  }
  // Additional config options if needed
};

// Initialize the FirebaseUI Widget
var ui = new firebaseui.auth.AuthUI(firebase.auth());
ui.start('#firebaseui-auth-container', uiConfig);




 </script> <!-- FirebaseUI initialization script -->