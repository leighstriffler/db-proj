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
      <title> Doctor Portal </title>
  </head>

  <!-- Navigation Bar -->
  <header>
    <nav class="navbar navbar-expand navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link" href="doc_patients.php">Patients</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="doc_appts.php">Appointments <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="doc_rooms.php">Rooms</a>
            </li>
            </ul>
            <form class="form-inline my-2 my-md-0">
            <input class="form-control" type="text" placeholder="Search">
            </form>
        </div>
        </nav>
  <header>

  <!-- Main Page -->
  <body class="page-background">
    <div class="main-page-area">
        <div class="table-container">
        <div class="table-container">
            <h1 class="page-title"> Appointments </h1>
            

            <!-- Display Doctor Appointments -->
            <button id='sort-button' onclick='sortDateDesc()'>Sort Appointments by Date</button>
            <table id="doc-appts-table" class="table table-hover table-sm table-responsive-lg">
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
                $query = "select * from doc_appts_view WHERE d_ID=:ID";
                $statement = $db->prepare($query); 
                $statement->bindValue(':ID', $_SESSION['d_ID']);
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
                    echo        "<td> <button id='delete-button' class='button'>Delete</button</td>";
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
    $query = "select * from doc_appts_view WHERE d_ID=:ID ORDER BY date DESC";
    $statement = $db->prepare($query); 
    $statement->bindValue(':ID', $_SESSION['d_ID']);
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