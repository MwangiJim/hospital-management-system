<?php 
 include './config/hms.config.php';

 if(isset($_POST['submit-login'])){
    if(empty($_POST['email']) || empty($_POST['password'])){
        header('location:./login_patient.php?error=MissingInputFields');
        exit();
    }
    else{
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM patient WHERE email = '$email'";
        $res = mysqli_query($conn,$sql);
        $patient_detail = mysqli_fetch_assoc($res);
        if(!$patient_detail){
            header('Location:./login_patient.php?error=UserNotFound');
            exit();
        }
        else{
            if(!password_verify($password,$patient_detail['password'])){
                header('Location:./login_patient.php?error=WrongPassword');
                exit();
            }
            else{
                session_start();
                $_SESSION['session_id'] = $patient_detail['email'];
                header('Location:./index_patient.php?loginSuccessful');
                exit();
            }
        }
    }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="./styles.css">
</head>
<body>
    <div class="login_body">
           <div class="buttons">
                <a href="./register_patient.php">Patient</a>
                <a href="./includes/register_doctor.inc.php">Doctor</a>
                <a href="#">Admin</a>
              </div>
        <form action="./login_patient.php" method="POST">
            <h2 style="text-align: center;">Patient Login</h2>
            <label>Email</label>
            <br/>
            <input type="email" name="email" placeholder="Email"/>
            <br/>
            <label>Password</label>
            <br/>
            <input type="password" name="password"/>
            <button type="submit" name="submit-login">Login</button>
            <p style="margin-top: 10px;">Have No Account?<a href="./register_patient.php">Register Here</a></p>
        </form>
    </div>
</body>
</html>