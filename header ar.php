<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&family=Tajawal:wght@500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        *{
            padding: 0;
            margin: 0;
            font-family: 'Roboto', 'Tajawal', serif, sans-serif;
        }
        header{
            height: 50px;
            background-color: #191919;
        }
        .menu{
            position: relative;
        }
        #m-over{
            position: absolute;
            top: 0;
            left: 0;
            z-index: 9;
            background-color: #191919;
            height: 100vh;
            width: 100vw;
            display: none;
            opacity: 80%;
            position: fixed;
        }
        #c-menu{
            width: 0vw;
            overflow: hidden;
            height: 100vh;
            min-height: 635px;
            background-color: #191919;
            z-index: 10;
            position: absolute;
            top: 0;
            right: 0;
            transition: 0.25s;
        }
        .m-close{
            color: white;
            font-size: 2.5rem;
            position: absolute;
            margin-right: 220px;
            padding: 0px 13px;
            margin-top: 4px;
            cursor: pointer;
        }
        .m-close:hover{
            background-color: #F5EDDC;
            border-radius: 25px;
            color: #191919;
        }
        #login{
            font-size: 1.5rem;
            padding: 10px 15% 15px 15%;
            border-bottom: 2px solid #2ecc71;
            text-decoration: none;
            color: white;
            cursor: pointer;
            width: 100%;
            display: block;
            background-color: #191919;
        }
        #login:hover{
            background-color: #F5EDDC;
            color: #191919;
        }
        #login:hover .m-close{
            color: #191919;
        }
        #pr-menu{
            color: white;
            width: 100%;
            font-size: 1.3rem;
            background-color: #191919;
            display: block;
            padding: 8px 15px;
            border-bottom: 0.5px solid #2ecc71;
            opacity: 60%;
        }
        .el{
            width: 100%;
            display: block;
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 15px 3px;
            background-color: #191919;
            border: none;
            text-align: right;
            cursor: pointer;
        }
        .el:hover{
            background-color: #F5EDDC;
            color: #191919;
        }
        .pr{
            position: absolute;
            top: 0px;
        }
        .n > img{
            width: 25px;
            padding: 12.5px;
            cursor: pointer;
            background-color: #191919;
        }
        .n > img:hover{
            background-color: #2C3639;
        }
        .search{
            display: flex;
            float: left;
            background-color: #2C3639;
            height: 35px;
            border-radius: 60px;
            padding: 0px 8px;
            width: 25vw;
            margin: 7.5px;
            overflow: hidden;
            position: absolute;
            left: 0;
            min-width: 180px;
            z-index: 6;
        }
        .lp{
            width: 25px;
            float: right;
            position: relative;
            margin: 5px 0px;
            cursor: pointer;
        }
        #search{
            height: 100%;
            width: 100%;
            border: none;
            font-size: 1rem;
            outline: none;
            padding: 5px;
            background-color: #2C3639;
            color: white;
        }
        #sr-close{
            float: left;
            font-size: 28px;
            margin: 1.5px 0px;
            cursor: pointer;
            opacity: 50%;
            display: none;
            color: white;
            align-items: end;
        }
        .list{
            width: calc(25vw + 16px);
            float: right;
            background-color: #2C3639;
            border-radius: 0 0 5px 5px;
            top: 17px;
            position: relative;
            margin: 7.5px;
            min-width: 196px;
            position: absolute;
            left: 0;
            z-index: 5;
            box-shadow: -2px 2px 5px rgba(0, 0, 0, 0.5),2px 0px 5px rgba(0, 0, 0, 0.5);
        }
        .list-items{
            padding: 10px 5px;
            color: white;
            text-decoration: none;
            list-style-type: none;
        }
        .list-items:first-child{
            margin-top: 25px;
        }
        .list-items:last-child{
            border-radius: 0 0 5px 5px;
        }
        .list-items:hover{
            background-color: #191919;
        }
        @media screen and (max-width:360px) {
            .bok{
                display: none;
            }
        }
    </style>
    <title>Document</title>
</head>
<body dir="rtl">
    <header>
        <div class="menu">
            <div id="m-over"></div>
            <div id="c-menu">
                <span class="m-close">&times;</span>
                <?php
                    if (isset($_POST['exit'])) {
                        session_unset();
                        session_destroy();
                        header("location:http://localhost/dr/login ar.php");
                    }
                    if(isset($_SESSION['user'])){
                        echo '<div id="p-menu"><a href="account ar.php" id="login">'.$_SESSION['user']->f_name.'</a></div>';                
                    }else{
                        echo '<a href="login ar.php" id="login">تسجيل الدخول</a>';
                    }
                ?> 
                <a href="index ar.php" class="el">الصفحة الرئيسية</a>
                <a href="favorit ar.php" class="el">أطبائي</a>
                <a href="add ar.php" class="el">إضافة عيادة</a>
                <span id="pr-menu">اللغة</span>
                <a href="index ar.php" class="el" id="alnga">العربية</a>
                <a href="index.php" class="el" id="alng">English</a>
                <a href="index fr.php" class="el" id="alngf">Frencais</a>   
                <span id="pr-menu">خصائص</span>
                <a href="account ar.php" class="el">تعديل الحساب</a>
                <form action="" method="post"><input type="submit" value="تسجيل الخروج" name="exit" class="el"></form>
                <a href="icons ar.php" class="el">أيقوناتنا</a>
            </div>
            <div class="pr">
                <a class="n"><img src="img/menu.png" alt="" class="s-menu"></a>
                <a href="index ar.php" class="n"><img src="img/home page.png" alt="" class="bok"></a>
                <a href="favorit ar.php" class="n"><img src="img/icons8-bookmark-30.png" alt="" class="bok"></a>
            </div>
            <div class="search">
                <label for="search"><img src="img/loupe.png" alt="" class="lp"></label>
                <input type="search" placeholder="بحث" name="search" id="search" oninput="document.getElementById('sr-close').style.display='flex'">
                <span id="sr-close" onclick="sr()">&times;</span>
            </div>
            <ul class="list"></ul>
        </div>
    </header>
</body>
<script>
    <?php
    require_once 'cdb.php';
    $chose = $db->prepare("SELECT * FROM clinic");
    $chose->execute();
    echo'let names = [';
    foreach ($chose as $result) {
        echo'"'.$result['l_name'].' '.$result['f_name'].'",';
    }
    echo'];';
    ?>
    let sortednames = names.sort();
    let input = document.getElementById('search');
    input.addEventListener("keyup", (e) => {
        removeElements();
        for (let i of sortednames) {
            if (i.toLowerCase().startsWith(input.value.toLowerCase()) && input.value != "") {
                let listitem = document.createElement("li");
                listitem.classList.add("list-items");
                listitem.style.cursor = "pointer";
                listitem.setAttribute("onclick", "displayNames('" + i + "')");
                let word = "<b>" + i.substr(0,input.value.length) + "</b>";
                word += i.substr(input.value.length);
                listitem.innerHTML = word;
                document.querySelector(".list").appendChild(listitem);
            }
        }
    });
    function displayNames(value) {
        window.location = 'index ar.php?sr='+value;
        input.value = value;
        removeElements();
    }
    function removeElements() {
        let items = document.querySelectorAll(".list-items");
        items.forEach(item => {
            item.remove();
        });
    }
    $(document).ready(function(){
        $(document).on('click','.s-menu',function(){
            document.getElementById('c-menu').style.width="270px";
            document.getElementById('m-over').style.display="block";
        });
    });
    $(document).ready(function(){
        $(document).on('click','.m-close',function(){
            document.getElementById('c-menu').style.width="0px";
            document.getElementById('m-over').style.display="none";
        });
    });
    $(document).ready(function(){
        $(document).on('click','#m-over',function(){
            document.getElementById('c-menu').style.width="0px";
            document.getElementById('m-over').style.display="none";
        });
    });
    function sr() {
        document.getElementById('search').value = '';
        document.getElementById('sr-close').style.display='none'
        removeElements();
    }
</script>
</html>