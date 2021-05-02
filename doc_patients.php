<?php 
session_start(); 
if ($_SESSION['role']!="doctor" & $_SESSION['role']!="Doctor"){
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang='en'>
  <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css" type="text/css">
      <title> Doctor Portal </title>
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
                <a class="nav-link" href="doc_patients.php">Patients <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="doc_appts.php">Appointments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="doc_rooms.php">Rooms</a>
            </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <li class="nav-item"><a class="nav-link"> User:  <?php echo $_SESSION['user']; ?></a> </li>
                    <a class="nav-link" href="login.php">Log Out</a>
                </li>
            </ul>
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
                    <th scope="col">First</th>
                    <th scope="col">Middle</th>
                    <th scope="col">Last</th>
                    <th scope="col">Admit Date</th>
                    <th scope="col">Checkout Date</th>
                    <th scope="col">Insurance</th>
                    </tr>
                </thead>
                <tbody id='table-body'>
                    
                    <?php
                    require('connectdb.php');

                    global $db;
                    $query = "select * from doc_patients_view WHERE d_ID=:ID";
                    $statement = $db->prepare($query); 
                    $statement->bindValue(':ID', $_SESSION['d_ID']);
                    $statement->execute();
                    $results = $statement->fetchAll();
                    $statement->closecursor();
                    foreach($results as $result){
                        echo "<tr>";
                        echo        "<td>" . $result['firstname'] . '</td>'; 
                        echo        "<td>" . $result['middlename'] . '</td>';
                        echo        "<td>" . $result['lastname'] . "</td>" ;
                        echo        "<td>" . $result['date_admitted']   . "</td>";
                        echo        "<td>" . $result['date_checkout']   . "</td>";
                        echo        "<td>" . $result['insurance']   . "</td>";
                        echo "</tr>";
                    }            
                    ?>
                </tbody>
            </table>
        </div>
        <div class="add-row-container">

                <h3 class="heading"> Add Patient </h3>
                <form method='POST'>
                    <div class="form-row">
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">First Name</label>
                            <input name="inputFirst" type="text" class="form-control form-control-sm"  required>
                        </div>
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">Middle Name</label>
                            <input name='inputMiddle' type="text" class="form-control form-control-sm" required>
                        </div>
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">Last Name</label>
                            <input name='inputLast' type="text" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="inputInsurance" class="col-form-label col-form-label-sm">Insurance </label>
                            <input name='insurance' type="text" class="form-control form-control-sm" placeholder="Provider" required>
                        </div>
                        <div class="col">
                            <label for="admitDate" class="col-form-label col-form-label-sm">Admit Date </label>
                            <input name='adate' name="admitDate" type="date" class="form-control form-control-sm" required>
                        </div>
                        <div class="col">
                            <label for="inputFirst" class="col-form-label col-form-label-sm">Checkout Date</label>
                            <input name='cdate' type="date" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div id='credentials' class='form-row'>
                        <div class="col">
                            <label for="user_ID" class="col-form-label col-form-label-sm">Create Patient User ID </label>
                            <input name="user_ID" type="text" class="form-control form-control-sm" required>
                        </div>
                        <div class="col">
                            <label for="password" class="col-form-label col-form-label-sm">Create Patient Temporary Password</label>
                            <input name='password' type="text" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary add-row-submit" onclick='<?php insertPatient()?>'>Add New Patient </button>
                    </div>
                    </div>
                </form>
        </div> 
    </div>
  </body>

  <script>

      function toggleCreds(){
        $box=document.getElementById('credentials');
        $box.style.display='block';
      }

    
  </script>
  <?php
  //insert patient, patient doc, users tables
  function insertPatient(){
        require('connectdb.php');
    
        $query = "INSERT INTO users (ID, pass, role) 
        VALUES(:p_ID, :password, :role) ";
        $statement = $db->prepare($query); 
        $statement->bindValue(':p_ID', $_POST['user_ID']);
        $statement->bindValue(':password', $_POST['password']);
        $statement->bindValue(':role', 'patient');
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closecursor();

        global $db;
        $query = "INSERT INTO patient (p_ID, firstname, middlename, lastname, insurance, date_admitted, date_checkout) 
                    VALUES(:p_ID, :f, :m, :l, :insur, :dadm, :dch) ";
        $statement = $db->prepare($query); 
        $statement->bindValue(':p_ID', $_POST['user_ID']);
        $statement->bindValue(':f', $_POST['inputFirst']);
        $statement->bindValue(':m', $_POST['inputMiddle']);
        $statement->bindValue(':l', $_POST['inputLast']);
        $statement->bindValue(':insur', $_POST['insurance']);
        $statement->bindValue(':dadm', $_POST['adate']);
        $statement->bindValue(':dch', $_POST['cdate']);
        $statement->execute();
        $results = $statement->fetchAll();
        echo $results;
        $statement->closecursor();

        $query = "INSERT INTO patient_doc (p_ID, d_ID) 
                    VALUES(:p_ID, :id) ";
        $statement = $db->prepare($query); 
        $statement->bindValue(':p_ID', $_POST['user_ID']);
        $statement->bindValue(':id', $_SESSION['d_ID']);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closecursor();
  }
   
  ?>

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>