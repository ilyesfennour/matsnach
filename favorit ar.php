<?php
session_start();
require_once 'cdb.php';
if(isset($_SESSION['user'])){
    if (isset($_POST['exit'])) {
        session_unset();
        session_destroy();
        header("location:http://localhost/dr/login ar.php");
    }
    if (isset($_POST['action'])) {
        echo'hh';
    }
}else{
    header("location:login ar.php",true);
}
if (isset($_POST['dfavorit'])) {
    $id = $_SESSION['user']->id;
    $p_id = $_POST['id'];

    $del = $db->prepare("DELETE FROM favorit WHERE user_id = :id AND poste_id = :p_id");
    $del->bindParam('id',$id);
    $del->bindParam('p_id',$p_id);
    if ($del->execute()) {
        header("location:favorit.php",true);
    }
}
require_once 'header ar.php';
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <style>
        .bod{
            background-color: #2C3639;
        }
        #content{
            background-color: #191919;
            width: 270px;
            margin: 10px;
            padding: 5px;
            color: white;
            float: left;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .bbkm{
            position: absolute;
            top: -8px;
            left: 10px;
            z-index: 1;
            width: 30px;
            height: 100px;
            cursor: pointer;
            transition: 0.25s;
        }
        .imgcon{
            width: 270px;
            height: 189px;
            box-shadow: -5px 5px 20px rgb(0,0,0,0.1);
            flex-grow: 1;
        }
        .myimg{
            top: 0;
            left: 0;
            position: relative;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .noimg{
            opacity: 30%;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .tab{
            width: 100%;
            font-size: 1.1rem;
            border-bottom: 1px solid #2C3639;
            padding: 5px;
        }
        .td{
            margin-top: 5px;
            text-align: right;
            width: 135px;
            text-transform: capitalize;
        }
        .td1{
            margin-top: 5px;
            text-align: right;
            text-transform: capitalize;
            width: 55px;
        }
        .lite{
            height: 15px;
            width: 15px;
            float: right;
            border-radius: 25px;
            margin: 6px 3px 0px 3px;
        }
        .more{
            color: white;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
            width: 100%;
            display: block;
            font-size: 1rem;
            padding: 3px 0px;
            margin: 5px 0px 0px 0px;
            border-radius: 5px;
        }
        .more:hover{
            background-color: #2C3639;
        }
        @media screen and (max-width:300px) {
            #content{
                width: 220px;
            }
            .imgcon{
                width: 220px;
            }
        }
    </style>
    <title>أطبائي</title>
</head>
<body class="bod" dir="rtl">
    <section style="display: flex;flex-wrap: wrap;justify-content: center;">
        <?php
        $id = $_SESSION['user']->id;

        $sel = $db->prepare("SELECT poste_id FROM favorit WHERE user_id = :id");
        $sel->bindParam('id',$id);
        $sel->execute();

        foreach ($sel as $p_id) {
            $show = $db->prepare("SELECT * FROM clinic WHERE id = :p_id");
            $show->bindParam('p_id',$p_id['poste_id']);
            $show->execute();
            
            foreach ($show as $result) {
                $chec = $db->prepare("SELECT stat FROM post_status WHERE poste_id = :p_id");
                $chec->bindParam('p_id',$result['id']);
                $chec->execute();

                $imgshow = 'data:'.$result['type'].';base64,'.base64_encode($result['img']);       
                echo'
                <div id="content">
                <form action="" method="post">
                    <input type="text" name="id" style="display :none" value="'.$result['id'].'">
                    <label for="dfavorit'.$result['id'].'"><img src="img/icons8-bookmarks-64 (1).png" alt="" class="bbkm"></label>
                    <button type="submit" name="dfavorit" style="display :none" id="dfavorit'.$result['id'].'"></button>
                </form>';

                if ($result['type']) {
                    echo'<div class="imgcon"><img src="'.$imgshow.'" alt="" class="myimg" data-src="'.$imgshow.'"></div>';
                }else{
                    echo'<div class="imgcon"><img src="img/icons8-no-camera-100.png" alt="" class="noimg"></div>';
                }
                    echo'<table class="tab">
                        <tr><td class="td">الحكيم(ة): '.$result['l_name'].' '.$result['f_name'].'</td>';
                        if ($chec->rowCount()>0) {
                            $stat = $chec->fetchObject();
                            if ($stat->stat == 0) {
                                echo'<td class="td1" rowspan="2" style="color: gray;"><div class="lite" style="background-color: gray;"></div>مغلق</td></tr>';
                        }elseif ($stat->stat == 1) {
                            echo'<td class="td1" rowspan="2" style="color: olivedrab;"><div class="lite" style="background-color: olivedrab;"></div>مفتوح</td></tr>';
                        }elseif ($stat->stat == 2) {
                            echo'<td class="td1" rowspan="2" style="color: red;"><div class="lite" style="background-color: red;"></div>متوقف</td></tr>';
                        }
                    }else {
                        echo'<td class="td1" rowspan="2" style="color: gray;"><div class="lite" style="background-color: gray;"></div>مغلق</td></tr>';
                        }
                        if ($result['job'] != '') {
                            echo'<tr><td class="td" style="color: olivedrab;">'.$result['job'].'</td>';
                        }
                    echo'</table>
                    <a href="show ar.php?id='.$result['id'].'" class="more">المزيد</a>
                </div>
                ';
            }
        }
        ?>
    </section>
</body>
<script>
    const lnga = document.getElementById('alnga').href="favorit ar.php";
    const lng = document.getElementById('alng').href="favorit.php";
    const lngf = document.getElementById('alngf').href="favorit fr.php";
</script>
</html>