<?php
session_start();
require_once 'cdb.php';
if(isset($_SESSION['user'])){
    if (isset($_POST['exit'])) {
        session_unset();
        session_destroy();
        header("location:http://localhost/dr/login ar.php");
    }
}else{
    header("location:login ar.php",true);
}
require_once 'header ar.php';
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .sec{
            background-color: #2C3639;
            height: 100%;
            width: 100%;
            position: absolute;
        }
        .box{
            width: 600px;
            background-color: #2C3639;
            text-align: center;
            position: absolute;
            top: 56%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
        h1{
            color: white;
            text-transform: uppercase;
            background-color: #2C3639;
            margin-bottom: 25px;
        }
        .text{
            font-size: 1rem;
            color: white;
            float: right;
            width: 200px;
            text-align: right;
            padding: 21px;
        }
        .name{
            border: 2px solid #3498db;
            background: none;
            float: left;
            margin: 5px auto;
            text-align: center;
            padding: 14px 10px;
            width: 200px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            font-size: 1rem;
        }
        .name:focus{
            border-color: #2ecc71;
        }
        #btn{
            border: 2px solid #2ecc71;
            background: none;
            display: block;
            margin: 15px auto 15px auto;
            text-align: center;
            padding: 14px 40px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            cursor: pointer;
            font-size: 1rem;
            float: right;
            width: 210px;
            position: relative;
        }
        #btn:hover{
            background-color: #2ecc71;
        }
        #cbtn{
            border: 2px solid #F94C66;
            background: none;
            display: block;
            margin: 15px auto 15px auto;
            text-align: center;
            padding: 14px 10px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            cursor: pointer;
            width: 200px;
            float: left;
            position: relative;
            font-size: 1rem;
            text-decoration: none;
        }
        #cbtn:hover{
            background-color: #F94C66;
        }
        .eror{
            background-color: #2ecc71;
            padding: 10px;
            font-size: 20px;
            color: white;
            z-index: 1;
        }
        @media screen and (max-width:630px) {
            .box{
                width: 400px;
            }
            .text{
                width: 150px;
            }
            .name{
                width: 150px;
            }
            #btn{
                width: 174px;
            }
            #cbtn{
                width: 150px;
            }
        }
        @media screen and (max-width:430px) {
            .sec{
                height: auto;
            }
            .box{
                width: 100%;
                position: initial;
                transform: none;
            }
            .name{
                float: none;
            }
            .text{
                float: none;
            }
            #btn{
                float: none;
            }
            #cbtn{
                float: none;
            }
        }
        @media screen and (max-width:430px) {
            .box{
                width: 100%;
            }
            .name{
                width: 70%;
            }
        }
    </style>
    <title>الحساب</title>
</head>
<body dir="rtl">
    <section>
        <?php 
        if(isset($_POST['btn'])){
            $id = $_SESSION['user']->id;
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $pass = $_POST['pass'];
            $conf = $_POST['cpass'];
            if ($pass == $conf) {
                $ap = $db->prepare("UPDATE sign_up SET f_name = :f_name,l_name = :l_name,password = :pass WHERE id = :id");
                $ap->bindParam('id',$id);
                $ap->bindParam('f_name',$fname);
                $ap->bindParam('l_name',$lname);
                $ap->bindParam('pass',$pass);
                if ($ap->execute()) {
                    echo'<div class="eror">نم التعديل بنجاح</div>';
                }

                $login = $db->prepare("SELECT * FROM sign_up WHERE id = :id");
                $login->bindParam('id',$id);
                $login->execute();
                $user = $login->fetchObject();

                session_unset();
                session_destroy();
                session_start();
                $_SESSION['user'] = $user;
            }else{
                echo'<div class="eror">يجب أن تكون كلمة المرور الخاصة بك وتأكيد كلمة المرور متطابقتين !!</div>';
            }
        }
        ?>
        <div class="sec">
            <form action="" method="post" class="box">
                <h1>الحساب</h1>
                <?php
                    echo'
                        <span class="text">الإسم:</span><input type="text" placeholder="'.$_SESSION['user']->f_name.'" class="name" name="fname" required><br>
                        <span class="text">اللقب:</span><input type="text" placeholder="'.$_SESSION['user']->l_name.'" class="name" name="lname" required><br>
                        <span class="text">كلمة المرور:</span><input type="password" placeholder="'.$_SESSION['user']->password.'" class="name" name="pass" required><br>
                        <span class="text">تأكيد كلمة المرور:</span><input type="password" placeholder="'.$_SESSION['user']->password.'" class="name" name="cpass" required><br>
                        <button type="submit" id="btn" name="btn">تعديل</button>
                        <a href="index ar.php" id="cbtn">إلغاء</a>
                        ';
                ?>
            </form>
        </div>
    </section>
</body>
<script>
    const lnga = document.getElementById('alnga').href="account ar.php";
    const lng = document.getElementById('alng').href="account.php";
    const lngf = document.getElementById('alngf').href="account fr.php";
</script>
</html>