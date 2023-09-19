<?php 

if(isset($_POST['submit-logout'])){
    session_unset();
    session_destroy();
    header('Location:./login_patient.php');
    die();
    exit();
 }