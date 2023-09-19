<?php 
session_start();
include '../config/hms.config.php';

$email = $_SESSION['session_id'];

 $sql = "SELECT * FROM patient WHERE email = '$email'";
 $res = mysqli_query($conn,$sql);
 $patient_detail = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <style>

   </style>
</head>
<body>
    <section class="appointment_form">
        <h3>Welcome <?php echo $patient_detail['first_name']; echo ' ' . $patient_detail['last_name']?></h3>
    </section>
</body>
</html>