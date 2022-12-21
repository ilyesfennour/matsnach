<?PHP
if(isset($_POST['btn'])){
    require_once 'cdb.php';
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $conf = $_POST['cpass'];
    $code = md5(date("h:i:s").$fname);

    if ($pass == $conf) {
        $chec = $db->prepare("SELECT * FROM sign_up WHERE email = :email");
        $chec->bindParam('email',$email);
        $chec->execute();
       
        if ($chec->rowCount()>0) {    
            echo'<div style="color: white;z-index: 1;position: relative;text-align: center;">This email is used</div>';
        }else{
            $add = $db->prepare("INSERT INTO sign_up(f_name,l_name,email,password,code)
            VALUES(:f_name,:l_name,:email,:password,:code)");
            $add->bindParam('f_name',$fname);
            $add->bindParam('l_name',$lname);
            $add->bindParam('email',$email);
            $add->bindParam('password',$pass);
            $add->bindParam('code',$code);
    
            if ($add->execute()) {
                require_once 'mailer.php';
                $mail->setFrom('ilyeeees220@gmail.com', 'maison');
                $mail->addAddress($email);
                $mail->Subject = 'verification code';
                $mail->Body    = '<h1>Thank you for registering on our site</h1><p>To verify your account <a href="http://localhost/dr/active.php?code='.$code.'">Press here</a></p>';
                $mail->send();

                $login = $db->prepare("SELECT * FROM sign_up WHERE email = :email AND password = :password");
                $login->bindParam('email',$email);
                $login->bindParam('password',$pass);
                $login->execute();
                $user = $login->fetchObject();

                session_unset();
                session_destroy();
                session_start();
                $_SESSION['user'] = $user;
                header("location:active.php",true);
            }else{
                echo'<div style="color: white;z-index: 1;position: relative;text-align: center;">an error occurred!!</div>';
            }
        }
    } else {
        echo'<div style="color: white;z-index: 1;position: relative;text-align: center;">Your password and confirm password must be the same!!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            background-color: #34495e;
        }
        .box{
            width: 300px;
            padding: 30px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: #191919;
            text-align: center;
        }
        h1{
            color: white;
            text-transform: uppercase;
            background-color: #191919;
            margin-bottom: 15px;
        }
        .name{
            border: 2px solid #3498db;
            background: none;
            display: block;
            margin: 0px auto 5px auto;
            text-align: center;
            padding: 12px 10px;
            width: 200px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
        }
        .name:focus{
            width: 280px;
            border-color: #2ecc71;
        }
        #btn{
            border: 2px solid #2ecc71;
            background: none;
            display: block;
            margin: 2px auto 12px auto;
            text-align: center;
            padding: 12px 40px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            cursor: pointer;
        }
        #btn:hover{
            background-color: #2ecc71;
        }
        p{
            color: white;
            background-color: #191919;            
        }
        a{
            color: #2ecc71;
            background-color: #191919;
        }
        @media screen and (max-width:360px) {
            .box{
                width: 232px;
                padding: 20px;
            }
            .name{
                width: 170px;
            }
            .name:focus{
                width: 200px;
            }
        }
        @media screen and (max-height:540px) {
            h1{
                margin-bottom: 5px;
            }
            .name{
                margin: 0px auto;
                padding: 10px;
            }
            #btn{
                margin: 0px auto 7px auto;
                padding: 10px 40px;
            }
            .box{
                position: static;
                transform: translate(0%,0%);
                margin: auto;
            }
        }
    </style>
    <title>Sign Up</title>
</head>
<body>
    <form action="" method="post" class="box">
        <h1>Sign Up</h1>
        <input type="text" placeholder="First Name" class="name" name="fname" required><br>
        <input type="text" placeholder="Last Name" class="name" name="lname" required><br>
        <input type="email" placeholder="Adress email" class="name" name="email" required><br>
        <input type="password" placeholder="Password" class="name" name="pass" required><br>
        <input type="password" placeholder="Confirm Password" class="name" name="cpass" required><br>
        <button type="submit" id="btn" name="btn">Submit</button>
        <p>Do you have an account?<a href="login.php">Sign In</a></p>
    </form>
</body>
</html>