<?php
session_start();
require_once 'cdb.php';
if(isset($_SESSION['user'])){
    if (isset($_POST['exit'])) {
        session_unset();
        session_destroy();
        header("location:http://localhost/dr/login fr.php");
    }
    if(isset($_POST['cadd'])){
        $id = $_SESSION['user']->id;
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $adress = $_POST['adress'];
        $job = $_POST['job'];
        $f_num = $_POST['f_num'];
        // $facb = $_POST['facb'];
        $sw = $_POST['sw'];
        $ew = $_POST['ew'];
        $bs = $_POST['bs'];
        $be = $_POST['be'];
        $su = isset($_POST['su']);
        $mo = isset($_POST['mo']);
        $tu = isset($_POST['tu']);
        $we = isset($_POST['we']);
        $th = isset($_POST['th']);
        $fr = isset($_POST['fr']);
        $sa = isset($_POST['sa']);
        $tpc = $_POST['ctime'];
        $prix = $_POST['prix'];
        $fulname = $lname.' '.$fname;
        
        if ($_FILES['img']['type'][0] == '') {
            $add = $db->prepare("INSERT INTO clinic(user_id,f_name,l_name,adress,job,fone,sw,ew,bs,be,su,mo,tu,we,th,fr,sa,tpc,prix,ful_name)
            VALUES(:id,:fname,:lname,:adress,:job,:fonne,:sw,:ew,:bs,:be,:su,:mo,:tu,:we,:th,:fr,:sa,:tpc,:prix,:ful_name)");
            $add->bindParam('id',$id);
            $add->bindParam('fname',$fname);
            $add->bindParam('lname',$lname);
            $add->bindParam('adress',$adress);
            $add->bindParam('job',$job);
            $add->bindParam('fonne',$f_num);
            $add->bindParam('sw',$sw);
            $add->bindParam('ew',$ew);
            $add->bindParam('bs',$bs);
            $add->bindParam('be',$be);
            $add->bindParam('su',$su);
            $add->bindParam('mo',$mo);
            $add->bindParam('tu',$tu);
            $add->bindParam('we',$we);
            $add->bindParam('th',$th);
            $add->bindParam('fr',$fr);
            $add->bindParam('sa',$sa);
            $add->bindParam('tpc',$tpc);
            $add->bindParam('prix',$prix);
            $add->bindParam('ful_name',$fulname);
            if ($add->execute()) {
                header("location:add.php",true);
            }
        }else{
            $img = file_get_contents($_FILES['img']['tmp_name']);
            $type = $_FILES['img']['type'];

            $add = $db->prepare("INSERT INTO clinic(user_id,img,type,f_name,l_name,adress,job,fone,sw,ew,bs,be,su,mo,tu,we,th,fr,sa,tpc,prix,ful_name)
            VALUES(:id,:img,:type,:fname,:lname,:adress,:job,:fonne,:sw,:ew,:bs,:be,:su,:mo,:tu,:we,:th,:fr,:sa,:tpc,:prix,:ful_name)");
            $add->bindParam('id',$id);
            $add->bindParam('img',$img);
            $add->bindParam('type',$type);
            $add->bindParam('fname',$fname);
            $add->bindParam('lname',$lname);
            $add->bindParam('adress',$adress);
            $add->bindParam('job',$job);
            $add->bindParam('fonne',$f_num);
            $add->bindParam('sw',$sw);
            $add->bindParam('ew',$ew);
            $add->bindParam('bs',$bs);
            $add->bindParam('be',$be);
            $add->bindParam('su',$su);
            $add->bindParam('mo',$mo);
            $add->bindParam('tu',$tu);
            $add->bindParam('we',$we);
            $add->bindParam('th',$th);
            $add->bindParam('fr',$fr);
            $add->bindParam('sa',$sa);
            $add->bindParam('tpc',$tpc);
            $add->bindParam('prix',$prix);
            $add->bindParam('ful_name',$fulname);
            if ($add->execute()) {
                header("location:add.php",true);
            }
        }
    }
}else{
    header("location:login fr.php",true);
}    
require_once 'header fr.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        #bod{
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
            width: 97px;
        }
        .lite{
            height: 15px;
            width: 15px;
            float: left;
            border-radius: 25px;
            margin: 3px;
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
        .add{
            width: 270px;
            height: 280px;
            cursor: pointer;
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
        }
        .add:hover{
            background-color: #191919;
        }
        #fadd{
            display: none;
            position: absolute;
            top: 0%;
            left: 50%;
            transform: translate(-50%,-0%);
            margin: 10px 0px;
            width: 80vw;
            background-color: #1d2b3a;
            float: left;
            grid-template-columns: repeat(8,12.5%);
            grid-template-rows: repeat(12,60px);
            gap: 10px 0px;
            z-index: 10;
            border-radius: 5px;
            padding-bottom: 5px;
        }
        .h{
            grid-column: 1/9;
            grid-row: 1;
            justify-content: center;
            align-items: end;
            display: flex;
            color: #fff;
            font-size: 2rem;
        }
        .l{
            height: 60px;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            justify-content: center;
            align-items: center;
            display: flex;
            color: rgba(0,0,0,.87)!important;
            margin: auto;
            margin-top: 5px;
            grid-column: 1/9;
            grid-row: 2;
        }
        .l > p{
            color: white;
            
        }
        input[type="file"]{
            display: none;
        }
        .in{
            padding: 10px 5px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: #1d2b3a;
            border-radius: 5px;
            outline: none;
            color: #fff;
            font-size: 1.2rem;
            transition: 0.25s;
            margin: 8px 0px 8px 10%;
            width: 80%;
            -moz-appearance: textfield;
        }
        .sp{
            position: absolute;
            padding: 10px;
            pointer-events: none;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.25);
            text-transform: uppercase;
            transition: 0.25s;
            margin: 8px 0px 8px 0%;
            left: 10%;
        }
        .sp1{
            position: absolute;
            padding: 10px;
            pointer-events: none;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.25);
            text-transform: uppercase;
            transition: 0.25s;
            margin: 8px 0px 8px 0%;
            left: 10%;
        }
        .in:focus{
            border: 1px solid #00dfc4;
        }
        .in:focus ~ .sp,.in:not(:placeholder-shown) ~ .sp,
        .in:focus ~ .sp1,.in:not(:placeholder-shown) ~ .sp1{
            transform: translateX(5px) translateY(-4px);
            padding: 0px 10px;
            font-size: 0.65rem;
            background: #00dfc4;
            color: #1d2b3a;
            border-radius: 2px;
        }
        #cadd{
            width: 100%;
            position: relative;
        }
        .in-1{
            grid-column: 1/5;
            grid-row: 3;
        }
        .in0{
            grid-column: 5/9;
            grid-row: 3;
        }
        .in1{
            grid-column: 1/9;
            grid-row: 4;
        }
        .in1-5{
            grid-column: 5/9;
            grid-row: 5;
        }
        .in2{
            grid-column: 1/5;
            grid-row: 5;
        }
        .in4{
            grid-column: 1/5;
            grid-row: 6;
        }
        .in5{
            grid-column: 1/5;
            grid-row: 7;
        }
        .in6{
            grid-column: 5/9;
            grid-row: 6;
        }
        .in7{
            grid-column: 5/9;
            grid-row: 7;
        }
        .in7-5{
            grid-column: 1/9;
            grid-row: 8;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 1.3rem;
        }
        .ch0{
            background-color: #d5d5d5;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }
        .ch{
            background-color: #d5d5d5;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }
        .ch:hover{
            background-color: #a5a5a5;
        }
        .ch:checked{
            background-color: #2ecc71;
        }
        .r{
            color: white;
            margin-left: 5px;
            cursor: pointer;
        }
        .in8{
            grid-column: 1/2;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in9{
            grid-column: 2/3;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in10{
            grid-column: 3/4;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in11{
            grid-column: 4/5;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in12{
            grid-column: 5/6;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in13{
            grid-column: 6/7;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in14{
            grid-column: 7/8;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in15{
            grid-column: 8/9;
            grid-row: 9;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .in16{
            grid-column: 1/5;
            grid-row: 10;
        }
        .in17{
            grid-column: 5/9;
            grid-row: 10;
        }
        .btn{
            grid-column: 3/7;
            grid-row: 11;
            background: none;
            border: 2px solid #2ecc71;
            border-radius: 5px;
            height: 45px;
            font-size: 1.2rem;
            padding: 10px 0px;
            cursor: pointer;
            color: #fff;
            margin: 7.5px 0px;
            transition: 0.25s;
        }
        .btn:hover{
            background-color: #2ecc71;
        }
        .an{
            grid-column: 3/7;
            grid-row: 12;
            background: none;
            border: 2px solid #2ecc71;
            border-radius: 5px;
            height: 45px;
            font-size: 1.2rem;
            padding: 10px 0px;
            height: 21px;
            margin: 7.5px 0px;
            transition: 0.25s;
            cursor: pointer;
            text-align: center;
            color: #fff;
        }
        .an:hover{
            background-color: #2ecc71;
        }
        @media screen and (max-width:1170px) {
            #fadd{
                grid-template-rows: repeat(13,60px);
            }
            .in8{
                grid-column: 1/3;
            }
            .in9{
                grid-column: 3/5;
            }
            .in10{
                grid-column: 5/7;
            }
            .in11{
                grid-column: 7/9;
            }
            .in12{
                grid-column: 1/3;
                grid-row: 10;
            }
            .in13{
                grid-column: 3/5;
                grid-row: 10;
            }
            .in14{
                grid-column: 5/7;
                grid-row: 10;
            }
            .in15{
                grid-column: 7/9;
                grid-row: 10;
            }
            .in16{
                grid-row: 11;
            }
            .in17{
                grid-row: 11;
            }
            .btn{
                grid-row: 12;
            }
            .an{
                grid-row: 13;
            }
        }
        @media screen and (max-width:797px) {
            .sp1{
                margin: 0;
            }
            .in:focus ~ .sp1,.in:not(:placeholder-shown) ~ .sp1{
                transform: translateX(5px) translateY(3px);
            }
        }
        @media screen and (max-width:580px) {
            #fadd{
                grid-template-rows: repeat(20,60px);
            }
            .sp1{
                margin: 8px 0;
            }
            .in:focus ~ .sp1,.in:not(:placeholder-shown) ~ .sp1{
                transform: translateX(5px) translateY(-4px);
            }
            .in-1{
                grid-column: 1/9;
            }
            .in0{
                grid-column: 1/9;
                grid-row: 4;
            }
            .in1{
                grid-column: 1/9;
                grid-row: 5;
            }
            .in1-5{
                grid-column: 1/9;
                grid-row: 6;
            }
            .in2{
                grid-column: 1/9;
                grid-row: 7;
            }
            .in4{
                grid-column: 1/9;
                grid-row: 8;
            }
            .in5{
                grid-column: 1/9;
                grid-row: 9;
            }
            .in6{
                grid-column: 1/9;
                grid-row: 10;
            }
            .in7{
                grid-column: 1/9;
                grid-row: 11;
            }
            .in7-5{
                grid-column: 1/9;
                grid-row: 12;
            }
            .in8{
                grid-column: 1/5;
                grid-row: 13;
            }
            .in9{
                grid-column: 5/9;
                grid-row: 13;
            }
            .in10{
                grid-column: 1/5;
                grid-row: 14;
            }
            .in11{
                grid-column: 5/9;
                grid-row: 14;
            }
            .in12{
                grid-column: 1/5;
                grid-row: 15;
            }
            .in13{
                grid-column: 5/9;
                grid-row: 15;
            }
            .in14{
                grid-column: 1/5;
                grid-row: 16;
            }
            .in15{
                grid-column: 5/9;
                grid-row: 16;
            }
            .in16{
                grid-column: 1/9;
                grid-row: 17;
            }
            .in17{
                grid-column: 1/9;
                grid-row: 18;
            }
            .btn{
                grid-column: 3/7;
                grid-row: 19;
            }
            .an{
                grid-column: 3/7;
                grid-row: 20;
            }
        }
        @media screen and (max-width:398px) {
            .h{
                font-size: 1.7rem;
            }
            .sp1{
                margin: 0;
            }
            .in:focus ~ .sp1,.in:not(:placeholder-shown) ~ .sp1{
                transform: translateX(5px) translateY(3px);
            }
        }
        @media screen and (max-width:327px) {
            .h{
                font-size: 1.3rem;
            }
            .l > p{
                font-size: 1.1rem;
            }
        }
        @media screen and (max-width:300px) {
            #content{
                width: 220px;
            }
            .imgcon{
                width: 220px;
            }
            .add{
                width: 220px;
            }
        }
    </style>
    <title>Ajouter une clinique</title>
</head>
<body id="bod">
    <section style="display: flex;flex-wrap: wrap;justify-content: center;">
        <?php
        $id = $_SESSION['user']->id;
        
        $show = $db->prepare("SELECT * FROM clinic WHERE user_id = :id");
        $show->bindParam('id',$id);
        $show->execute();
        
        foreach ($show as $result) {
            $chec = $db->prepare("SELECT stat FROM post_status WHERE poste_id = :p_id");
            $chec->bindParam('p_id',$result['id']);
            $chec->execute();

            $imgshow = 'data:'.$result['type'].';base64,'.base64_encode($result['img']);       
            echo'
            <div id="content">';
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
                            echo'<td class="td1" rowspan="2" style="color: gray;"><div class="lite" style="background-color: gray;"></div>Fermer</td></tr>';
                        }elseif ($stat->stat == 1) {
                            echo'<td class="td1" rowspan="2" style="color: olivedrab;"><div class="lite" style="background-color: olivedrab;"></div>Ouverte</td></tr>';
                        }elseif ($stat->stat == 2) {
                            echo'<td class="td1" rowspan="2" style="color: red;"><div class="lite" style="background-color: red;"></div>On pause</td></tr>';
                        }
                    }else {
                        echo'<td class="td1" rowspan="2" style="color: gray;"><div class="lite" style="background-color: gray;"></div>Fermer</td></tr>';
                    }
                    if ($result['job'] != '') {
                        echo'<tr><td class="td" style="color: olivedrab;">'.$result['job'].'</td>';
                    }
                echo'</table>
                <a href="show more fr.php?id='.$result['id'].'" class="more" data-id="'.$result['id'].'">Montre plus</a>
            </div>
            ';
        }
        ?>
        <img src="img/add-image.png" alt="" class="add">
        <div class="mfadd">
            <form action="" method="post" id="fadd" enctype="multipart/form-data">
                <h1 class="h">Ajouter une clinique</h1>
                <input type="file" id="file" name="img" class="img" accept="image/*,video/*">
                <label for="file" class="l"><img src="img/icons8-add-image-64.png" alt="" width="30px">
                <p>Choisissez une photo</p></label><br>
                <div id="cadd" class="in-1">
                    <input type="text" name="fname" class="in" required placeholder="">
                    <span class="sp">Prénom</span><br>
                </div>
                <div id="cadd" class="in0">
                    <input type="text" name="lname" class="in" required placeholder="">
                    <span class="sp" id="sp1">Nom</span><br>
                </div>
                <div id="cadd" class="in1">
                    <input type="text" name="adress" class="in" placeholder="">
                    <span class="sp">Adresse</span><br>
                </div>
                <div id="cadd" class="in1-5">
                    <input type="text" name="job" class="in" placeholder="">
                    <span class="sp">Métier</span><br>
                </div>
                <div id="cadd" class="in2">
                    <input type="number" name="f_num" class="in" placeholder="">
                    <span class="sp">téléphone</span><br>
                </div>
                <div id="cadd" class="in4">
                    <input type="text" name="sw" class="in" required placeholder="" onfocus="(this.type='time')">
                    <span class="sp">Début du travail</span><br>
                </div>
                <div id="cadd" class="in5">
                    <input type="text" name="ew" class="in" required placeholder="" onfocus="(this.type='time')">
                    <span class="sp">Fin du travail</span><br>
                </div>
                <div id="cadd" class="in6">
                    <input type="text" name="bs" class="in" placeholder="" onfocus="(this.type='time')">
                    <span class="sp" id="sp1">Début de pause</span><br>
                </div>
                <div id="cadd" class="in7">
                    <input type="text" name="be" class="in" placeholder="" onfocus="(this.type='time')">
                    <span class="sp" id="sp1">Fin de pause</span><br>
                </div>
                <span class="in7-5">Jours ouvrés</span>
                <div id="cadd" class="in8">
                    <input type="checkbox" name="al" id="r" class="ch0" onchange="sel()" value="al">
                    <label for="r" class="r">Toute</label><br>
                </div>
                <div id="cadd" class="in9">
                    <input type="checkbox" name="su" id="r1" class="ch" onchange="nsel()" value="su">
                    <label for="r1" class="r">Dimanche</label><br>
                </div>
                <div id="cadd" class="in10">
                    <input type="checkbox" name="mo" id="r2" class="ch" onchange="nsel()" value="mo">
                    <label for="r2" class="r">Lundi</label><br>
                </div>
                <div id="cadd" class="in11">
                    <input type="checkbox" name="tu" id="r3" class="ch" onchange="nsel()" value="tu">
                    <label for="r3" class="r">Mardi</label><br>
                </div>
                <div id="cadd" class="in12">
                    <input type="checkbox" name="we" id="r4" class="ch" onchange="nsel()" value="we">
                    <label for="r4" class="r">Mercredi</label><br>
                </div>
                <div id="cadd" class="in13">
                    <input type="checkbox" name="th" id="r5" class="ch" onchange="nsel()" value="th">
                    <label for="r5" class="r">Jeudi</label><br>
                </div>
                <div id="cadd" class="in14">
                    <input type="checkbox" name="fr" id="r6" class="ch" onchange="nsel()" value="fr">
                    <label for="r6" class="r">Vendredi</label><br>
                </div>
                <div id="cadd" class="in15">
                    <input type="checkbox" name="sa" id="r7" class="ch" onchange="nsel()" value="sa">
                    <label for="r7" class="r">Samedi</label><br>
                </div>
                <div id="cadd" class="in16">
                    <input type="number" name="ctime" class="in" required placeholder="">
                    <span class="sp1">Temps pour chaque client</span><br>
                </div>
                <div id="cadd" class="in17">
                    <input type="number" name="prix" class="in" placeholder="">
                    <span class="sp">Le prix</span><br>
                </div>
                <button name="cadd" class="btn">Ajouter</button>
                <a class="an">Annuler</a>
            </form>
        </div>
    </section>
</body>
<script>
    const lnga = document.getElementById('alnga').href="add ar.php";
    const lng = document.getElementById('alng').href="add.php";
    const lngf = document.getElementById('alngf').href="add fr.php";
    $(document).ready(function(){
        $(document).on('click','.add',function(){
            document.getElementById('m-over').style.display="block";
            document.getElementById('fadd').style.display="grid";
            window.scrollTo(0,0);
        });
    });
    $(document).ready(function(){
        $(document).on('click','.an',function(){
            document.getElementById('m-over').style.display="none";
            document.getElementById('fadd').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','#m-over',function(){
            document.getElementById('m-over').style.display="none";
            document.getElementById('fadd').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','#r',function(){
            document.getElementById('r').v;
        });
    });
    const chall = document.querySelector('#r');
    const chop = document.querySelectorAll('.ch');
    function sel(){
        const isch = chall.checked;
        for (let i = 0; i < chop.length; i++) {
            chop[i].checked = isch;
        }
    }
    function nsel(){
        chall.checked = false;
    }
</script>
</html>