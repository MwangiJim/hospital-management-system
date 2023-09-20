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

 $sql_doc = "SELECT * FROM doctors WHERE email = '$email'";
 $res = mysqli_query($conn,$sql_doc);
 $doc_info = mysqli_fetch_assoc($res);
 //print_r($doc_info);

 $doc_name = $doc_info['name'];
 $sql = "SELECT * FROM appointments WHERE doctor = '$doc_name'";
 $response = mysqli_query($conn,$sql);
 $appointments = mysqli_fetch_all($response,MYSQLI_ASSOC);
// print_r($appointments);
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
        .top-header-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
        }
        .top-header-bar div{
            flex-basis: 15%;
        }
        .top-header-bar .one{
            flex-basis: 6%;
        }
        .appointment{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 12px;
            cursor: pointer;
        }
        .appointment:hover{
            background-color: rgba(77,76,76,0.5);
            border-radius: 10px;
        }
        .appointment div{
            flex-basis: 25%;
            font-size: 14px;
        }
        .appointment .one{
            flex-basis: 4%;
        }
        .appointment .two{
            flex-basis: 10%;
        }
       .appointment .three{
            flex-basis: 6%;
        }
       .appointment .four{
            flex-basis: 15%;
        }
       .appointment .five{
            flex-basis: 10%;
        }
       .appointment .six{
            flex-basis: 10%;
        }
       .appointment .seven{
            flex-basis: 10%;
        }
       .appointment .eight{
            flex-basis: 10%;
        }
       .appointment .nine{
            flex-basis: 10%;
        }
        .appointment .cancel{
            background-color: #f44336;
            padding: 7px 10px;
            color: #fff;
            border: none;
            outline:none;
            cursor: pointer;
            border-radius: 10px;
        }
        .appointment .green{
            background-color: green;
            padding: 7px 15px;

            color: #fff;
            border: none;
            outline:none;
            cursor: pointer;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <section class="doc_view">
    <div class="nav">
        <h2>HOSPITAL MANAGEMENT SYSTEM</h2>
        <div class="right">
            <li>HOME</li>
            <li>CONTACT</li>
            <form action="./doctorview.inc.php" method="POST">
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
            <h1>Welcome Dr <?php echo $doc_name?></h1>
            <div class="appointment_display">
                <div class="top-header-bar">
                    <div class="one">#</div>
                    <div>Patient</div>
                    <div>Gender</div>
                    <div>Email</div>
                    <div>Contact</div>
                    <div>Date</div>
                    <div>Time</div>
                    <div>Status</div>
                    <div>Action</div>
                    <div>Prescribe</div>
                </div>
                <div class="appointment_list">
                    <?php foreach($appointments as $appointment) :?>
                        <div class="appointment">
                            <div class="one"><?php echo htmlspecialchars($appointment['id'])?></div>
                            <div class="two"><?php echo htmlspecialchars($appointment['patient'])?></div>
                            <div class="three"><?php echo htmlspecialchars($appointment['gender'])?></div>
                            <div class="four"><?php echo htmlspecialchars($appointment['email'])?></div>
                            <div class="five"><?php echo htmlspecialchars($appointment['contact'])?></div>
                            <div class="six"><?php echo htmlspecialchars($appointment['appointment_date'])?></div>
                            <div class="seven" style="font-size: 12px;"><?php echo htmlspecialchars($appointment['appointment_time'])?></div>
                            <div class="eight">Active</div>
                            <div class="nine"><button class="cancel" type="submit" name="submit-cancel">Cancel</button></div>
                            <div class="nine"><form action="./prescription.inc.php" method="POST">
                                <input type="hidden" name="name-to-prescribe" value="<?php echo $appointment['id'] ?>">
                                <button class="green" type="submit" name="prescribe">Prescribe</button>
                            </form></div>
                        </div>
                        <?php endforeach ?>
                </div>
            </div>
        </div>
    </section>
</body>
</html>