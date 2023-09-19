<?php 
 include '../config/hms.config.php';
 if(isset($_POST['submit-login'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
        header('Location:./login_doctor.inc.php?error=MissingInputFields');
        exit();
    }
    else{
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM doctors WHERE email = '$email'";
        $res = mysqli_query($conn,$sql);
        $doctor_info = mysqli_fetch_assoc($res);

        if(!$doctor_info){
            header('Location:./login_doctor.inc.php?error=UserDoesntExist&email='. $email);
            exit();
        }
        else{
            if(!password_verify($password,$doctor_info['password'])){
                header('Location:./login_doctor.inc.php?error=WrongPassword');
                exit();
            }
            else{
                session_start();
                $_SESSION['doctor_session'] = $doctor_info['email'];
                header('Location:../index_doctor.php?loginSuccessfull');
                exit();
            }
        }
    }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../styles.css"/>
</head>
<body>
    <section class="doctor_reg_body">
        <div class="doctor_form">
           <div class="buttons">
                <a href="../register_patient.php">Patient</a>
                <a href="./register_doctor.inc.php">Doctor</a>
                <a href="#">Admin</a>
              </div>
            <form action="./login_doctor.inc.php" method="POST">
                <h2 style="text-align: center;">Doctor Login</h2>
                <label>Email</label>
                <br/>
                <input type="email" name="email" placeholder="Email"/>
                <br/>
                <label>Password</label>
                <br/>
                <input type="password" name="password"/>
                <button type="submit" name="submit-login">Login</button>
                <p style="margin-top: 10px;">Have No Account?<a href="./register_doctor.inc.php">Register Here</a></p>
            </form>
        </div>
    </section>
</body>
</html>