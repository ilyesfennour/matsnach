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
        .bd{
            background-color: #2C3639;
        }
        .content{
            display: grid;
            grid-template-columns: repeat(9,11%);
            grid-template-rows: repeat(7,60px);
            margin: 7px;
            background-color: #191919;
            padding: 4px;
            gap: 20px 0px;
            border-radius: 7px;
            justify-content: center;
        }
        h1{
            color: white;
            padding: 5px;
            text-align: center;
            grid-column: 1/10;
            grid-row: 1;
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
            transform: translateX(15vw)
        }
        .gr1{
            grid-column: 4/7;
            grid-row: 2;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr2{
            grid-column: 7/10;
            grid-row: 2;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr3{
            grid-column: 4/7;
            grid-row: 3;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr4{
            grid-column: 7/10;
            grid-row: 3;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr5{
            grid-column: 4/7;
            grid-row: 4;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr6{
            grid-column: 7/10;
            grid-row: 4;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr7{
            grid-column: 1/2;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr8{
            grid-column: 2/3;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr9{
            grid-column: 3/4;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr10{
            grid-column: 4/5;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr11{
            grid-column: 5/6;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr12{
            grid-column: 6/7;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr13{
            grid-column: 7/8;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr14{
            grid-column: 8/9;
            grid-row: 5;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr15{
            grid-column: 1/6;
            grid-row: 6;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr16{
            grid-column: 6/10;
            grid-row: 6;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr17{
            grid-column: 1/4;
            grid-row: 7;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr18{
            grid-column: 4/7;
            grid-row: 7;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .gr19{
            grid-column: 7/10;
            grid-row: 7;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        @media screen and (max-width:860px) {
            .content{
                grid-template-rows: repeat(10,60px);
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
                grid-column: 5/10;
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
        @media screen and (max-width:400px) {
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
        }
    </style>
    <title>Document</title>
</head>
<body class="bd" dir="rtl">
    <section>
        <div class="content">
            <h1>العيادة</h1>
            <?php
            $show = $db->prepare("SELECT * FROM clinic WHERE id = :id");
            $show->bindParam('id',$p_id);
            $show->execute();

            foreach ($show as $result) {
                $imgshow = 'data:'.$result['type'].';base64,'.base64_encode($result['img']);
                if ($result['type']) {
                    echo'<div class="imgcon"><img src="'.$imgshow.'" alt="" class="myimg" data-src="'.$imgshow.'"></div>';
                }else{
                    echo'<div class="imgcon"><img src="img/icons8-no-camera-100.png" alt="" class="noimg"></div>';
                }
                echo'<div class="gr1"><span class="sp">الاسم: </span><input type="text" name="" id="in" value="'.$result['f_name'].'" disabled></div>
                <div class="gr2"><span class="sp">اللقب: </span><input type="text" name="" id="in" value="'.$result['l_name'].'" disabled></div>
                <div class="gr3"><span class="sp">بداية العمل: </span><input type="text" name="" id="in" value="'.$result['sw'].'" disabled></div>
                <div class="gr4"><span class="sp">نهاية العمل: </span><input type="text" name="" id="in" value="'.$result['bs'].'" disabled></div>
                <div class="gr5"><span class="sp">بداية الإستراحة: </span><input type="text" name="" id="in" value="'.$result['ew'].'" disabled></div>
                <div class="gr6"><span class="sp">نهاية الإستراحة: </span><input type="text" name="" id="in" value="'.$result['be'].'" disabled></div>';
                if ($result['su']) {
                    echo'<div class="gr8"><span class="sp">الأحد</span></div>';
                }else{
                    echo'<div class="gr8"><span class="nsp">الأحد</span></div>';
                }
                if ($result['mo']) {
                    echo'<div class="gr9"><span class="sp">الاثنين</span></div>';
                }else{
                    echo'<div class="gr9"><span class="nsp">الاثنين</span></div>';
                }
                if ($result['tu']) {
                    echo'<div class="gr10"><span class="sp">الثلاثاء</span></div>';
                }else{
                    echo'<div class="gr10"><span class="nsp">الثلاثاء</span></div>';
                }
                if ($result['we']) {
                    echo'<div class="gr11"><span class="sp">الأربعاء</span></div>';
                }else{
                    echo'<div class="gr11"><span class="nsp">الأربعاء</span></div>';
                }
                if ($result['th']) {
                    echo'<div class="gr12"><span class="sp">الخميس</span></div>';
                }else{
                    echo'<div class="gr12"><span class="nsp">الخميس</span></div>';
                }
                if ($result['fr']) {
                    echo'<div class="gr13"><span class="sp">الجمعة</span></div>';
                }else{
                    echo'<div class="gr13"><span class="nsp">الجمعة</span></div>';
                }
                if ($result['sa']) {
                    echo'<div class="gr14"><span class="sp">السبت</span></div>';
                }else{
                    echo'<div class="gr14"><span class="nsp">السبت</span></div>';
                }
                echo'<div class="gr15"><span class="sp">العنوان: </span><input type="text" name="" id="bin" value="'.$result['adress'].'" disabled>/</div>
                <div class="gr16"><span class="sp">المهنة: </span><input type="text" name="" id="bin" value="'.$result['job'].'" disabled>/</div>
                <div class="gr17"><span class="sp">رقم الهاتف: </span><input type="text" name="" id="in" value="'.$result['fone'].'" disabled>/</div>
                <div class="gr18"><span class="sp">الوقت لكل عميل: </span><input type="text" name="" id="in" value="'.$result['tpc'].'" disabled>/</div>
                <div class="gr19"><span class="sp">السعر: </span><input type="text" name="" id="in" value="'.$result['prix'].'" disabled>/</div>
                ';
            }
            ?>
        </div>
    </section>
</body>
<?php
echo'<script>
const lnga = document.getElementById("alnga").href="show ar.php?id='.$p_id.'";
const lng = document.getElementById("alng").href="show.php?id='.$p_id.'";
const lngf = document.getElementById("alngf").href="show fr.php?id='.$p_id.'";
</script>';
?>
</html>