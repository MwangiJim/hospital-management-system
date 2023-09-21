<?php 
include '../config/hms.config.php';
  if(isset($_POST['appointment-to-cancel'])){
    $id = $_POST['id-to-cancel'];
    $sql = "DELETE FROM appointments WHERE id = $id";
    if(mysqli_query($conn,$sql)){
        header('Location:./viewappointments.inc.php?delete=successfull');
        exit();
    } 
    else{
        header('Location:./viewappointments.inc.php?error=UnableToDeleteItemId = ' . $id);
        exit();
    }
  }
?>