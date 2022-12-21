<?php
session_start();
require_once 'cdb.php';
if (isset($_POST['add'])) {
    $p_id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    $add = $db->prepare("INSERT INTO chane(post_id,l_name,f_name)
    VALUES(:p_id,:lname,:fname)");
    $add->bindParam('p_id',$p_id);
    $add->bindParam('lname',$lname);
    $add->bindParam('fname',$fname);
    if ($add->execute()) {
        header("location:index.php",true);
    }
}
if (isset($_POST['favorit'])) {
    $id = $_SESSION['user']->id;
    $p_id = $_POST['id'];

    $add = $db->prepare("INSERT INTO favorit(user_id,poste_id)
    VALUES(:id,:p_id)");
    $add->bindParam('id',$id);
    $add->bindParam('p_id',$p_id);
    if ($add->execute()) {
        header("location:index.php",true);
    }
}
if (isset($_POST['dfavorit'])) {
    $id = $_SESSION['user']->id;
    $p_id = $_POST['id'];

    $del = $db->prepare("DELETE FROM favorit WHERE user_id = :id AND poste_id = :p_id");
    $del->bindParam('id',$id);
    $del->bindParam('p_id',$p_id);
    if ($del->execute()) {
        header("location:index.php",true);
    }
}
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
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
        .bkm{
            position: absolute;
            top: -5px;
            left: 10px;
            z-index: 1;
            width: 30px;
            height: 70px;
            transition: 0.25s;
            cursor: pointer;
        }
        .bbkm{
            position: absolute;
            top: -8px;
            left: 10px;
            z-index: 1;
            width: 30px;
            height: 100px;
            transition: 0.25s;
            cursor: pointer;
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
            text-align: left;
            text-transform: capitalize;
        }
        .td1{
            margin-top: 5px;
            text-align: left;
            text-transform: capitalize;
            width: 80px;
        }
        .lite{
            height: 15px;
            width: 15px;
            float: left;
            border-radius: 25px;
            margin: 3px;
        }
        .msg{
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            background-color: #1d2b3a;
            color: white;
            font-size: 1.1rem;
            position: fixed;
            border-radius: 7px;
            display: none;
            z-index: 10;
            padding-top: 15px;
            min-width: 426px;
        }
        .d{
            display: block;
        }
        .nbr{
            height: 50px;
            float: left;
            font-size: 1.1rem;
            color: white;
            display: flex;
            align-items: center;
            margin-left: 5px;
            width: 140px;
            justify-content: center;
            margin-right: 5px;
        }
        .time{
            height: 50px;
            float: left;
            font-size: 1.1rem;
            color: white;
            display: flex;
            align-items: center;
            margin-left: 5px;
            margin-right: 10px;
            padding-right: 10px;
            justify-content: center;
            text-align: center;
        }
        #dadd{
            position: relative;
            margin-left: 10px;
        }
        .n1in{
            padding: 10px 5px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: #1d2b3a;
            border-radius: 5px;
            outline: none;
            color: #fff;
            font-size: 1.2rem;
            transition: 0.25s;
            margin: 8px 0px 8px 0%;
            width: calc(100% - 22px);
            -moz-appearance: textfield;
        }
        .n1in:focus{
            border: 1px solid #00dfc4;
        }
        .spn1{
            position: absolute;
            padding: 10px;
            pointer-events: none;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.25);
            text-transform: uppercase;
            transition: 0.25s;
            margin: 8px 0px 8px 0%;
            left: 0;

        }
        .n1in:focus ~ .spn1,.n1in:not(:placeholder-shown) ~ .spn1{
            transform: translateX(5px) translateY(-4px);
            padding: 0px 10px;
            font-size: 0.65rem;
            background: #00dfc4;
            color: #1d2b3a;
            border-radius: 2px;
        }
        .aclear{
            padding: 5px;
            margin: 0px 7px 7px 7px;
            font-size: 1.2rem;
            background-color: #2ecc71;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            position: absolute;
            right: 0;
            bottom: 0;
        }
        .aclear:hover{
            background-color: #87805E;
        }
        .daclear{
            padding: 5px;
            margin: 0px 7px 7px 7px;
            font-size: 1.2rem;
            background-color: #717375;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: no-drop;
            position: absolute;
            right: 0;
            bottom: 0;
        }
        .cnslbtn{
            float: left;
            margin-top: 10px;
            cursor: pointer;
            padding: 5px;
            margin: 7px;
            border-radius: 5px;
            font-size: 1.2rem;
        }
        .cnslbtn:hover{
            background-color: #4C3A51;
        }
        .more{
            color: white;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
            width: 50%;
            display: block;
            font-size: 1rem;
            padding: 3px 0px;
            margin: 5px 0px 0px 0px;
            border-radius: 5px;
            float: left;
        }
        .more:hover{
            background-color: #2C3639;
        }
        .dmore{
            color: gray;
            text-decoration: none;
            text-align: center;
            width: 50%;
            display: block;
            font-size: 1rem;
            padding: 3px 0px;
            margin: 5px 0px 0px 0px;
            border-radius: 5px;
            float: left;
            cursor: context-menu;
        }
        @media screen and (max-width:300px) {
            #content{
                width: 220px;
            }
            .imgcon{
                width: 220px;
            }
        }
        @media screen and (max-width:425px) {
            .msg{
                min-width: 0;
            }
        }
    </style>
    <title>Matsnach</title>
</head>
<body class="bod">
    <section style="display: flex;flex-wrap: wrap;justify-content: center;">
        <?php
        $id = $_SESSION['user']->id;

        if (isset($_GET['sr'])) {
            $show = $db->prepare("SELECT * FROM clinic WHERE ful_name = :fulname");
            $show->bindParam('fulname',$_GET['sr']);
            $show->execute();
        }else {
            $show = $db->prepare("SELECT * FROM clinic");
            $show->execute();
        }
        
        foreach ($show as $result) {
            $chec = $db->prepare("SELECT stat FROM post_status WHERE poste_id = :p_id");
            $chec->bindParam('p_id',$result['id']);
            $chec->execute();

            $imgshow = 'data:'.$result['type'].';base64,'.base64_encode($result['img']);       
            echo'
            <div id="content">';

            $take = $db->prepare("SELECT * FROM favorit WHERE user_id = :id AND poste_id = :p_id");
            $take->bindParam('id',$id);
            $take->bindParam('p_id',$result['id']);
            $take->execute();

            if ($take->rowCount()>0) {
                echo'<form action="" method="post">
                    <input type="text" name="id" style="display :none" value="'.$result['id'].'">
                    <label for="dfavorit'.$result['id'].'"><img src="img/icons8-bookmarks-64 (1).png" alt="" class="bbkm"></label>
                    <button type="submit" name="dfavorit" style="display :none" id="dfavorit'.$result['id'].'"></button>
                </form>';
            }else {
                echo'<form action="" method="post">
                    <input type="text" name="id" style="display :none" value="'.$result['id'].'">
                    <label for="favorit'.$result['id'].'"><img src="img/icons8-bookmark-50 (1).png" alt="" class="bkm" name="bkm"></label>
                    <button type="submit" name="favorit" style="display :none" id="favorit'.$result['id'].'"></button>
                </form>';
            }
            if ($result['type']) {
                echo'<div class="imgcon"><img src="'.$imgshow.'" alt="" class="myimg" data-src="'.$imgshow.'"></div>';
            }else{
                echo'<div class="imgcon"><img src="img/icons8-no-camera-100.png" alt="" class="noimg"></div>';
            }
                echo'<table class="tab">
                    <tr><td class="td">Dr: '.$result['l_name'].' '.$result['f_name'].'</td>';
                    if ($chec->rowCount()>0) {
                        $stat = $chec->fetchObject();
                        if ($stat->stat == 0) {
                            echo'<td class="td1" rowspan="2" style="color: gray;"><div class="lite" style="background-color: gray;"></div>Closed</td></tr>';
                        }elseif ($stat->stat == 1) {
                            echo'<td class="td1" rowspan="2" style="color: olivedrab;"><div class="lite" style="background-color: olivedrab;"></div>Open</td></tr>';
                        }elseif ($stat->stat == 2) {
                            echo'<td class="td1" rowspan="2" style="color: red;"><div class="lite" style="background-color: red;"></div>Break</td></tr>';
                        }
                    }else {
                        echo'<td class="td1" rowspan="2" style="color: gray;"><div class="lite" style="background-color: gray;"></div>Closed</td></tr>';
                    }
                    if ($result['job'] != '') {
                        echo'<tr><td class="td" style="color: olivedrab;">'.$result['job'].'</td>';
                    }
                $calc = $db->prepare("SELECT * FROM chane WHERE post_id = :p_id");
                $calc->bindParam('p_id',$result['id']);
                $calc->execute();
                $i = 1;
                foreach ($calc as $nbd) {
                    $i = $i + 1;
                }
                $sw = $result['sw'];
                $ew = $result['ew'];
                $bs = $result['bs'];
                $be = $result['be'];
                $tpc = $result['tpc'];
                
                if ($bs == '00:00:00' && $be == '00:00:00') {
                    $time1 = new DatePeriod(new DateTime($sw), new DateInterval('PT'.$tpc.'M'), new DateTime($ew));
                    $b = 0;
                    $time = array();
                    foreach ($time1 as $t) {
                        $time[$b] = $t->format('H:i:s');
                        $b = $b + 1;
                    }
                }else {
                    $time1 = new DatePeriod(new DateTime($sw), new DateInterval('PT'.$tpc.'M'), new DateTime($bs));
                    $time2 = new DatePeriod(new DateTime($be), new DateInterval('PT'.$tpc.'M'), new DateTime($ew));
                    $b = 0;
                    $time = array();
                    foreach ($time1 as $t) {
                        $time[$b] = $t->format('H:i:s');
                        $b = $b + 1;
                    }
                    foreach ($time2 as $t) {
                        $time[$b] = $t->format('H:i:s');
                        $b = $b + 1;
                    }
                }
                echo'<div class="msg">
                <form action="" method="post">
                    <input type="text" name="id" style="display :none" value="'.$result['id'].'">
                    <div class="nbr">Patient N°: '.$i.'</div>';
                    if ($i <= count($time)) {
                        echo'<div class="time">Estimated arrival time: '.$time[$i - 1].'</div>';
                    } else {
                        echo"<div class='time'>I've run out of places</div>";
                    }
                    echo'<div id="dadd">
                        <input type="text" name="fname" class="n1in" required placeholder="">
                        <span class="spn1">First Name</span><br>
                    </div>
                    <div id="dadd">
                        <input type="text" name="lname" class="n1in" required placeholder="">
                        <span class="spn1">Last Name</span><br>
                    </div>';
                    if ($i <= count($time)) {
                        echo'<button type="submit" name="add" class="aclear">Add</button>';
                    } else {
                        echo'<button class="daclear" disabled>Add</button>';
                    }
                    echo'<a class="cnslbtn">Cancel</a>
                    </form>
                </div>
                </table>
                <div>
                    <a href="show.php?id='.$result['id'].'" class="more">Show more</a>';
                    if ($chec->rowCount()>0) {
                        if ($stat->stat == 1 || $stat->stat == 2) {
                            echo'<a class="more" id="rndv">Reservation</a>';
                        }else {
                            echo'<a class="dmore">Reservation</a>';
                        }
                    }else {
                        echo'<a class="dmore">Reservation</a>';
                    }
                echo'</div>
            </div>
            ';
        }
        ?>
    </section>
</body>
<script>
    const book = ()=>{
    const bkm = document.querySelectorAll('.bkm');
    bkm.forEach((bkm,index)=>{               
        bkm.addEventListener('click',()=>{
            bkm.src = "img/icons8-bookmarks-64 (1).png";
            bkm.classList.add('bbkm');
            bkm.classList.remove('bkm');
            const bbkm = document.querySelectorAll('.bbkm');
            mark();
        })
    })
    }
    book();
    const mark = ()=>{
    const bbkm = document.querySelectorAll('.bbkm');
    bbkm.forEach((bbkm,index)=>{               
        bbkm.addEventListener('click',()=>{
            bbkm.src = "img/icons8-bookmark-50 (1).png";
            bbkm.classList.add('bkm');
            bbkm.classList.remove('bbkm');
            const bkm = document.querySelectorAll('.bkm');
            book();
        })
    })
    }
    mark();
    $(document).ready(function(){
        $(document).on("click","#rndv",function(){
            $btn = $(this).parent().siblings('div.msg').toggleClass("d");
            document.getElementById("m-over").style.display="block";
        });
    });
    $(document).ready(function(){
        $(document).on("click","#m-over",function(){
            $btn.toggleClass("d");
            document.getElementById("m-over").style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on("click",".cnslbtn",function(){
            $btn.toggleClass("d");
            document.getElementById("m-over").style.display="none";
        });
    });
</script>
</html>