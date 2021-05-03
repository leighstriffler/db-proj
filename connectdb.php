<?php

/******************************/
// connecting to GCP cloud SQL instance

// $username = 'root';
// $password = 'your-root-password';

// $dbname = 'your-database-name';

// if PHP is on GCP standard App Engine, use instance name to connect
// $host = 'instance-connection-name';

// if PHP is hosted somewhere else (non-GCP), use public IP address to connect
// $host = "public-IP-address-to-cloud-instance";


/******************************/
// connecting to DB on XAMPP (local)

// $username = 'WebAppProject';
// $password = 'GoodF!lms1358';
// $host = 'localhost:3306';
// $dbname = 'db-proj';


// if( $_SESSION['role']=='nurse'){
//    echo "<script>console.log(".$_SESSION['account']. ")</script>";
//    $username = 'lss4de_a';
//    $password = 'Spr1ng2021!!';
//    $host = 'usersrv01.cs.virginia.edu';
//    $dbname = 'lss4de';
// }
// else if(isset($_SESSION['account']) && $_SESSION['role']=='doctor'){
//    $username = 'lss4de_b';
//    $password = 'Spr1ng2021!!';
//    $host = 'usersrv01.cs.virginia.edu';
//    $dbname = 'lss4de';
// }
// else if(isset($_SESSION['account']) && $_SESSION['role']=='patient'){
//    $username = 'lss4de_c';
//    $password = 'Spr1ng2021!!';
//    $host = 'usersrv01.cs.virginia.edu';
//    $dbname = 'lss4de';
// }


//connecting to leigh's cs server
//connect as the default login to authenticate
// else{
   $username = 'lss4de';
   $password = 'springJefferson22!';
   $host = 'usersrv01.cs.virginia.edu';
   $dbname = 'lss4de';
   // echo "<script>console.log(".isset($_SESSION['role']). ")</script>";
   // echo 'tset';
   // $username = 'lss4de_d';
   // $password = 'Spr1ng2021!!';
   // $host = 'usersrv01.cs.virginia.edu';
   // $dbname = 'lss4de';
// }


//should connect as the login subuser as default to authenticate
//then flip accounts
//literally logout like db.close()

/******************************/

$dsn = "mysql:host=$host;dbname=$dbname";

/** connect to the database **/
try 
{
   $db = new PDO($dsn, $username, $password);   
   
}
catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
{
   // Call a method from any object, 
   // use the object's name followed by -> and then method's name
   // All exception objects provide a getMessage() method that returns the error message 
   $error_message = $e->getMessage();        
}
catch (Exception $e)       // handle any type of exception
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}
?>
