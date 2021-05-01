<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang='en'>
  <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- required to handle IE -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css" type="text/css">
      <title> Patient Portal </title>
  </head>

  <!-- Main Page -->
  <body class="page-background">
    <div class="main-page-area">
        <div class="table-container">
        <div class="table-container">
            <h1 class="page-title"> Patient Portal </h1>
            
            <h4>Personal Information</h4>
            <table id="patient-info-table" class="table table-hover table-sm table-responsive-lg">

                <thead>
                    <tr>
                        <th scope='col'>First Name</th>
                        <th scope="col">Middle Initial</th>
                        <th scope="col">Last</th>
                        <th scope='col'>Insurance</th>
                        <th scope='col'>SSN</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    require('connectdb.php');

                    global $db;
                //display their contact info
                $query = "select * from patient_info_view WHERE username=:user ";
                $statement = $db->prepare($query); 
                $statement->bindValue(':user', $_SESSION['user']);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closecursor();
                foreach($results as $result){
                    echo "<tr>";
                    echo        "<td>" . $result['f_name'] . '</td>'; 
                    echo        "<td>" . $result['m_init'] . '</td>';
                    echo        "<td>" . $result['l_name'] . "</td>" ;
                    echo        "<td>" . $result['insurance']   . "</td>";
                    echo        "<td>" . $result['SS']   . "</td>";
                    echo "</tr>";
                }            
                    ?>
                </tbody>
            </table>

            <h4>Appointments</h4>
            <button id='sort-button' onclick='sortDateDesc()'>Sort Appointments by Date</button>
            <!-- Display Patient Appointments -->
            <table id="patient-appts-table" class="table table-hover table-sm table-responsive-lg">
                <thead>
                        <tr>
                            <th scope="col">First</th>
                            <th scope="col">Middle Initial</th>
                            <th scope="col">Last</th>
                            <th scope='col'>Appointment Date</th>
                            <th scope='col'>Appointment Time</th>
                            <th scope='col'>Room Number</th>
                            <th scope='col'>Delete</th> 
                        </tr>
                </thead>
                <tbody id='table-body'>

                <?php
                require('connectdb.php');

                global $db;

                //display their appts
                $query = "select * from patient_appts_view WHERE username=:user";
                $statement = $db->prepare($query); 
                $statement->bindValue(':user', $_SESSION['user']);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closecursor();
                foreach($results as $result){
                    echo "<tr>";
                    echo        "<td>" . $result['f_name'] . '</td>'; 
                    echo        "<td>" . $result['m_init'] . '</td>';
                    echo        "<td>" . $result['l_name'] . "</td>" ;
                    echo        "<td>" . $result['date']   . "</td>";
                    echo        "<td>" . $result['time']   . "</td>";
                    echo        "<td>" . $result['room_num'] . "</td>"; 
                    echo        "<td> <button id='delete-button' class='button' name='sortDateDesc'>Delete</button</td>";
                    echo "</tr>";
                }            
                ?>
                </tbody>
            </table>
        </div>
    </div>
  </body>
<script>
    //have to get the dom element for the table to sort and display it
    function sortDateDesc(){
        $apptstable=document.getElementById('table-body');
        $apptstable.innerHTML= "<?php sortTable()?>";
    }

</script>
 <?php

 function sortTable(){
    
    require('connectdb.php');
    
    global $db;
    $query = "select * from patient_appts_view WHERE username=:user ORDER BY date DESC";
    $statement = $db->prepare($query); 
    $statement->bindValue(':user', $_SESSION['user']);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();

    //display the sorted table
    foreach($results as $result){
        echo "<tr>";
        echo        "<td>" . $result['f_name'] . '</td>'; 
        echo        "<td>" . $result['m_init'] . '</td>';
        echo        "<td>" . $result['l_name'] . "</td>" ;
        echo        "<td>" . $result['date']   . "</td>";
        echo        "<td>" . $result['time']   . "</td>";
        echo        "<td>" . $result['room_num'] . "</td>"; 
        echo        "<td> <button id='delete-button' class='button'>Delete</button</td>";
        echo "</tr>";
    } 
 }
 ?>

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>