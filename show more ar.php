<?php
session_start();
require_once 'cdb.php';
if (isset($_GET['id'])) {
    $p_id = $_GET['id'];
    $_SESSION['p_id'] = $p_id;
}else{
    header("location:login ar.php",true);
}
$id = $_SESSION['user']->id;
$p_id = $_SESSION['p_id'];
if (isset($_POST['add'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    $add = $db->prepare("INSERT INTO chane(post_id,l_name,f_name)
    VALUES(:p_id,:lname,:fname)");
    $add->bindParam('p_id',$p_id);
    $add->bindParam('lname',$lname);
    $add->bindParam('fname',$fname);
    if ($add->execute()) {
        header("location:show more ar.php?id=$p_id",true);
    }
}
if (isset($_POST['clr'])) {
    $del = $db->prepare("DELETE FROM chane WHERE post_id = :p_id");
    $del->bindParam('p_id',$p_id);
    if ($del->execute()) {
        header("location:show more ar.php?id=$p_id",true);
    }
}
if (isset($_POST['del'])) {
    $delp = $db->prepare("DELETE FROM post_status WHERE poste_id = :p_id");
    $delp->bindParam('p_id',$p_id);
    $delp->execute();
    $delc = $db->prepare("DELETE FROM chane WHERE post_id = :p_id");
    $delc->bindParam('p_id',$p_id);
    $delc->execute();
    $delf = $db->prepare("DELETE FROM favorit WHERE poste_id = :p_id");
    $delf->bindParam('p_id',$p_id);
    $delf->execute();
    $del = $db->prepare("DELETE FROM clinic WHERE id = :p_id");
    $del->bindParam('p_id',$p_id);
    if ($del->execute()) {
        header("location:add ar.php",true);
    }
}
if (isset($_POST['op'])) {
    $chec = $db->prepare("SELECT * FROM post_status WHERE user_id = :id AND poste_id = :p_id");
    $chec->bindParam('id',$id);
    $chec->bindParam('p_id',$p_id);
    $chec->execute();
    if ($chec->rowCount()>0) {
        $op = $db->prepare("UPDATE post_status SET stat = 1 WHERE user_id = :id AND poste_id = :p_id");
        $op->bindParam('id',$id);
        $op->bindParam('p_id',$p_id);
        if ($op->execute()) {
            header("location:show more ar.php?id=$p_id",true);
        }
    } else {
        $add = $db->prepare("INSERT INTO post_status(user_id,poste_id)
        VALUES(:id,:poste_id)");
        $add->bindParam('id',$id);
        $add->bindParam('poste_id',$p_id);
        $add->execute();

        $op = $db->prepare("UPDATE post_status SET stat = 1 WHERE user_id = :id AND poste_id = :p_id");
        $op->bindParam('id',$id);
        $op->bindParam('p_id',$p_id);
        if ($op->execute()) {
            header("location:show more ar.php?id=$p_id",true);
        }
    }    
}
if (isset($_POST['ps'])) {
    $ps = $db->prepare("UPDATE post_status SET stat = 2 WHERE user_id = :id AND poste_id = :p_id");
    $ps->bindParam('id',$id);
    $ps->bindParam('p_id',$p_id);
    if ($ps->execute()) {
        header("location:show more ar.php?id=$p_id",true);
    }
}
if (isset($_POST['cl'])) {
    $cl = $db->prepare("UPDATE post_status SET stat = 0 WHERE user_id = :id AND poste_id = :p_id");
    $cl->bindParam('id',$id);
    $cl->bindParam('p_id',$p_id);
    if ($cl->execute()) {
        header("location:show more ar.php?id=$p_id",true);
    }
}
if (isset($_POST['editbtn'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $adress = $_POST['adress'];
    $job = $_POST['job'];
    $f_num = $_POST['f_num'];
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
        $add = $db->prepare("UPDATE clinic SET f_name = :fname, l_name = :lname, adress = :adress, job = :job,
        fone = :fonne, sw = :sw, ew = :ew, bs = :bs, be = :be, su = :su, mo = :mo, tu = :tu,
        we = :we, th = :th, fr = :fr, sa = :sa, tpc = :tpc, prix = :prix, ful_name = :fulname WHERE id = :p_id");
        $add->bindParam('p_id',$p_id);
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
        $add->bindParam('fulname',$fulname);
        if ($add->execute()) {
            header("location:show more.php?id=$p_id",true);
        }
    }else{
        $img = file_get_contents($_FILES['img']['tmp_name']);
        $type = $_FILES['img']['type'];

        $add = $db->prepare("UPDATE clinic SET img = :img, type = :type, f_name = :fname, l_name = :lname, adress = :adress, job = :job,
        fone = :fonne, facebook = :fac, sw = :sw, ew = :ew, bs = :bs, be = :be, su = :su, mo = :mo, tu = :tu,
        we = :we, th = :th, fr = :fr, sa = :sa, tpc = :tpc, prix = :prix, ful_name = :fulname WHERE id = :p_id");
        $add->bindParam('p_id',$p_id);
        $add->bindParam('img',$img);
        $add->bindParam('type',$type);
        $add->bindParam('fname',$fname);
        $add->bindParam('lname',$lname);
        $add->bindParam('adress',$adress);
        $add->bindParam('job',$job);
        $add->bindParam('fonne',$f_num);
        $add->bindParam('fac',$facb);
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
        $add->bindParam('fulname',$fulname);
        if ($add->execute()) {
            header("location:show more.php?id=$p_id",true);
        }
    }
}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        .bod{
            background-color: #2C3639;
        }
        .content{
            display: grid;
            grid-template-columns: repeat(9,11%);
            grid-template-rows: repeat(7,60px);
            margin: 7px;
            background-color: #191919;
            padding: 4px;
            gap: 10px 0px;
            border-radius: 7px;
            justify-content: center;
            position: relative;
        }
        .edit-btn{
            grid-column: 1/3;
            grid-row: 1;
            color: white;
            font-size: 1.1rem;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid #2ecc71;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 30px;
            margin: 8px;
            transition: 0.25s;
        }
        .edit-btn:hover{
            background-color: #2ecc71;
        }
        .delbtn{
            grid-column: 8/10;
            grid-row: 1;
            float: right;
            color: white;
            font-size: 1.1rem;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid #E04D01;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 30px;
            margin: 8px;
            position: absolute;
            left: 0;
            top: 0;
            transition: 0.25s;
        }
        .delbtn:hover{
            background-color: #E04D01;
        }
        h1{
            color: white;
            padding: 5px;
            text-align: center;
            grid-column: 3/8;
            grid-row: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .imgcon{
            float: right;
            padding: 5px 15px;
            grid-column: 1/4;
            grid-row: 2/5;
        }
        .myimg{
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }
        .noimg{
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center center;
        }
        .sp{
            color: white;
            padding: 5.5px;
            font-size: 1.2rem;
            height: 21px;
            margin: 14px 0px;
            flex-shrink: 0;
        }
        .nsp{
            flex-shrink: 0;
            color: #8c8c8c;
            padding: 5.5px;
            font-size: 1.2rem;
            height: 21px;
            margin: 14px 0px;
        }
        #in{
            font-size: 1.2rem;
            padding: 5px;
            color: white;
            float: right;
            width: 100%;
            height: 22px;
            margin: 12px 0px;
            border-radius: 5px;
            border: 2px solid #8c8c8c;
        }
        #bin{
            border: 2px solid #8c8c8c;
            border-radius: 5px;
            font-size: 1.2rem;
            padding: 5px;
            color: white;
            float: right;
            width: 100%;
            height: 22px;
            margin: 12px 0px;
        }
        .edit{
            width: 20px;
            position: absolute;
            left: 2px;
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
            visibility: hidden;
        }
        .edit1{
            width: 20px;
            cursor: pointer;
            padding: 5px;
            border-radius: 3px;
            visibility: hidden;
        }
        .edit:hover{
            background-color: #a5a5a5;
            visibility: visible;
        }
        .edit1:hover{
            background-color: #2C3639;
            visibility: visible;
        }
        .sp:hover ~ .edit{
            visibility: visible;
        }
        .sp:hover ~ .edit1{
            visibility: visible;
        }
        .nsp:hover ~ .edit1{
            visibility: visible;
        }
        #in:hover ~ .edit{
            visibility: visible;
        }
        #bin:hover ~ .edit{
            visibility: visible;
        }
        .gr1{
            grid-column: 4/7;
            grid-row: 2;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr2{
            grid-column: 7/10;
            grid-row: 2;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr3{
            grid-column: 4/7;
            grid-row: 3;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr4{
            grid-column: 7/10;
            grid-row: 3;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr5{
            grid-column: 4/7;
            grid-row: 4;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr6{
            grid-column: 7/10;
            grid-row: 4;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr7{
            grid-column: 1/2;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr8{
            grid-column: 2/3;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr9{
            grid-column: 3/4;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr10{
            grid-column: 4/5;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr11{
            grid-column: 5/6;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr12{
            grid-column: 6/7;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr13{
            grid-column: 7/8;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr14{
            grid-column: 8/9;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr15{
            grid-column: 1/6;
            grid-row: 6;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr16{
            grid-column: 6/10;
            grid-row: 6;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr17{
            grid-column: 1/4;
            grid-row: 7;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr18{
            grid-column: 4/7;
            grid-row: 7;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .gr19{
            grid-column: 7/10;
            grid-row: 7;
            align-items: center;
            justify-content: center;
            display: flex;
            position: relative;
        }
        .chaine{
            background-color: #191919;
            border-radius: 5px;
            margin: 7px;
            min-height: 140px;
        }
        .hch{
            color: white;
            text-align: center;
            padding: 15px;
            display: flex;
            justify-content: center;
        }
        .add{
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
        }
        .add:hover{
            background-color: #87805E;
        }
        .clear{
            padding: 5px;
            margin: 0px 7px 7px 7px;
            font-size: 1.2rem;
            background-color: #E04D01;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            position: absolute;
            left: 0;
        }
        .clear:hover{
            background-color: orangered;
        }
        .prbtn{
            display: flex;
            justify-content: center;
            margin: 5px 0px 15px 0px;
        }
        .pb{
            padding: 5px;
            margin: 0px 15px;
            font-size: 1.2rem;
            background-color: #191919;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .pb:hover{
            background-color: #2C3639;
        }
        .dpb{
            padding: 5px;
            margin: 0px 15px;
            font-size: 1.2rem;
            background-color: #191919;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #8c8c8c;
        }
        .bpb{
            padding: 5px;
            margin: 0px 15px;
            font-size: 1.2rem;
            background-color: #E04D01;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .fen{
            width: 100%;
            border-top: 0.2px solid #2C3639;
            height: 50px;
        }
        .bpb:hover{
            background-color: orangered;
        }
        .nbr{
            height: 50px;
            float: right;
            font-size: 1.1rem;
            color: white;
            display: flex;
            align-items: center;
            margin-right: 5px;
            width: 40px;
            justify-content: center;
            margin-right: 5px;
        }
        .name{
            height: 50px;
            float: right;
            font-size: 1.1rem;
            color: white;
            display: flex;
            align-items: center;
            margin-right: 10px;
        }
        .prpt{
            float: right;
            height: 50px;
            border-radius: 5px;
            border-right: 0.5px solid #1d2b3a;
            border-bottom: 0.5px solid #1d2b3a;
            visibility: hidden;
        }
        .prpt > img{
            border-radius: 5px;
            width: 25px;
            padding: 12.5px;
            cursor: pointer;
        }
        .prpt > img:hover{
            background-color: #2C3639;
        }
        .fen:hover .prpt{
            visibility: visible;
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
            grid-template-columns: repeat(8,1fr);
            grid-template-rows: repeat(11,60px);
            gap: 10px 0px;
            z-index: 10;
            border-radius: 5px;
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
            margin: 8px 10% 8px 0%;
            width: 80%;
            -moz-appearance: textfield;
        }
        .spn{
            position: absolute;
            padding: 10px;
            pointer-events: none;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.25);
            text-transform: uppercase;
            transition: 0.25s;
            margin: 8px 10% 8px 0%;
            right: 0px;
        }
        .in:focus{
            border: 1px solid #00dfc4;
        }
        .in:focus ~ .spn,.in:not(:placeholder-shown) ~ .spn{
            transform: translateX(-12px) translateY(-4px);
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
            grid-column: 4/6;
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
            margin: 3px;
        }
        .ch{
            margin: 3px;
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
        #msg{
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
            min-width: 288px;
        }
        #msg > p{
            padding: 20px;
        }
        #msg1{
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
            min-width: 381px;
        }
        #msg1 > p{
            padding: 20px;
        }
        .cnslbtn{
            float: right;
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
        #msg2{
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
            min-width: 425px;
        }
        .d{
            display: block;
        }
        .nbr{
            height: 50px;
            float: right;
            font-size: 1.1rem;
            color: white;
            display: flex;
            align-items: center;
            margin-right: 5px;
            width: 140px;
            justify-content: center;
            margin-left: 5px;
        }
        .time{
            height: 50px;
            float: right;
            font-size: 1.1rem;
            color: white;
            display: flex;
            align-items: center;
            margin-right: 5px;
            margin-left: 10px;
            padding-left: 10px;
            justify-content: center;
        }
        #dadd{
            position: relative;
            margin-right: 10px;
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
            right: 0;
        }
        .n1in:focus ~ .spn1,.n1in:not(:placeholder-shown) ~ .spn1{
            transform: translateX(-5px) translateY(-4px);
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
            left: 0;
            bottom: 0;
        }
        .aclear:hover{
            background-color: #87805E;
        }
        @media screen and (max-width:860px) {
            .content{
                grid-template-rows: repeat(10,60px);
            }
            .edit1{
                display: none;
            }
            .imgcon{
                grid-column: 1/5;
            }
            .gr1{
                grid-column: 5/10;
            }
            .gr2{
                grid-column: 5/10;
                grid-row: 3;
            }
            .gr16{
                grid-column: 5/10;
                grid-row: 4;
            }
            .gr3{
                grid-column: 1/6;
                grid-row: 5;
            }
            .gr4{
                grid-column: 6/10;
                grid-row: 5;
            }
            .gr5{
                grid-column: 1/6;
                grid-row: 6;
            }
            .gr6{
                grid-column: 6/10;
                grid-row: 6;
            }
            .gr8{
                grid-column: 2/3;
                grid-row: 7;
            }
            .gr9{
                grid-column: 4/5;
                grid-row: 7;
            }
            .gr10{
                grid-column: 6/7;
                grid-row: 7;
            }
            .gr11{
                grid-column: 8/9;
                grid-row: 7;
            }
            .gr12{
                grid-column: 3/4;
                grid-row: 8;
            }
            .gr13{
                grid-column: 5/6;
                grid-row: 8;
            }
            .gr14{
                grid-column: 7/8;
                grid-row: 8;
            }
            .gr15{
                grid-column: 1/6;
                grid-row: 9;
            }
            .gr17{
                grid-column: 6/10;
                grid-row: 9;
            }
            .gr18{
                grid-column: 6/10;
                grid-row: 10;
            }
            .gr19{
                grid-column: 1/5;
                grid-row: 10;
            }
        }
        @media screen and (max-width:600px) {
            .content{
                grid-template-rows: repeat(18,60px);
            }
            .edit1{
                display: none;
            }
            .imgcon{
                grid-column: 1/10;
            }
            .gr1{
                grid-column: 1/10;
                grid-row: 5;
            }
            .gr2{
                grid-column: 1/10;
                grid-row: 6;
            }
            .gr16{
                grid-column: 1/10;
                grid-row: 7;
            }
            .gr3{
                grid-column: 1/10;
                grid-row: 8;
            }
            .gr4{
                grid-column: 1/10;
                grid-row: 9;
            }
            .gr5{
                grid-column: 1/10;
                grid-row: 10;
            }
            .gr6{
                grid-column: 1/10;
                grid-row: 11;
            }
            .gr8{
                grid-column: 2/5;
                grid-row: 12;
            }
            .gr9{
                grid-column: 6/9;
                grid-row: 12;
            }
            .gr10{
                grid-column: 1/4;
                grid-row: 13;
            }
            .gr11{
                grid-column: 4/7;
                grid-row: 13;
            }
            .gr12{
                grid-column: 7/10;
                grid-row: 13;
            }
            .gr13{
                grid-column: 2/5;
                grid-row: 14;
            }
            .gr14{
                grid-column: 6/9;
                grid-row: 14;
            }
            .gr15{
                grid-column: 1/10;
                grid-row: 15;
            }
            .gr17{
                grid-column: 1/10;
                grid-row: 16;
            }
            .gr18{
                grid-column: 1/10;
                grid-row: 17;
            }
            .gr19{
                grid-column: 1/10;
                grid-row: 18;
            }
        }
        @media screen and (max-width:500px) {
            .clear{
                position: relative;
                float: left;
                font-size: 1rem;
            }
            .add{
                position: relative;
                font-size: 1rem;
            }
            .sp{
                font-size: 1rem;
            }
            #in{
                font-size: 1rem;
            }
            .nsp{
                font-size: 1rem;
            }
            #bin{
                font-size: 1rem;
            }
            .pb{
                font-size: 1rem;
            }
            .bpb{
                font-size: 1rem;
            }
            .dpb{
                font-size: 1rem;
            }
            .delbtn{
                width: 50px;
                font-size: 1rem;
            }
            .edit-btn{
                width: 50px;
                font-size: 1rem;
            }
            #msg{
                left: 0;
                transform: translate(0,-50%);
                width: 100%;
                min-width: 0;
            }
            #msg1{
                left: 0;
                transform: translate(0,-50%);
                width: 100%;
                min-width: 0;
            }
            #msg2{
                left: 0;
                transform: translate(0,-50%);
                min-width: 0;
            }
        }
        @media screen and (max-width:383px) {
            .delbtn{
                width: 40px;
                margin: 8px 0px;
            }
            .edit-btn{
                width: 40px;
                margin: 8px 0px;
            }
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
        @media screen and (max-width:580px) {
            #fadd{
                grid-template-rows: repeat(20,60px);
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
    </style>
    <title>عيادتي</title>
</head>
<body class="bod" dir="rtl">
    <section>
        <div class="content">
            <h1>عيادتي</h1>
            <a class="edit-btn">تعديل</a>
            <a class="delbtn">حذف</a>
            <?php
            $show = $db->prepare("SELECT * FROM clinic WHERE id = :p_id");
            $show->bindParam('p_id',$p_id);
            $show->execute();

            foreach ($show as $result) {
                $imgshow = 'data:'.$result['type'].';base64,'.base64_encode($result['img']);
                if ($result['type']) {
                    echo'<div class="imgcon"><img src="'.$imgshow.'" alt="" class="myimg" data-src="'.$imgshow.'"></div>';
                }else{
                    echo'<div class="imgcon"><img src="img/icons8-no-camera-100.png" alt="" class="noimg"></div>';
                }
                echo'<div class="gr1"><span class="sp">الإسم: </span><input type="text" name="" id="in" value="'.$result['f_name'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr2"><span class="sp">اللقب: </span><input type="text" name="" id="in" value="'.$result['l_name'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr3"><span class="sp">بداية العمل: </span><input type="text" name="" id="in" value="'.$result['sw'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr4"><span class="sp">نهاية العمل: </span><input type="text" name="" id="in" value="'.$result['bs'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr5"><span class="sp">بداية الإستراحة: </span><input type="text" name="" id="in" value="'.$result['ew'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr6"><span class="sp">نهاية الإستراحة: </span><input type="text" name="" id="in" value="'.$result['be'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>';
                if ($result['su']) {
                    echo'<div class="gr8"><span class="sp">الأحد</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }else{
                    echo'<div class="gr8"><span class="nsp">الأحد</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }
                if ($result['mo']) {
                    echo'<div class="gr9"><span class="sp">الاثنين</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }else{
                    echo'<div class="gr9"><span class="nsp">الاثنين</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }
                if ($result['tu']) {
                    echo'<div class="gr10"><span class="sp">الثلاثاء</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }else{
                    echo'<div class="gr10"><span class="nsp">الثلاثاء</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }
                if ($result['we']) {
                    echo'<div class="gr11"><span class="sp">الأربعاء</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }else{
                    echo'<div class="gr11"><span class="nsp">الأربعاء</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }
                if ($result['th']) {
                    echo'<div class="gr12"><span class="sp">الخميس</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }else{
                    echo'<div class="gr12"><span class="nsp">الخميس</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }
                if ($result['fr']) {
                    echo'<div class="gr13"><span class="sp">الجمعة</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }else{
                    echo'<div class="gr13"><span class="nsp">الجمعة</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }
                if ($result['sa']) {
                    echo'<div class="gr14"><span class="sp">السبت</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }else{
                    echo'<div class="gr14"><span class="nsp">السبت</span><img src="img/icons8-edit-50.png" alt="" class="edit1"></div>';
                }
                echo'<div class="gr15"><span class="sp">العنوان: </span><input type="text" name="" id="bin" value="'.$result['adress'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr16"><span class="sp">المهنة: </span><input type="text" name="" id="bin" value="'.$result['job'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr17"><span class="sp">رقم الهاتف: </span><input type="text" name="" id="in" value="'.$result['fone'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr18"><span class="sp">الوقت لكل عميل: </span><input type="text" name="" id="in" value="'.$result['tpc'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                <div class="gr19"><span class="sp">السعر: </span><input type="text" name="" id="in" value="'.$result['prix'].'" disabled><img src="img/icons8-edit-50.png" alt="" class="edit"></div>
                
                <div class="mfadd">
                    <form action="" method="post" id="fadd" enctype="multipart/form-data">
                        <h1 class="h">تعديل العيادة</h1>
                        <input type="file" id="file" name="img" class="img" accept="image/*,video/*">
                        <label for="file" class="l"><img src="img/icons8-add-image-64.png" alt="" width="30px">
                        <p>اختيار صورة</p></label><br>
                        <div id="cadd" class="in-1">
                            <input type="text" name="fname" class="in" required placeholder="" value="'.$result['f_name'].'">
                            <span class="spn">الإسم</span><br>
                        </div>
                        <div id="cadd" class="in0">
                            <input type="text" name="lname" class="in" required placeholder="" value="'.$result['l_name'].'">
                            <span class="spn" id="sp1">اللقب</span><br>
                        </div>
                        <div id="cadd" class="in1">
                            <input type="text" name="adress" class="in" placeholder="" value="'.$result['adress'].'">
                            <span class="spn">العنوان</span><br>
                        </div>
                        <div id="cadd" class="in1-5">
                            <input type="text" name="job" class="in" placeholder="" value="'.$result['job'].'">
                            <span class="spn">المهنة</span><br>
                        </div>
                        <div id="cadd" class="in2">
                            <input type="number" name="f_num" class="in" placeholder="" value="'.$result['fone'].'">
                            <span class="spn">رقم الهاتف</span><br>
                        </div>
                        <div id="cadd" class="in4">
                            <input type="time" name="sw" class="in" required placeholder="" value="'.$result['sw'].'">
                            <span class="spn">بداية العمل</span><br>
                        </div>
                        <div id="cadd" class="in5">
                            <input type="time" name="ew" class="in" required placeholder="" value="'.$result['ew'].'">
                            <span class="spn">نهاية العمل</span><br>
                        </div>
                        <div id="cadd" class="in6">
                            <input type="time" name="bs" class="in" placeholder="" value="'.$result['bs'].'">
                            <span class="spn" id="sp1">بداية الإستراحة</span><br>
                        </div>
                        <div id="cadd" class="in7">
                            <input type="time" name="be" class="in" placeholder="" value="'.$result['be'].'">
                            <span class="spn" id="sp1">نهاية الإستراحة</span><br>
                        </div>
                        <span class="in7-5">أيام العمل</span>
                        <div id="cadd" class="in8">
                            <input type="checkbox" name="al" id="r" class="ch0" onchange="sel()" value="al">
                            <label for="r" class="r">الكل</label><br>
                        </div>';
                        if ($result['su']) {
                            echo'<div id="cadd" class="in9">
                                <input type="checkbox" name="su" id="r1" class="ch" onchange="nsel()" value="su" checked>
                                <label for="r1" class="r">الأحد</label><br>
                            </div>';
                        }else{
                            echo'<div id="cadd" class="in9">
                                <input type="checkbox" name="su" id="r1" class="ch" onchange="nsel()" value="su">
                                <label for="r1" class="r">الأحد</label><br>
                            </div>';
                        }
                        if ($result['mo']) {
                            echo'<div id="cadd" class="in10">
                                <input type="checkbox" name="mo" id="r2" class="ch" onchange="nsel()" value="mo" checked>
                                <label for="r2" class="r">الاثنين</label><br>
                            </div>';
                        }else{
                            echo'<div id="cadd" class="in10">
                                <input type="checkbox" name="mo" id="r2" class="ch" onchange="nsel()" value="mo">
                                <label for="r2" class="r">الاثنين</label><br>
                            </div>';
                        }
                        if ($result['tu']) {
                            echo'<div id="cadd" class="in11">
                                <input type="checkbox" name="tu" id="r3" class="ch" onchange="nsel()" value="tu" checked>
                                <label for="r3" class="r">الثلاثاء</label><br>
                            </div>';
                        }else{
                            echo'<div id="cadd" class="in11">
                                <input type="checkbox" name="tu" id="r3" class="ch" onchange="nsel()" value="tu">
                                <label for="r3" class="r">الثلاثاء</label><br>
                            </div>';
                        }
                        if ($result['we']) {
                            echo'<div id="cadd" class="in12">
                                <input type="checkbox" name="we" id="r4" class="ch" onchange="nsel()" value="we" checked>
                                <label for="r4" class="r">الأربعاء</label><br>
                            </div>';
                        }else{
                            echo'<div id="cadd" class="in12">
                                <input type="checkbox" name="we" id="r4" class="ch" onchange="nsel()" value="we">
                                <label for="r4" class="r">الأربعاء</label><br>
                            </div>';
                        }
                        if ($result['th']) {
                            echo'<div id="cadd" class="in13">
                                <input type="checkbox" name="th" id="r5" class="ch" onchange="nsel()" value="th" checked>
                                <label for="r5" class="r">الخميس</label><br>
                            </div>';
                        }else{
                            echo'<div id="cadd" class="in13">
                                <input type="checkbox" name="th" id="r5" class="ch" onchange="nsel()" value="th">
                                <label for="r5" class="r">الخميس</label><br>
                            </div>';
                        }
                        if ($result['fr']) {
                            echo'<div id="cadd" class="in14">
                                <input type="checkbox" name="fr" id="r6" class="ch" onchange="nsel()" value="fr" checked>
                                <label for="r6" class="r">الجمعة</label><br>
                            </div>';
                        }else{
                            echo'<div id="cadd" class="in14">
                                <input type="checkbox" name="fr" id="r6" class="ch" onchange="nsel()" value="fr">
                                <label for="r6" class="r">الجمعة</label><br>
                            </div>';
                        }
                        if ($result['sa']) {
                            echo'<div id="cadd" class="in15">
                                <input type="checkbox" name="sa" id="r7" class="ch" onchange="nsel()" value="sa" checked>
                                <label for="r7" class="r">السبت</label><br>
                            </div>';
                        }else{
                            echo'<div id="cadd" class="in15">
                                <input type="checkbox" name="sa" id="r7" class="ch" onchange="nsel()" value="sa">
                                <label for="r7" class="r">السبت</label><br>
                            </div>';
                        }
                        echo'<div id="cadd" class="in16">
                            <input type="number" name="ctime" class="in" required placeholder="" value="'.$result['tpc'].'">
                            <span class="spn">الوقت لكل عميل</span><br>
                        </div>
                        <div id="cadd" class="in17">
                            <input type="number" name="prix" class="in" placeholder="" value="'.$result['prix'].'">
                            <span class="spn">السعر</span><br>
                        </div>
                        <button name="editbtn" class="btn">تعديل</button>
                        <a class="an">إلغاء</a>
                    </form>
                </div>
                ';
            }
            
            ?>
        </div>
        <div class="chaine">
            <h1 class="hch">المرضى</h1>
            <?php
            $chec = $db->prepare("SELECT stat FROM post_status WHERE user_id = :id AND poste_id = :p_id");
            $chec->bindParam('id',$id);
            $chec->bindParam('p_id',$p_id);
            $chec->execute();
            echo'<form action="" method="post" style="position: relative;">
            <button type="button" class="add">إضافة</button>
            <button type="button" class="clear">مسح</button>';
            if ($chec->rowCount()>0) {
                $sel = $db->prepare("SELECT stat FROM post_status WHERE user_id = :id AND poste_id = :p_id");
                $sel->bindParam('id',$id);
                $sel->bindParam('p_id',$p_id);
                $sel->execute();
                $stat = $sel->fetchObject();
                if ($stat->stat == 0) {
                    echo'<div class="prbtn"><button type="submit" id="op" name="op" class="pb">مفتوح</button>
                    <button type="submit" id="ps" name="ps" class="pb">إستراحة</button>
                    <button type="submit" id="cl" name="cl" class="bpb">مغلق</button></div>
                </form>';
                }
                if ($stat->stat == 1) {
                    echo'<div class="prbtn"><button type="submit" id="op" name="op" class="bpb">مفتوح</button>
                    <button type="submit" id="ps" name="ps" class="pb">إستراحة</button>
                    <button type="submit" id="cl" name="cl" class="pb">مغلق</button></div>
                </form>';
                }
                if ($stat->stat == 2) {
                    echo'<div class="prbtn"><button type="submit" id="op" name="op" class="pb">مفتوح</button>
                    <button type="submit" id="ps" name="ps" class="bpb">إستراحة</button>
                    <button type="submit" id="cl" name="cl" class="pb">مغلق</button></div>
                </form>';
                }
            } else {
                echo'<div class="prbtn"><button type="submit" id="op" name="op" class="pb">مفتوح</button>
                <button type="submit" id="ps" name="ps" class="dpb" disabled>إستراحة</button>
                <button type="submit" id="cl" name="cl" class="dpb" disabled>مغلق</button></div>
            </form>';
            }
            $chose = $db->prepare("SELECT * FROM chane WHERE post_id = :p_id");
            $chose->bindParam('p_id',$p_id);
            $chose->execute();
            
            $i = 1;
            foreach ($chose as $result) {
                echo'<div class="fen">
                    <div class="nbr">المريض رقم: '.$i.'</div>
                    <div class="name">'.$result["l_name"].' '.$result["f_name"].'</div>
                    <!--  <div class="prpt"><img src="img/icons8-edit-50.png" alt=""><img src="img/delete.png" alt=""></div> -->
                    </div>';
                $i = $i + 1;
            }
            $show = $db->prepare("SELECT * FROM clinic WHERE id = :p_id");
            $show->bindParam('p_id',$p_id);
            $show->execute();

            foreach ($show as $result) {
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
                echo'<div id="msg2">
                <form action="" method="post">
                    <div class="nbr">المريض رقم: '.$i.'</div>';
                    if ($i <= count($time)) {
                        echo'<div class="time">الوقت المتوقع للوصول: '.$time[$i - 1].'</div>';
                    } else {
                        echo"<div class='time'>نفدت الأماكن</div>";
                    }
                    echo'<div id="dadd">
                        <input type="text" name="fname" class="n1in" required placeholder="">
                        <span class="spn1">الإسم</span><br>
                    </div>
                    <div id="dadd">
                        <input type="text" name="lname" class="n1in" required placeholder="">
                        <span class="spn1">اللقب</span><br>
                    </div>
                    <button type="submit" name="add" class="aclear">إضافة</button>
                    <a class="cnslbtn">إلغاء</a>
                    </form>
                </div>';
            }
            ?>
        <div id="msg">
            <p>هل أنت متأكد أنك تريد المسح؟</p>
            <a class="cnslbtn">إلغاء</a>
            <form action="" method="post">
                <button type="submit" name="clr" class="clear">مسح</button>
            </form>
        </div>
        <div id="msg1">
            <p>هل أنت متأكد أنك تريد حذف عيادتك؟</p>
            <a class="cnslbtn">إلغاء</a>
            <form action="" method="post">
                <button type="submit" name="del" class="clear">حذف</button>
            </form>
        </div>
    </section>
</body>
<?php
echo'<script>
const lnga = document.getElementById("alnga").href="show more ar.php?id='.$p_id.'";
const lng = document.getElementById("alng").href="show more.php?id='.$p_id.'";
const lngf = document.getElementById("alngf").href="show more fr.php?id='.$p_id.'";
</script>';
?>
<script>
    const preview = ()=>{
    const inp = document.querySelectorAll('#in');
    const edit = document.querySelectorAll('.edit');
    const edited = document.querySelectorAll('.edit1');
    edit.forEach((img,index)=>{               
        img.addEventListener('click',()=>{
            document.getElementById('m-over').style.display="block";
            document.getElementById('fadd').style.display="grid";
            window.scrollTo(0,0);
        })
    })
    edited.forEach((img,index)=>{               
        img.addEventListener('click',()=>{
            document.getElementById('m-over').style.display="block";
            document.getElementById('fadd').style.display="grid";
            window.scrollTo(0,0);
        })
    })
    }
    preview();
    $(document).ready(function(){
        $(document).on('click','.edit-btn',function(){
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
            document.getElementById('msg').style.display="none";
            document.getElementById('msg1').style.display="none";
            document.getElementById('msg2').style.display="none";
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
    $(document).ready(function(){
        $(document).on('click','.clear',function(){
            document.getElementById('m-over').style.display="block";
            document.getElementById('msg').style.display="block";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.cnslbtn',function(){
            document.getElementById('m-over').style.display="none";
            document.getElementById('msg').style.display="none";
            document.getElementById('msg1').style.display="none";
            document.getElementById('msg2').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.delbtn',function(){
            document.getElementById('m-over').style.display="block";
            document.getElementById('msg1').style.display="block";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.add',function(){
            document.getElementById('m-over').style.display="block";
            document.getElementById('msg2').style.display="block";
        });
    });
</script>
</html>    