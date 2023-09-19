<?php
  $conn = mysqli_connect('localhost','jimmy','test123','hospital_db');
  if(!$conn){
    echo 'Error Connecting to DB' . mysqli_connect_error();
  }
?>