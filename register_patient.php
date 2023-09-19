<?php 
 include './config/hms.config.php';

 if(isset($_POST['submit-patient'])){
    if(empty($_POST['f_name']) || empty($_POST['l_name']) || empty($_POST['email']) 
    || empty($_POST['contact']) || empty($_POST['gender']) || empty($_POST['password'])){
        header('Location:./register.php?error=MissingInputFields');
        exit();
    }
    else{
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header('Location:./register_patient.php?error=InvalidEmailFormat&f_name=' . $f_name .' &l_name=' . $l_name);
            exit();
        }
        else if(!preg_match('/^[a-zA-Z]/',$f_name)){
            header('Location:./register_patient.php?error=InvalidEmailFormat&f_name=' . $email.' &l_name=' . $l_name);
            exit();
        }
        else if(!preg_match('/^[a-zA-Z]/',$l_name)){
            header('Location:./register_patient.php?error=InvalidEmailFormat&f_name=' . $email .' &l_name=' . $f_name);
            exit();
        }
        else if($password !== $c_password){
            header('Location:./register_patient.php?error=Password1 !== Password2');
            exit();
        }
        else{
            $f_name = mysqli_real_escape_string($conn,$f_name);
            $l_name = mysqli_real_escape_string($conn,$l_name);
            $contact = mysqli_real_escape_string($conn,$contact);
            $email = mysqli_real_escape_string($conn,$email);
            $password = mysqli_real_escape_string($conn,$password);
            $gender = mysqli_real_escape_string($conn,$gender);
            $hashPwd = password_hash($password,PASSWORD_DEFAULT);

            $sql_check = "SELECT email FROM patient WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt,$sql_check);
            mysqli_stmt_bind_param($stmt,'s',$email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $row = mysqli_stmt_num_rows($stmt);

            if($row > 0){
                header('Location:./register_patient.php?error=EmailIdAlreadyExists');
                exit();
            }
            else{
                $sql = "INSERT INTO patient(first_name,last_name,email,contact,password,gender) 
                VALUES('$f_name','$l_name','$email','$contact','$hashPwd','$gender')";

                if(mysqli_query($conn,$sql)){
                    header('Location:./login_patient.php?patientAccount==true');
                    exit();
                }
                else{
                    header('Location:./register_patient.php?error=Error404DB');
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
   <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <section class="form">
        <div class="left_side">
           <h1>WELCOME TO HMS</h1>
        </div>
        <div class="right_side">
              <div class="buttons">
                <a href="./register_patient.php">Patient</a>
                <a href="./includes/register_doctor.inc.php">Doctor</a>
                <a href="#">Admin</a>
              </div>
                <form action="./register_patient.php" method="POST">
                <div class="input_forms">
                   <h2>Register as Patient</h2>
                    <input type="text" name="f_name" placeholder="First Name">
                    <input type="text" name="l_name" placeholder="Last Name">
                    <input type="email" name="email" placeholder="Email">
                    <input type="number" name="contact" placeholder="Contact *">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <input type="password" name="password" placeholder="Password">
                    <input type="password" name="c_password" placeholder="Confirm Password">
                    <button type="submit" name="submit-patient">Create HMS Account</button>
                    <p>Already Have Account?<a href="./login_patient.php">Login Here</a></p>
                </div>
                </form>
        </div>
    </section>
</body>
</html>