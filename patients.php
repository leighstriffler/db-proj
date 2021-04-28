<?php 
session_start(); 
$_SESSION['user'] = "";
$_SESSION['role'] = 'doctor';
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
    <nav class="navbar navbar-expand navbar-dark">
        <!-- <a class="navbar-brand" href="#"></a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample02">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="patients.php">Patients <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="appts.php">Appointments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="rooms.php">Rooms</a>
            </li>
            </ul>
            <form class="form-inline my-2 my-md-0">
            <input class="form-control" type="text" placeholder="Search">
            </form>
        </div>
        </nav>
</header>

  <!-- Main Page -->
  <body class="page-background">
    <div class="main-page-area">
        <div class="table-container">
            <h1 class="page-title"> Patients </h1>
            <table id="appts-table" class="table table-hover table-sm table-responsive-sm">
                <thead>
                    <tr>
                    <th scope="col"></th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Admit Date</th>
                    <th scope="col">Checkout Date</th>
                    <th scope="col">Insurance</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row"></th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>123-123-1234</td>
                        <td>04/25/2021</td>
                        <td>04/27/2021</td>
                        <td>Cigna</td>
                    </tr>
                    <tr>
                    <th scope="row"></th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>555-555-5555</td>
                        <td>04/15/2021</td>
                        <td>04/30/2021</td>  
                        <td>Aetna</td>
                 
                    </tr>
                    <tr>
                    <th scope="row"></th>
                        <td>Larry</td>
                        <td>Whitmer</td>
                        <td>987-654-3210</td>
                        <td>04/27/2021</td>
                        <td>05/06/2021</td>  
                        <td>Anthem</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="add-row-container">
        <?php if ($_SESSION['role'] == 'doctor'){ } 
            echo '
                <h3 class="heading"> Add Patient </h3>
                <form>
                    <div class="form-row">
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">First Name</label>
                            <input name="inputFirst" type="text" class="form-control form-control-sm" placeholder="First">
                        </div>
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">Last Name</label>
                            <input type="text" class="form-control form-control-sm"" placeholder="Last">
                        </div>
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">Phone Number </label>
                            <input type="text" class="form-control form-control-sm"" placeholder="###-###-####">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="inputInsurance" class="col-form-label col-form-label-sm">Insurance </label>
                            <input type="text" class="form-control form-control-sm" placeholder="Provider">
                        </div>
                        <div class="col">
                            <label for="admitDate" class="col-form-label col-form-label-sm">Admit Date </label>
                            <input name="admitDate" type="date" class="form-control form-control-sm">
                        </div>
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">Checkout Date</label>
                            <input type="date" class="form-control form-control-sm"">
                        </div>
                    </div>
                    <div class="form-row">
                    <button type="submit" class="btn btn-primary add-row-submit">Add Patient</button>
                    </div>
                </form>
            
            '    
        ?>
        </div> 
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

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>