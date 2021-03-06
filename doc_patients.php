<?php 
session_start(); 
if ($_SESSION['role']!="doctor" & $_SESSION['role']!="Doctor"){
    header('location: login.php');
}
//insert patient, patient doc, users tables
if(isset($_POST["user_ID"])){
      require('connectdb.php');
  
      global $db;
        $query = "CALL add_patient(:p_ID, :firstname, :middlename, :lastname, :insurance, :dateadm, :datecho, :doc_id, :pass, :role);";
        $statement = $db->prepare($query); 
        $statement->bindValue(':p_ID', $_POST['user_ID']);
        $statement->bindValue(':firstname', $_POST['inputFirst']);
        $statement->bindValue(':middlename', $_POST['inputMiddle']);
        $statement->bindValue(':lastname', $_POST['inputLast']);
        $statement->bindValue(':insurance', $_POST['insurance']);
        $statement->bindValue(':dateadm', $_POST['adate']);
        $statement->bindValue(':datecho', $_POST['cdate']);
        $statement->bindValue(':doc_id', $_SESSION['d_ID']);
        $statement->bindValue(':pass', md5($_POST['password']));
        $statement->bindValue(':role', 'patient');
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closecursor();
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
                <a class="nav-link" href="doc_patients.php">Patient List <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="doc_appts.php">Appointments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="doc_overnight.php">Overnight Patients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="doc_consults.php">Consultations</a>
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
            <h1 class="page-title table-title"> Patients </h1>
            <table id="appts-table" class="table table-hover table-sm table-responsive-sm">
                <thead>
                    <tr>
                    <th scope="col">First</th>
                    <th scope="col">Middle</th>
                    <th scope="col">Last</th>
                    <th scope="col">Admission Date</th>
                    <th scope="col">Est. Checkout Date</th>
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

    </div>
  </body>

  <script>
      function toggleCreds(){
        $box=document.getElementById('credentials');
        $box.style.display='block';
      }
  </script>



  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>