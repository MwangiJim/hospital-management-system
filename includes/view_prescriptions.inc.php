<?php 
  session_start();
  include '../config/hms.config.php';
  if(isset($_POST['submit-logout'])){
     session_unset();
     session_destroy();
 
     header('Location:./login_doctor.inc.php');
     exit();
     die();
  }
  $email = $_SESSION['doctor_session'];
  $sql = "SELECT * FROM doctors WHERE email = '$email'";
  $res = mysqli_query($conn,$sql);
  $doctor_info = mysqli_fetch_assoc($res);

  
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
            text-align: center;
        }
        .appointment_display .top-header-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;

        }
    </style>
</head>
<body>
    <section class="prescriptions">
    <div class="nav">
        <h2>HOSPITAL MANAGEMENT SYSTEM</h2>
        <div class="right">
            <li>HOME</li>
            <li>CONTACT</li>
            <form action="./login_doctor.inc.php" method="POST">
                <button name="submit-logout" type="submit">LOGOUT</button>
            </form>
         </div>
        </div>
        <div class="dashboard_section">
            <div class="left_section">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Appointments</a></li>
                <li><a href="#">Prescriptions</a></li>
            </div>
          <div class="right_section">
            <h1>Welcome Dr <?php echo $doctor_info['name']?></h1>
            <div class="appointment_display">
                <div class="top-header-bar">
                    <div class="one">#</div>
                    <div>Patient</div>
                    <div>Apppointment Date</div>
                    <div>Appointment Time</div>
                    <div>Disease</div>
                    <div>Allergy</div>
                    <div>Prescribe</div>
                </div>
                <div class="appointment_list">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
    </section>
</body>
</html>