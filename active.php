<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            font-family: DroidArabicKufiRegular,Muli,sans-serif;
            background-color: #CCCCCC;
        }
        .s{
            margin: 0px;
            padding: 0px;
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            font-size: 17px;
        }
    </style>
    <title>Account activate</title>
</head>
<body>
<?php
    session_start();
    if(isset($_SESSION['user'])){
        $email = $_SESSION['user']->email;
        $code = $_SESSION['user']->code;
        echo'<form action="" method="post">
            <h1>Account activate</h1>
            <p>Thank you for registering on our site.</p>
            <p>We have sent a message to your email <a href="https://www.gmail.com">'.$email.'</a>, please go to it to complete the process.
            <button type="submit" name="s" class="s">Send again!</button></p>
        </form>';
        if (isset($_POST['s'])) {
            require_once 'mailer.php';
            $mail->setFrom('ilyeeees220@gmail.com', 'maison');
            $mail->addAddress($email);
            $mail->Subject = 'verification code';
            $mail->Body    = '<h1>Thank you for registering on our site</h1><p>To verify your account <a href="http://localhost/dr/active.php?code='.$code.'">Press here</a></p>';
            $mail->send();
            echo'We have sent another message';
        }
        if (isset($_GET['code'])) {
            require_once 'cdb.php';
            $chec = $db->prepare("SELECT code FROM sign_up WHERE code = :code");
            $chec->bindParam('code',$_GET['code']);
            $chec->execute();
            if ($chec->rowCount()>0) {    
                $update = $db->prepare("UPDATE sign_up SET code = :newcode, active = true WHERE code = :code");
                $code = md5(date("h:i:s"));
                $update->bindParam('code',$_GET['code']);
                $update->bindParam('newcode',$code);
            
                if ($update->execute()) {
                    echo'Your account has been successfully verified<a href="login.php">Login</a>';
                }
            }else {
                echo'This code is no longer valid';
            }
        }
    }else{
        header("location:login.php",true);
    }
?>
</body>
</html>