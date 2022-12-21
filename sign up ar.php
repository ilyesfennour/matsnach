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
            echo'<div style="color: white;z-index: 1;position: relative;text-align: center;">هذا البريد الإلكتروني مستخدم</div>';
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
                $mail->Body    = '<h1>شكرا لك على التسجيل في موقعنا</h1><p>للتحقق من حسابك <a href="http://localhost/dr/active ar.php?code='.$code.'">اضغط هنا</a></p>';
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
                header("location:active ar.php",true);
            }else{
                echo'<div style="color: white;z-index: 1;position: relative;text-align: center;">حدث خطأ!!</div>';
            }
        }
    } else {
        echo'<div style="color: white;z-index: 1;position: relative;text-align: center;">يجب أن تكون كلمة المرور الخاصة بك وتأكيد كلمة المرور متطابقتين !!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
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
            text-decoration: none;
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
    <title>إنشاء حساب</title>
</head>
<body  dir="rtl">
    <form action="" method="post" class="box">
        <h1>إنشاء حساب</h1>
        <input type="text" placeholder="الإسم" class="name" name="fname" required><br>
        <input type="text" placeholder="اللقب" class="name" name="lname" required><br>
        <input type="email" placeholder="البريد الإلكتروني" class="name" name="email" required><br>
        <input type="password" placeholder="كلمة المرور" class="name" name="pass" required><br>
        <input type="password" placeholder="تأكيد كلمة المرور" class="name" name="cpass" required><br>
        <button type="submit" id="btn" name="btn">إنشاء</button>
        <p>هل لديك حساب؟ <a href="login ar.php">تسجيل الدخول</a></p>
    </form>
</body>
</html>