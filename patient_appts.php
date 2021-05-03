<?php 
session_start(); 
if(!isset($_SESSION['user']) | $_SESSION['user']==""){
    header('Location: login.php');
}

//echo var_dump($_REQUEST);

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
if(isset($_POST['action'])){
    require('connectdb.php');
    global $db;
    if($_POST['action']== "add-new-appt"){
        $query = "CALL add_appt(:p_ID, :apptdate, :appttime, :d_ID);";
        $statement = $db->prepare($query); 
        $statement->bindValue(':p_ID', $_SESSION['p_ID']);
        $statement->bindValue(':apptdate', $_POST['apptdate']);
        $statement->bindValue(':appttime', $_POST['appttime']);
        $statement->bindValue(':d_ID', $_POST['d_ID']);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closecursor();
    }
    else if($_POST['action']== "delete"){
        $query = "CALL delete_appt(:p_id, :appointmentid) ";
        $statement = $db->prepare($query); 
        $statement->bindValue(':p_id', $_SESSION['user']);
        $statement->bindValue(':appointmentid', $_POST['appt_ID']);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closecursor();
    }
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
        <button type="button" class="navbar-toggler" type="button" data-toggle="collapse">
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
            <button type="button" id="change-user-info-btn" class = "btn btn-primary" onclick="showEdit()"> Change User Info </button>
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
            <form></form>
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
                    <button type="submit" class="btn btn-primary add-row-submit">Change Info </button>
                </div>
            </form>
        </div> 
        <div id="appts-container" class="table-container">
            <h4 class="table-title">My Appointments</h4>
            <button type="button" class="btn btn-primary" id='sort-button' onclick='sortDateDesc()'>Sort Appointments by Date</button>
            <!-- Display Patient Appointments -->
            <table id="patient-appts-table" class="table table-hover table-sm table-responsive-sm">
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
                    echo        "<td>" ;
                    echo       "<form></form>";
                    echo       "<form method='POST'>" .
                               "<input type='hidden' name='appt_ID' value='" .$apptid. "'>" .
                                "<button type='submit' name='action' class='btn btn-primary' value='delete'>Delete</button></td>";
                                "</form>";
                    echo "</tr>";
                }            
                ?> 
                </tbody>
            </table>
        </div>
        <button type="button" id="add-appt-btn" class = "btn btn-primary" onclick="showAddAppt()"> Make an Appointment </button>
        <div id="add-appt-container">
                <h3> Make an Appointment </h3>
                <form></form>
                <form id="add-appt-form" method='POST'>
                    <div  class="form-row">
                        <div class="col">
                            <label for="date" class="col-form-label col-form-label-sm"> Date </label>
                            <input name='apptdate' name="admitDate" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control form-control-sm" >
                        </div>
                        <div class="col">
                            <label for="appttime" class="col-form-label col-form-label-sm"> Time </label>
                            <select name="appttime" class="form-select form-control form-control-sm" >
                                <option selected="selected" value="">Start Time</option>
                                <option value="10:00:00">10:00am</option>
                                <option value="10:15:00">10:15am</option>
                                <option value="10:30:00">10:30am</option>
                                <option value="10:45:00">10:45am</option>
                                <option value="11:00:00">11:00am</option>
                                <option value="11:15:00">11:15am</option>
                                <option value="11:30:00">11:30am</option>
                                <option value="11:45:00">11:45am</option>
                                <option value="12:00:00">12:00pm</option>
                                <option value="12:15:00">12:15pm</option>
                                <option value="12:30:00">12:30pm</option>
                                <option value="12:45:00">12:45pm</option>
                                <option value="13:00:00">1:00pm</option>
                                <option value="13:15:00">1:15pm</option>
                                <option value="13:30:00">1:30pm</option>
                                <option value="13:45:00">1:45pm</option>
                                <option value="14:00:00">2:00pm</option>
                                <option value="14:15:00">2:15pm</option>
                                <option value="14:30:00">2:30pm</option>
                                <option value="14:45:00">2:45pm</option>
                                <option value="15:00:00">3:00pm</option>
                                <option value="15:15:00">3:15pm</option>
                                <option value="15:30:00">3:30pm</option>
                                <option value="15:45:00">3:45pm</option>
                                <option value="16:00:00">4:00pm</option>
                                <option value="16:15:00">4:15pm</option>
                                <option value="16:30:00">4:30pm</option>
                                <option value="16:45:00">4:45pm</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="d_ID" class="col-form-label col-form-label-sm"> Doctor </label>
                            <select name="d_ID" class="form-select form-control form-control-sm">
                                <?php 
                                    require('connectdb.php');
                                    global $db;
                                    //display their contact info
                                    $query = "select * FROM doctor";
                                    $statement = $db->prepare($query); 
                                    $statement->bindValue(':user', $_SESSION['user']);
                                    $statement->execute();
                                    $results = $statement->fetchAll();
                                    $statement->closecursor();
                                    foreach($results as $result){
                                        echo        "<option value=" . $result['d_ID'] . ">" . $result['firstname'] . " " . $result['lastname'] . '</option>'; 
                                    }    
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <button for="add-appt-form" type="Submit" name="action" value="add-new-appt" class="btn btn-primary add-row-submit">Add New Appointment </button>
                    </div>
                </form>
            </div> 
    </div>
  </body>
<script>
    //have to get the dom element for the table to sort and display it
    function sortDateDesc(){
        console.log("SORTING TABLE");
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
<script>
    function showAddAppt(){
    $button=document.getElementById('add-appt-btn');
    $button.style.display='none';
    $addAppt=document.getElementById('add-appt-container');
    $addAppt.style.display='block';
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
        $time=date_create($result['time']);
        $apptid=$result['appt_ID'];
        echo "<tr>";
        echo        "<td>" . $result['date']   . "</td>";
        echo        "<td>" . date_format($time, 'h:ia')   . "</td>";
        echo        "<td>" . "Dr. " . $result['doctor.lastname']   . "</td>";
        echo        "<td>" ;
        echo         "<form></form>";
        echo       "<form method='POST' action=''>" .
                   "<input type='hidden' name='appt_ID' value='" .$apptid. "'>" .
                    "<button type='submit' name='action' class='btn btn-primary' value='delete'>Delete</button></td>";
                    "</form>";
        echo "</tr>";
    }   
 }
 ?> 

  <!-- Bootstrap Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</html>