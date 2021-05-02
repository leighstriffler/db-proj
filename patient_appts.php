<?php 
session_start(); 

if(isset($_POST['inputFirst'])){
    require('connectdb.php');
    global $db;
    $query = "CALL update_patient_info(:p_ID, :firstname, :middlename, :lastname, :insurance);";
    $statement = $db->prepare($query); 
    $statement->bindValue(':p_ID', $_SESSION['user']);
    $statement->bindValue(':firstname', $_POST['inputFirst']);
    $statement->bindValue(':middlename', $_POST['inputMiddle']);
    $statement->bindValue(':lastname', $_POST['inputLast']);
    $statement->bindValue(':insurance', $_POST['insurance']);  
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();

}

if(isset($_POST['appt_ID'])){

    require('connectdb.php');
    echo 'hi';
        global $db;
        $query = "CALL delete_appt(:p_id, :appointmentid) ";
        $statement = $db->prepare($query); 
        $statement->bindValue(':p_id', $_SESSION['user_ID']);
        $statement->bindValue(':appointmentid', $_POST['appt_ID']);
        $statement->execute();
        $results = $statement->fetchAll();
        echo $results;
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
      <title> Patient Portal </title>
  </head>

  <header>
    <nav class="navbar navbar-expand navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link"> User:  <?php echo $_SESSION['user']; ?></a> </li>
                <li class="nav-item">
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
            <h1 class="page-title"> Patient Portal </h1>
            <h4 class="table-title">Personal Information</h4>
            <button id="change-user-info-btn" class = "btn btn-primary" onclick="showEdit()"> Change User Info </button>
            <table id="patient-info-table" class="table table-hover table-sm table-responsive-sm">

                <thead>
                    <tr>
                        <th scope='col'>First Name</th>
                        <th scope="col">Middle Initial</th>
                        <th scope="col">Last</th>
                        <th scope='col'>Insurance</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    require('connectdb.php');

                    global $db;
                //display their contact info
                $query = "select * from patient_info_view WHERE p_ID=:user ";
                $statement = $db->prepare($query); 
                $statement->bindValue(':user', $_SESSION['user']);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closecursor();
                foreach($results as $result){
                    echo "<tr>";
                    echo        "<td>" . $result['firstname'] . '</td>'; 
                    echo        "<td>" . $result['middlename'] . '</td>';
                    echo        "<td>" . $result['lastname'] . "</td>" ;
                    echo        "<td>" . $result['insurance']   . "</td>";
                    echo "</tr>";
                }            
                    ?>
                </tbody>
            </table>
        </div>
        <div id="update-user-container">
            <h4> Update User Info </h4>
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
                    <div class="col">
                        <label for="inputInsurance" class="col-form-label col-form-label-sm">Insurance </label>
                        <input name='insurance' type="text" class="form-control form-control-sm" placeholder="Provider" required>
                    </div>
                </div>
                <div class="form-row">
                    <button type="submit" class="btn btn-primary add-row-submit" onclick="<?php $_SESSION['apptdelete']=true; ?>">Change Info </button>
                </div>
            </form>
        </div> 
        <div class="table-container">
            <h4 class="table-title">My Appointments</h4>
            <button class="btn btn-primary" id='sort-button' onclick='sortDateDesc()'>Sort Appointments by Date</button>
            <!-- Display Patient Appointments -->
            <table id="patient-appts-table" class="table table-hover table-sm table-responsive-lg">
                <thead>
                        <tr>
                            <th scope='col'>Appointment Date</th>
                            <th scope='col'>Appointment Time</th>
                            <th scope='col'>Doctor</th>
                            <th scope='col'>Delete</th> 
                        </tr>
                </thead>
                <tbody id='table-body'>

                <?php
                require('connectdb.php');

                global $db;

                //display their appts
                $query = "select * from patient_appts_view WHERE p_ID=:user";
                $statement = $db->prepare($query); 
                $statement->bindValue(':user', $_SESSION['user']);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closecursor();
                foreach($results as $result){
                    $time=date_create($result['time']);
                    $apptid=$result['appt_ID'];
                    echo "<tr>";
                    echo        "<td>" . $result['date']   . "</td>";
                    echo        "<td>" . date_format($time, 'h:ia')   . "</td>";
                    echo        "<td>" . "Dr. " . $result['doctor.lastname']   . "</td>";
                    // echo        "<td>" . $result['room_num'] . "</td>"; 
                    echo        "<td>" ;
                    echo             "<form action='patient_appts.php'>" .
                               "<input type='hidden' name='appt_ID' value='" .$apptid. "'>" .
                                "<button class='btn btn-primary' id='delete-button'>Delete</button</td>";
                                "</form>";
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
<script>

    function showEdit(){
    $box=document.getElementById('update-user-container');
    $box.style.display='block';
    }

</script>
 <?php

 function sortTable(){
    
    require('connectdb.php');
    
    global $db;
    $query = "select * from patient_appts_view WHERE p_ID=:user ORDER BY date DESC";
    $statement = $db->prepare($query); 
    $statement->bindValue(':user', $_SESSION['user']);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();

    //display the sorted table
    foreach($results as $result){
        echo "<tr>";
        echo        "<td>" . $result['date']   . "</td>";
        echo        "<td>" . $result['time']   . "</td>";
        echo        "<td>" . $result['room_num'] . "</td>"; 
        echo        "<td> <button id='delete-button' class='btn btn-primary'>Delete</button</td>";
        echo "</tr>";
    } 
 }
 ?>

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>