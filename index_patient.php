<?php 
 session_start();
 include './config/hms.config.php';
if(isset($_POST['submit-logout'])){
    session_unset();
    session_destroy();
    header('Location:./index_patient.php');
    exit();
 }
 $email = $_SESSION['session_id'];
 $sql = "SELECT * FROM patient WHERE email = '$email'";
 $res = mysqli_query($conn,$sql);
 $patient_detail = mysqli_fetch_assoc($res);
 //print_r($patient_detail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link rel="stylesheet" href="./styles.css">
    <style>
        .body{
            background-color: #fff;
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
            width: 100%;
        }
        .left_section li a{
            text-decoration: none;
            padding: 12px 20px;
            cursor: pointer;
            list-style: none;
            color: #000;
        }
        .left_section li :hover{
            background-color: rgb(64, 7, 117);
            color: #fff;
            padding: 12px 20px;
            width: 100%;
        }
        .right_section{
            flex-basis: 76%;
        }
        .right_section h1{
            text-align: left;
            margin-left: 20%;
        }
        .pages{
            display: grid;
            grid-template-columns: repeat(2,350px);
            margin-top: 40px;
        }
        .boxes{
            width:300px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 5% 0;
        }
        .boxes_bottom{
            margin-left: 40%;
        }
        .image_icon{
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 2px 2px 5px #000;
            align-items: center;
            margin: 2% 0;
        }
        .image_icon img{
            width: 40px;
            height: 40px;
        }
    </style>
</head>
<body>
    <section class="body">
    <div class="nav">
        <h2><img src="./images/hospital.png" style="height: 20px;width:20px"/>HOSPITAL MANAGEMENT SYSTEM</h2>
        <div class="right">
            <li>HOME</li>
            <li>CONTACT</li>
            <?php if(isset($_SESSION['session_id'])): ?>
            <form action="./logout.php" method="POST">
                <button name="submit-logout" type="submit">LOGOUT</button>
            </form>
            <?php endif ?>
        </div>
    </div>
    <?php if(isset($_SESSION['session_id'])): ?>
          <div class="dashboard_section">
        <div class="left_section">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Book Appointment</a></li>
            <li><a href="#">Appointment History</a></li>
            <li><a href="#">Prescription</a></li>
        </div>
        <div class="right_section">
            <h1>Welcome <?php echo $patient_detail['first_name'];  echo '  ' . $patient_detail['last_name']?></h1>
            <div class="pages">
                <div class="boxes">
                    <div class="image_icon">
                        <img src="./images/bookmark.png"/>
                    </div>
                    <h2>Book My Appointment</h2>
                     <a href="./includes/appointment_booking.inc.php">Book Appointment</a>
                </div>
                <div class="boxes">
                    <div class="image_icon">
                        <img src="./images/paperclip.png"/>
                    </div>
                    <h2>My Appointments</h2>
                     <a href="./includes/viewappointments.inc.php">View Appointment History</a>
                </div>
                <div class="boxes boxes_bottom">
                    <div class="image_icon">
                        <img src="./images/prescription.png"/>
                    </div>
                    <h2>Prescriptions</h2>
                     <a href="#">View Prescriptions</a>
                </div>
            </div>
        </div>
    </div>
        <?php else :?>
            <h2>Session Timed Out!!</h2>
            <?php include './login_patient.php' ?>
    <?php endif?>
    </section>
</body>
</html>