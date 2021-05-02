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
      <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
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
      echo $pwd;


      # Check that the username and password combo are correct (that they exist in the users table)
      global $db;
      $query = "select * from users WHERE ID=:id AND pass=:pwd LIMIT 1";
      
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
          header('Location: patient_appts.php');
        }
        if($_SESSION['role']=='doctor'){
          $_SESSION['d_ID']=$results[0]['ID'];
          header('Location: doc_appts.php');
        }
        if($_SESSION['role']=='nurse'){
          $_SESSION['n_ID']=$results[0]['ID'];
          header('Location: nurse_overnight.php');
        }
      }
      
    }
  ?>

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>