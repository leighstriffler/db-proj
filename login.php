<?php 
session_start(); 
$_SESSION['role'] = "";
$_SESSION['user'] = "";
$_SESSION['n_ID'] = "";
$_SESSION['d_ID'] = "";
$_SESSION['p_ID'] = "";
?>

<!DOCTYPE html>
<html lang='en'>
  <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css" type="text/css">
      <title> Login </title>
  </head>

  <!-- Navigation Bar -->
  <header>
  <header>

  <!-- Main Page -->
  <body class="page-background">
    <div class="main-page-area" id="login-box">
      <img id="login-logo" src="logo3.png"></img>
      <h1 class="page-title" id="login-title"> Hospital Portal Login </h1>
      <form method="POST">
        <div class="form-group text-center">
          <!-- <label class="login-label" for="inputUser">Username</label> -->
          <input name='username' type="username" class="form-control login-input" id="username" placeholder="Username" required>
        </div>
        <div class="form-group text-center">
          <!-- <label class="login-label" for="inputPassword">Password</label> -->
          <input name='password' type="password" class="form-control login-input" id="password" placeholder="Password" required>
        </div>
        <div class="text-center">
          <button id="login-button" type="submit" class="btn btn-primary text-center">Log In</button>
        </div>
        </form>
    </div>
  </body>


  <?php 
    // checks that a user with the given username and password exists, and sets the session variables -->
    require('connectdb.php');
    if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['username']) > 0){
      $user = trim($_POST['username']);
      $pwd = md5(trim($_POST['password']));

      # Check that the username and password combo are correct (that they exist in the users table)
      global $db;
      $query = "select * from lss4de.users WHERE ID=:id AND pass=:pwd LIMIT 1";
      
      //execute as 'LoginUser' 
      $statement = $db->prepare($query); 
      $statement->bindValue(':id', $user);
      $statement->bindValue(':pwd', $pwd);
      $statement->execute();
      
      $results = $statement->fetchAll();
      $statement->closecursor();
      if (count($results) > 0){
        $_SESSION['user'] = $user; 
        $_SESSION['role']=$results[0]['role'];
        $_SESSION['apptdelete']=false;

        if($_SESSION['role']=='patient'){
          $_SESSION['p_ID'] = $results[0]['ID'];
          $_SESSION['account']=true;
          // $db=null;//close connection
          // require('connectdb.php');
          header('Location: patient_appts.php');
        }
        if($_SESSION['role']=='doctor'){
          $_SESSION['d_ID']=$results[0]['ID'];
          $_SESSION['account']=true;
          // $db=null;//close connection
          // include('connectdb.php');
          header('Location: doc_appts.php');
        }
        if($_SESSION['role']=='nurse'){
          $_SESSION['n_ID']=$results[0]['ID'];
          header('Location: nurse_overnight.php');
        }
          // $_SESSION['account']=true;
          // $db=null;//close connection
//           include('connectdb.php');

//            $username = 'lss4de_a';
//            $password = 'Spr1ng2021!!';
//           $host = 'usersrv01.cs.virginia.edu';
//           $dbname = 'lss4de';
//           $dsn = "mysql:host=$host;dbname=$dbname";

// /** connect to the database **/
//           try 
//           {
//             $db = new PDO($dsn, $username, $password);   
            
//           }
//           catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
//           {
//             // Call a method from any object, 
//             // use the object's name followed by -> and then method's name
//             // All exception objects provide a getMessage() method that returns the error message 
//             $error_message = $e->getMessage();        
//           }
//           catch (Exception $e)       // handle any type of exception
//           {
//             $error_message = $e->getMessage();
//             echo "<p>Error message: $error_message </p>";
//           }
                   
//         }
      }
      
    }
  ?>

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>