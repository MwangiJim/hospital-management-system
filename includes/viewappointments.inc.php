<?php
 session_start();
 include '../config/hms.config.php';
if(isset($_POST['submit-logout'])){
    session_unset();
    session_destroy();

    header('Location:../index_patient.php');
    exit();
}
 $email = $_SESSION['session_id'];
 $sql = "SELECT * FROM patient WHERE email = '$email'";
 $res = mysqli_query($conn,$sql);
 $patient_detail = mysqli_fetch_assoc($res);
//make query to get all appointments associated with the user

$sql_appointments = "SELECT * FROM appointments WHERE email = '$email'";
$res = mysqli_query($conn,$sql_appointments);
$patient_appointments = mysqli_fetch_all($res,MYSQLI_ASSOC);


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
        .appointment_list{
            width:100%;
        }
        .appointments{
            width:100%;
            height: 60vh;
            max-height: 60vh;
            overflow-y: scroll;
        }
        .appointment_list .header-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-bar div{
            flex-basis: 15%;
            font-weight: bolder;
            text-align: left;
        }
        .header-bar .one{
            flex-basis: 6%;
        }
        .appointment_template{
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }
        .appointment_template{
            padding: 15px 10px;
            cursor: pointer;
        }
        .appointment_template:hover{
            background-color: rgba(77,76,76,0.4);
            border-radius: 6px;
        }
        .appointment_template div button{
            background-color: #f44336;
            width: 100%;
            height: 40px;
            color: #fff;
            cursor: pointer;
            border: none;
            outline: none;
            border-radius: 10px;
            text-align: center;
        }
        .two{
            flex-basis: 15%;
        }
        .three{
            flex-basis: 15%;
        }
        .four{
            flex-basis: 15%;
        }
        .five{
            flex-basis: 15%;
        }
        .six{
            flex-basis: 14%;
        }
        .seven{
            flex-basis: 10%;
        }
    </style>
</head>
<body>
    <section class="view_appointments">
    <div class="nav">
        <h2><img src="../images/hospital.png" style="height: 20px;width:20px"/>HOSPITAL MANAGEMENT SYSTEM</h2>
        <div class="right">
            <li>HOME</li>
            <li>CONTACT</li>
            <form action="./viewappointments.inc.php" method="POST">
                <button name="submit-logout" type="submit">LOGOUT</button>
            </form>
        </div>
    </div>
    <div class="dashboard_section">
        <div class="left_section">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Book Appointment</a></li>
            <li><a href="#">Appointment History</a></li>
            <li><a href="#">Prescription</a></li>
        </div>
        <div class="right_section">
            <h1>Welcome <?php echo $patient_detail['first_name'];  echo '  ' . $patient_detail['last_name']?></h1>
            <div class="appointment_list">
              <div class="header-bar">
                <div class="one">#</div>
                <div>Doctor</div>
                <div>Fees</div>
                <div>Date</div>
                <div>Time</div>
                <div>Status</div>
                <div>Action</div>
              </div>
              <div class="appointments">
            <?php foreach($patient_appointments as $patient_appointment): ?>
                 <div class="appointment_template">
                    <div class="one"><?php echo $patient_appointment['id']?></div>
                    <div class="two"><?php echo $patient_appointment['doctor']?></div>
                    <div class="three"><?php echo $patient_appointment['consultancy_fees']?></div>
                    <div class="four"><?php echo $patient_appointment['appointment_date']?></div>
                    <div class="five"><?php echo $patient_appointment['appointment_time']?></div>
                    <div class="six">Active</div>
                    <form action="./cancel_appointment.php" method="POST">
                     <input type="hidden" name="id-to-cancel" value="<?php echo $patient_appointment['id'] ?>">
                      <div class="seven"><button type="submit" name="appointment-to-cancel">Cancel</button></div>
                   </form>
                 </div>    
            <?php endforeach?>
        </div>
            </div>
        </div>
    </div>
    </section>
</body>
</html>