<?php 
 session_start();
 include '../config/hms.config.php';
 if(isset($_POST['submit-logout'])){
    session_unset();
    session_destroy();

    header('Location:../login_patient.php');
    die();
    exit();
 }
 $email= $_SESSION['session_id'];
 $sql = "SELECT * FROM patient WHERE email = '$email'";
 $res = mysqli_query($conn,$sql);
 $patient = mysqli_fetch_assoc($res);

 //fetch doctors in the db
 $sql_doc = "SELECT * FROM doctors";
 $response = mysqli_query($conn,$sql_doc);
 $doctors = mysqli_fetch_all($response,MYSQLI_ASSOC);
 //print_r($doctors);
 //print_r($patient);
 if(isset($_POST['submit-entry'])){
    if(empty($_POST['specialization']) || empty($_POST['doctor-name']) || empty($_POST['appointment_date'])
    || empty($_POST['appointment_time'])){
        header('Location:./appointment_booking.inc.php?error=MissingEntryFees');
        exit();
    }
    else{
        $specialization = $_POST['specialization'];
        $doc_name = $_POST['doctor-name'];
        $fees = $_POST['fees'];
        $date = $_POST['appointment_date'];
        $time = $_POST['appointment_time'];
        $patient_full_name = $patient['first_name'] . ' ' . $patient['last_name'];
        $gender = $patient['gender'];
        $contact = $patient['contact'];
        $email = $patient['email'];

        $specialization = mysqli_real_escape_string($conn,$specialization);
        $doc_name = mysqli_real_escape_string($conn,$doc_name);
        $fees = mysqli_real_escape_string($conn,$fees);
        $date = mysqli_real_escape_string($conn,$date);
        $time = mysqli_real_escape_string($conn,$time);
        $patient_full_name = mysqli_real_escape_string($conn,$patient_full_name);
        $gender = mysqli_real_escape_string($conn,$gender);
        $contact = mysqli_real_escape_string($conn,$contact);
        $email = mysqli_real_escape_string($conn,$email);

        $sql_entry = "INSERT INTO appointments(doctor,consultancy_fees,appointment_date,appointment_time,patient,gender,email,contact)
         VALUES('$doc_name','$fees','$date','$time','$patient_full_name','$gender','$email','$contact')";

         if(mysqli_query($conn,$sql_entry)){
            header('Location:../index_patient.php?createEntrySuccessful');
            exit();
         }
         else{
            header('Location:./appointment_booking.inc.php?error=Error404DB');
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
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
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
            .dashboard_section{
            display: flex;
            justify-content: space-between;
            height: 80vh;
            margin-top: 20px;
        }
        .left_section{
            flex-basis: 20%;
        }
        .left_section li{
            padding: 12px 20px;
            cursor: pointer;
            list-style: none;
            color: #000;
        }
        .left_section li a{
            text-decoration: none;
            padding: 12px 20px;
            cursor: pointer;
            list-style: none;
            color: #000;
            width: 100%;
        }
        .left_section li a:hover{
            background-color: rgb(64, 7, 117);
            color: #fff;
            padding: 12px 20px;
        }
        .right_section{
            flex-basis: 76%;
        }
        .right_section h1{
            text-align: left;
            margin-left: 20%;
        }
        .form-box{
            border: 1px solid grey;
            padding: 10px 12px;
        }
        .input-box{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }
        .input-box input{
            width:300px;
            height: 40px;
            flex-basis: 55%;
            border: 2px solid #000;
            border-radius: 10px;
        }
        .input-box select{
            width:350px;
            height: 45px;
            flex-basis: 55%;
            border-radius: 10px;
            border: 2px solid #000;
        }
        .input-box label{
            flex-basis: 40%;
        }
        .input-box button{
            background-color: rgb(64, 7, 117);
            width: 50%;
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
    <section class="apppointment">
    <div class="nav">
        <h2><img src="../images/hospital.png" style="height: 20px;width:20px"/>HOSPITAL MANAGEMENT SYSTEM</h2>
        <div class="right">
            <li>HOME</li>
            <li>CONTACT</li>
            <form action="./logout.php" method="POST">
                <button name="submit-logout" type="submit">LOGOUT</button>
            </form>
        </div>
    </div>
    <div class="dashboard_section">
        <div class="left_section">
            <a href="../index_patient.php"><img src="../images//arrow-back.png" style="width:20px;height:20px"/></a>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Book Appointment</a></li>
            <li><a href="#">Appointment History</a></li>
            <li><a href="#">Prescription</a></li>
        </div>
        <div class="right_section">
            <h1>Welcome <?php echo $patient['first_name'];  echo '  ' . $patient['last_name']?></h1>
            <div class="form-box">
                <h3>Book Appointment</h3>
               <form action="./appointment_booking.inc.php" method="POST">
                    <div class="input-box">
                        <label>Specialization</label>
                        <select name="specialization">
                            <option>Select specialization</option>
                            <?php foreach($doctors as $doctor) : ?>
                                <option value="<?php echo $doctor['specialization']?>"><?php echo $doctor['specialization']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="input-box">
                        <label>Doctors</label>
                        <select name="doctor-name">
                            <option>Select Doctor</option>
                            <?php foreach($doctors as $doctor) : ?>
                                <option value="<?php echo $doctor['name']?>"><?php echo $doctor['name']; echo '-' . $doctor['specialization']?></option>
                                <?php endforeach?>
                        </select>
                    </div>
                    <div class="input-box">
                        <label>Consultancy Fees</label>
                        <input type="text" readonly value="$450/session" name="fees"/>
                    </div>
                    <div class="input-box">
                        <label>Appointment Date</label>
                        <input type="date" name="appointment_date"/>
                    </div>
                    <div class="input-box">
                        <label>Appointment Time</label>
                        <input type="time" name="appointment_time"/>
                    </div>
                    <div class="input-box">
                        <button type="submit" name="submit-entry">Create Entry</button>
                    </div>
               </form>
            </div>
        </div>
    </div>
    </section>
</body>
</html>