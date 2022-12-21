<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" dir="rtl">
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
<body dir="rtl">
<?php
    session_start();
    if(isset($_SESSION['user'])){
        $email = $_SESSION['user']->email;
        $code = $_SESSION['user']->code;
        echo'<form action="" method="post">
            <h1>تفعيل الحساب</h1>
            <p>شكرا لك على التسجيل في موقعنا.</p>
            <p>لقد أرسلنا رسالة إلى بريدك الإلكتروني <a href="https://www.gmail.com">'.$email.'</a>, يرجى الذهاب إليه لإكمال العملية.
            <button type="submit" name="s" class="s">أعد الإرسال!</button></p>
        </form>';
        if (isset($_POST['s'])) {
            require_once 'mailer.php';
            $mail->setFrom('ilyeeees220@gmail.com', 'maison');
            $mail->addAddress($email);
            $mail->Subject = 'verification code';
                $mail->Body    = '<h1>شكرا لك على التسجيل في موقعنا</h1><p>للتحقق من حسابك <a href="http://localhost/dr/active ar.php?code='.$code.'">اضغط هنا</a></p>';
                $mail->send();
            echo'لقد أرسلنا رسالة أخرى';
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
                    echo'تم التحقق من حسابك بنجاح<a href="login ar.php">تسجيل الدخول</a>';
                }
            }else {
                echo'هذا الرمز لم يعد صالحا';
            }
        }
    }else{
        header("location:login ar.php",true);
    }
?>
</body>
</html>