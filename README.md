# EMS_E-MERCHANT_SYSTEM

                                                        Configuring Your Computer Device


-------------------------------------------------------------------------------------------------------------------------------------
1. Setting up a localhost server
-------------------------------------------------------------------------------------------------------------------------------------
Step 1: Download XAMPP Software from https://www.apachefriends.org/download.html.

Step 2: Install the XAMPP Software.

Step 3: Done.



-------------------------------------------------------------------------------------------------------------------------------------
2. Setting up database (NOT COMPULSORY) / Go through 3
-------------------------------------------------------------------------------------------------------------------------------------
Step 1: Open and run the XAMPP Software.

Step 2: Start the "Apache" and "MySQL".

Step 3: Click the button of "Admin" of MySQL to go to the http://localhost/phpmyadmin/

Step 4: At the top navigation bar, click on the "Import" button.

Step 5: At the "File to import" section, click on the "Choose File" button and select the "FINALEMS_wavecutget.sql" file provided in the DMS source code folder.

Step 6: Click "Go" button located at the bottom right of the page.

Step 7: Done.


-------------------------------------------------------------------------------------------------------------------------------------
3. Setup your own Firebase Authentication
-------------------------------------------------------------------------------------------------------------------------------------
Go to footer.php, and fill in your own firebaseConfig's data:

const firebaseConfig = {

    apiKey: APIKEY,
    authDomain: AUTHDOMAIN,
    projectId: PROJECTID,
    storageBucket: STORAGEBUCKET,
    messagingSenderId: MESSAGINGSENDERID,
    appId: APPID,
    measurementId: MEASUREMENTID
  }; 

-------------------------------------------------------------------------------------------------------------------------------------
4. Setup your own reCAPTCHA
-------------------------------------------------------------------------------------------------------------------------------------
Go to admin/login.php: ( Add your reCAPTCHA API keys )

$siteKey = SITEKEY;
$secretKey = SECRETKEY;


-------------------------------------------------------------------------------------------------------------------------------------
3. Start to use EMS:E-Merchant System (Information of EMS:E-Merchant System)
-------------------------------------------------------------------------------------------------------------------------------------

EMS:E-Merchant System (Register merchant page) :

http://localhost/EMS/ 
OR 
https://ems-e-merchantsystem.azurewebsites.net/


EMS:E-Merchant System (Ecommerce Website) :

(1)
https://ems-e-merchantsystem.azurewebsites.net/index.php?merchant_name=Ea%20Beaute%20Zone 
OR
http://localhost/EMS/index.php?merchant_name=Ea%20Beaute%20Zone

(2)
https://ems-e-merchantsystem.azurewebsites.net/index.php?merchant_name=ThongHeng
OR
http://localhost/EMS/index.php?merchant_name=ThongHeng

(3)
https://ems-e-merchantsystem.azurewebsites.net/index.php?merchant_name=Beautiful_seol
OR
http://localhost/EMS/index.php?merchant_name=Beautiful_seol

EMS:E-Merchant System (Merchant Management System):

(1)
https://ems-e-merchantsystem.azurewebsites.net/index.php?merchant_name=Ea%20Beaute%20Zone&merchant-admin 
OR
http://localhost/EMS/index.php?merchant_name=Ea%20Beaute%20Zone&merchant-admin

(2)
https://ems-e-merchantsystem.azurewebsites.net/index.php?merchant_name=ThongHeng&merchant-admin
OR
http://localhost/EMS/index.php?merchant_name=ThongHeng&merchant-admin

(3)
https://ems-e-merchantsystem.azurewebsites.net/index.php?merchant_name=Beautiful_seol&merchant-admin
OR
http://localhost/EMS/index.php?merchant_name=Beautiful_seol&merchant-admin


 



