<?php
    require 'DbConnection.php';
    $record = new DbConnection();
    $result = $record ->getRecord('SELECT * FROM houses ORDER BY created_at DESC');

    function changeToPersian($arr){
        $eng = ['luxury','renovate','parking','storage','elevator','aircon','toilet'];
        $per = ['لوکس','بازسازی‌شده','پارکینگ','انباری','آسانسور','کولرگازی','توالت فرنگی'];
        return str_replace($eng,$per,$arr);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="css/style.css">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>سیستم فایل املاک</title>
</head>

<body class="green lighten-5">
<div id="wrapper">
    <nav class="fixed">
        <div class="nav-wrapper green darken-4">
            <a href="index.php" class="brand-logo left">سیستم فایل املاک</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="new.php" class="btn lime darken-1">ایجاد فایل جدید</a></li>
                <li><a href="index.php">صفحه اصلی</a></li>
            </ul>
            <a href="#" data-target="slide-out" class="sidenav-trigger show-on-medium-and-down right"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <form id="formmenu" class="no-padding" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
    <ul id="slide-out" class="sidenav sidenav-fixed green lighten-4">
        <li>
            <div id="logo" class="user-view">
                <div  class="background">
                    <img src="images/logo.png">
                </div>
            </div>
        </li>
            <li class="px"><input name="house" id="house" class="input-field" type="text" placeholder="نوع"></li>
            <li class="px"><a href="#">Second Sidebar Link</a></li>
    </ul>
    </form>
    <div class="row">
        <?php foreach ($result as $key => $item): ?>
        <div class="col s12 m6 l4">
            <div class="card sticky-action hoverable">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="images/preview.png" alt="">
                </div>
                <div class="card-content">

                    <span class="card-title activator grey-text text-darken-4"><?= ($item['house']=='rent') ? 'اجاره/رهن' : 'فروش'; ?><i class="material-icons right">more_vert</i></span>
                    <p> &nbsp; <?= ($item['lot']=='apartment') ? 'آپارتمان':(($item['lot']=='condo')? 'خانه':'کلنگی/زمین'); ?> &nbsp; <span class="chip">محدوده/منطقه: <?= $item['zone'] ?></span></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4 right-align">مشخصات<i class="material-icons right">close</i></span>
                    <br>
                    <p class="right-align"><span class="left"><?= $item['price'] ?></span>:قیمت/ودیعه</p>
                    <br>
                    <p class="right-align"><span class="left"><?= $item['monthly_fee'] ?> </span>:اجاره ماهیانه</p>
                    <br>
                    <p class="right-align"> : امکانات <br><br> <?= changeToPersian($item['options']) ?></p>
                </div>
                <div class="card-action">
                    <a href="detail.php?id=<?= $item['id']?>" class="btn lime darken-1">مشاهده فایل</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, {edge: 'right', draggable: true});
    });
</script>
</body>
</html>
