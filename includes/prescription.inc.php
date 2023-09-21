<?php 
 session_start();
 
 include '../config/hms.config.php';
 if(isset($_POST['submit-logout'])){
    session_unset();
    session_destroy();

    header('Location:../index_doctor.php');
    exit();
 }
$email = $_SESSION['doctor_session'];
 $sql = "SELECT * FROM doctors WHERE email='$email'";
 $res = mysqli_query($conn,$sql);
 $doctor_info = mysqli_fetch_assoc($res);

 $id = $_POST['name-to-prescribe'];
 $sqli_appointment  = "SELECT * FROM appointments WHERE `id` = '$id'";
 $response  = mysqli_query($conn,$sqli_appointment);
 $patient_appointment = mysqli_fetch_assoc($response);
 print_r($patient_appointment);
    //echo $patient_name;
 if(isset($_POST['submit-prescription'])){
   if(empty($_POST['disease']) || empty($_POST['allergies']) || empty($_POST['prescription'])){
     header('Location:./prescription.inc.php?error=MissingInputFields');
     exit();
   }
   else{
    $disease = $_POST['disease'];
    $allergy = $_POST['allergies'];
    $prescription = $_POST['prescription'];
    $patient_name = $patient_appointment['patient'];
    $appointment_date = $patient_appointment['appointment_date'];
    $appointment_time = $patient_appointment['appointment_time'];

    $patient_name = mysqli_real_escape_string($conn,$patient_name);
    $appointment_date = mysqli_real_escape_string($conn,$appointment_date);
    $appointment_time = mysqli_real_escape_string($conn,$appointment_time);
    $disease = mysqli_real_escape_string($conn,$disease);
    $allergy = mysqli_real_escape_string($conn,$allergy);
    $prescription = mysqli_real_escape_string($conn,$prescription);


    $sqli_prescription = "INSERT INTO prescription(disease,allergy,prescription,patient_name,appointments_date,appointment_time)
    VALUES('$disease','$allergy','$prescription','$patient_name','$appointment_date','$appointment_time')";
  //  echo $patient_name . "-" . $appointment_date . "-" . $appointment_time;
     if(mysqli_query($conn,$sqli_prescription)){
         header('Location:../index_doctor.php?PrescriptionEntry=Success');
         exit();
     }
     else{
         header('Location:./prescription.inc.php?error=Error404DbSTMT');
         exit();
     }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <style>
         *{
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
           }
           .nav{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5px;
        }
        .nav .right{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav .right li{
            list-style: none;
            padding: 10px 12px;
        }
        .prescription-form{
            background-color: #fff;
        }
        .prescription-form h1{
            text-align: center;
        }
        .form{
            width:1000px;
            height: max-content;
            margin-left: 10%;
            text-align: left;
        }
        .form textarea{
            height:150px;
            width: 100%;
            margin: 15px 0;
            border-radius: 10px;
            padding: 5px 10px;
        }
        .form textarea:focus{
            border: 2px solid green;
        }
        .form button{
            background-color: rgb(64, 7, 117);
            width: 100%;
            height: 40px;
            color: #fff;
            cursor: pointer;
            border: none;
            outline: none;
            border-radius: 10px;
            text-align: center;
        }
   </style>
</head>
<body>
    <section class="prescription-form">
       <div class="nav">
            <h2>HOSPITAL MANAGEMENT SYSTEM</h2>
            <div class="right">
                <li>HOME</li>
                <li>CONTACT</li>
                <form action="./prescription.inc.php" method="POST">
                    <button name="submit-logout" type="submit">LOGOUT</button>
                </form>
            </div>
        </div>
         <h1>Welcome Dr : <?php echo htmlspecialchars($doctor_info['name'])?></h1>
         <form action="./prescription.inc.php" method="POST" class="form">
           <label>Disease</label>
           <br/>
           <textarea name="disease"></textarea>
           <br/>
           <label>Allergies</label>
           <br/>
           <textarea name="allergies"></textarea>
           <br/>
           <label>Prescription</label>
           <br/>
           <textarea name="prescription"></textarea>
           <br/>
           <button type="submit" name="submit-prescription">Create Prescription Entry</button>
         </form>
    </section>
</body>
</html>