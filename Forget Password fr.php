<?php
if(isset($_POST['btn'])){
    require_once 'cdb.php';
    $email = $_POST['email'];

    $chec = $db->prepare("SELECT password FROM sign_up WHERE email = :email");
    $chec->bindParam('email',$email);
    $chec->execute();
   
    if ($chec->rowCount()>0) {
        $pass = $chec->fetchObject();
        require_once 'mailer.php';
        $mail->setFrom('ilyeeees220@gmail.com', 'maison');
        $mail->addAddress($email);
        $mail->Subject = 'réinitialiser le mot de passe';
        $mail->Body    = "<h1>Merci d'utiliser notre site</h1><p>Ceci est votre mot de passe:'.$pass->password.'<a href='http://localhost/dr/login fr.php?'>S'identifier</a></p>";
        $mail->send();
        echo'Nous avons envoyé un message à votre adresse e-mail '.$email;
    }else{
        echo'Cet e-mail est incorrect !';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
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
    <title>réinitialiser le mot de passe</title>
</head>
<body>
    <form action="" method="POST" class="box">
        <h1>réinitialiser le mot de passe</h1>
        <input type="text" placeholder="E-mail" name="email" class="name" required><br>
        <button type="submit" name="btn" id="btn">réinitialiser</button>
        <p><a href="login fr.php">S'identifier</a></p>
    </form>
</body>
</html>