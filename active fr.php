<!DOCTYPE html>
<html lang="fr">
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
    <title>Activer le compte</title>
</head>
<body>
<?php
    session_start();
    if(isset($_SESSION['user'])){
        $email = $_SESSION['user']->email;
        $code = $_SESSION['user']->code;
        echo'<form action="" method="post">
            <h1>Activer le compte</h1>
            <p>Merci de vous être inscrit sur notre site.</p>
            <p>Nous avons envoyé un message à votre adresse e-mail <a href="https://www.gmail.com">'.$email.'</a>, veuillez vous y rendre pour terminer le processus.
            <button type="submit" name="s" class="s">Envoyer à nouveau!</button></p>
        </form>';
        if (isset($_POST['s'])) {
            require_once 'mailer.php';
            $mail->setFrom('ilyeeees220@gmail.com', 'maison');
            $mail->addAddress($email);
            $mail->Subject = 'le code de vérification';
            $mail->Body    = '<h1>Merci de vous être inscrit sur notre site</h1><p>Pour vérifier votre compte <a href="http://localhost/dr/active fr.php?code='.$code.'">cliquez ici</a></p>';
            $mail->send();
            echo'Nous avons envoyé un autre message';
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
                    echo'Votre compte a été vérifié avec succès<a href="login fr.php">Connexion</a>';
                }
            }else {
                echo"Ce code n'est plus valide";
            }
        }
    }else{
        header("location:login fr.php",true);
    }
?>
</body>
</html>