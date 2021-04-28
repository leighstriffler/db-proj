<?php 
session_start(); 
$_SESSION['user'] = "";
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
      <form>
        <div class="form-group text-center">
          <!-- <label class="login-label" for="inputUser">Username</label> -->
          <input type="username" class="form-control login-input" id="inputUser" placeholder="Username" required>
        </div>
        <div class="form-group text-center">
          <!-- <label class="login-label" for="inputPassword">Password</label> -->
          <input type="password" class="form-control login-input" id="inputPassword" placeholder="Password" required>
        </div>
        <div class="text-center">
          <button id="login-button" type="submit" class="btn btn-primary text-center">Log In</button>
        </div>
        </form>
    </div>
  </body>

  <?php
    require_once('./library.php');
    $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
    // Check connection
    if (mysqli_connect_errno()) {
      echo("Can't connect to MySQL Server. Error code: " .
      mysqli_connect_error());
      return null;
    }
?>

  <!-- <?php 
    // checks that a user with the given username and password exists, and sets the session variables -->
    require('connectdb.php');
    if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['username']) > 0){
      $user = trim($_POST['username']);
      $pwd = md5(trim($_POST['password']));

      # Check that the username and password combo are correct (that they exist in the users table)
      global $db;
      $query = "select username, password from users WHERE username=:user AND password=:pwd LIMIT 1";
      $statement = $db->prepare($query); 
      $statement->bindValue(':user', $user);
      $statement->bindValue(':pwd', $pwd);
      $statement->execute();
      $results = $statement->fetchAll();
      $statement->closecursor();
      if (count($results) > 0){
        $_SESSION['user'] = $user; 
        $_SESSION['toggle']=false;
        echo $_SESSION['user'];
        header('Location: myprofile.php');
      }
      else{ //username and password not found
        echo "<script>  showErrorBox(); </script>";
      }
    }
  ?> -->

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>