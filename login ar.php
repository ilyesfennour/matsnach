<?php
if(isset($_POST['btn'])){
    require_once 'cdb.php';
    $login = $db->prepare("SELECT * FROM sign_up WHERE email = :email AND password = :password");
    $login->bindParam('email',$_POST['email']);
    $login->bindParam('password',$_POST['pass']);
    $login->execute();
    if ($login->rowCount() == 1) {
        $user = $login->fetchObject();
        if ($user->active == 1) {
            session_unset();
            session_destroy();
            session_start();
            $_SESSION['user'] = $user;
            header("location:index ar.php",true);
        }else{
            session_unset();
            session_destroy();
            session_start();
            $_SESSION['user'] = $user;
            header("location:active ar.php",true);
        }
    } else {
        echo 'كلمة المرور أو البريد الإلكتروني خاطئ';
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
            font-weight: 500px;
            background-color: #191919;
            margin-bottom: 25px;
        }
        .name{
            border: 2px solid #3498db;
            background: none;
            display: block;
            margin: 5px auto;
            text-align: center;
            padding: 14px 10px;
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
            margin: 5px auto 15px auto;
            text-align: center;
            padding: 14px 40px;
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
    </style>
    <title>تسجيل الدخول</title>
</head>
<body dir="rtl">
    <form action="" method="POST" class="box">
        <h1>تسجيل الدخول</h1>
        <input type="text" placeholder="البريد الإلكتروني" name="email" class="name" required><br>
        <input type="password" placeholder="كلمة المرور" name="pass" class="name" required><br>
        <button type="submit" name="btn" id="btn">تسجيل الدخول</button>
        <p>ليس لديك حساب؟ <a href="sign up ar.php">إنشاء حساب</a> <br> <a href="Forget Password ar.php">نسيت كلمة المرور؟</a></p>
    </form>
</body>
</html>