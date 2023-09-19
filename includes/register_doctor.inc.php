<?php 
include '../config/hms.config.php';

if(isset($_POST['submit-doctor'])){
 if(empty($_POST['doctor_name']) || empty($_POST['doctor_username']) || empty($_POST['specialization']) ||
 empty($_POST['email']) || empty($_POST['password'])){
    header('Location:./register_doctor.inc.php?error=MissingInputFields');
    exit();
 }
 else{
   $name = $_POST['doctor_name'];
   $username = $_POST['doctor_username'];
   $specialization = $_POST['specialization'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $c_password = $_POST['check_password'];
   $fees = $_POST['fees'];

   if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    header('Location:./register_doctor.inc.php?error=InvalidEmailAddress');
    exit();
   }
   else if($password !== $c_password){
    header('Location:./register_doctor.inc.php?error=Password1 !== Password2');
    exit();
   }
   else{
    $name = mysqli_real_escape_string($conn,$name);
    $username = mysqli_real_escape_string($conn,$username);
    $email = mysqli_real_escape_string($conn,$email);
    $specialization = mysqli_real_escape_string($conn,$specialization);
    $password = mysqli_real_escape_string($conn,$password);
    $fees = mysqli_real_escape_string($conn,$fees);

    $hashPwd = password_hash($password,PASSWORD_DEFAULT);

    $sql_doctor = "SELECT * FROM doctors WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt,$sql_doctor);
    mysqli_stmt_bind_param($stmt,'s',$email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $row =mysqli_stmt_num_rows($stmt);
    if($row > 0){
        header('Location:./register_doctor.inc.php?error=DoctorEmailIdAlreadyExists');
        exit();
    }
    else{
        $sql = "INSERT INTO doctors(name,username,specialization,email,password,consultancy_fees)
         VALUES('$name','$username','$specialization','$email','$hashPwd','$fees')";

         if(mysqli_query($conn,$sql)){
            header('Location:./login_doctor.inc.php?DocAccountCreate==true');
            exit();
         }
         else{
            header('Location:./register_doctor.inc.php?error=Error404DBConnect');
            exit();
         }
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
    <div class="doctor_reg_form">
       <div class="left_side">
           <h1>WELCOME TO HMS</h1>
        </div>
        <div class="right-side">
             <div class="buttons">
                <a href="../register_patient.php">Patient</a>
                <a href="./register_doctor.inc.php">Doctor</a>
                <a href="#">Admin</a>
              </div>
            <form action="./register_doctor.inc.php" method="POST">
                <h3>Register as Doctor</h3>
                <div class="input-box">
                    <label>Doctor Name</label>
                    <input name="doctor_name" type="text" />
                </div>
                <div class="input-box">
                    <label>UserName</label>
                    <input name="doctor_username" type="text" />
                </div>
                <div class="input-box">
                    <label>Specialization</label>
                <select name="specialization">
                    <option>Select specialization</option>
                    <option value="cardiology">Cardiology</option>
                    <option value="Neurology">Neurology</option>
                    <option value="paediatritian">paediatritian</option>
                    <option value="Gynecologist">Gynecologist</option>
                    <option value="Oncologist">Oncologist</option>
                </select>
                </div>
                <div class="input-box">
                    <label>Email</label>
                    <input name="email" type="email" />
                </div>
                <div class="input-box">
                    <label>Password</label>
                    <input name="password" type="password" />
                </div>
                <div class="input-box">
                    <label>Confirm Password</label>
                    <input name="check_password" type="password"/>
                </div>
                <div class="input-box">
                    <label>Consultancy Fees</label>
                    <input name="fees" type="number"/>
                </div>
                <button type="submit" name="submit-doctor">Create HMS Doctor Account</button>
                <p>Already Have Account><a href="./login_doctor.inc.php">Login Here</a></p>
            </form>
        </div>
    </div>
</body>
</html>