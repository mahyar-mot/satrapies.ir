<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:login.php');
}
    if (array_key_exists('id',$_GET)){
        require 'DbConnection.php';
        $record = new DbConnection();
        $result = $record->getRecord("SELECT * FROM houses WHERE id=?",[$_GET['id']]);
        $pics = $record->getRecord("SELECT url FROM pics WHERE house_id=?", [$_GET['id']]);
        if(empty($result)){
            header('Location:index.php');
        }
    }elseif($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['delete'])){
        require 'DbConnection.php';
        $rec = new DbConnection();
        $res = $rec->insertRecord("DELETE FROM houses WHERE id=?",[$_POST['id_to_delete']]);
        header('Location:index.php');
    } else{
        header('Location:index.php');
    }
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

<body class="amber lighten-5">
<div class="detail">
    <nav>
        <div class="nav-wrapper amber darken-4">
            <a href="index.php" class="brand-logo left hide-on-med-and-down">سیستم فایل املاک</a>
            <ul class="right hide-on-small-only">
                <li>
                    <form class="no-padding" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <input type="hidden" class="hide" value="<?= $result[0]['id']?>" name="id_to_delete">
                        <input type="submit" name="delete" value="حذف" class="btn btn-small red darken-2">
                    </form>
                </li>
                <li><a href="new.php" class="btn cyan darken-1">ایجاد فایل جدید</a></li>
                <li><a href="edit.php?id=<?= $result[0]['id'] ?>">ویرایش فایل</a></li>
                <li><a href="index.php">صفحه اصلی</a></li>
            </ul>
            <ul class="right hide-on-med-and-up show-on-small no-padding">
                <li>
                    <form class="no-padding" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <input type="hidden" class="hide" value="<?= $result[0]['id']?>" name="id_to_delete">
                        <input type="submit" name="delete" value="حذف" class="btn btn-small red darken-2 no-padding">
                    </form>
                </li>
                <li><a href="new.php" class="btn btn-small cyan darken-1 no-padding">فایل جدید</a></li>
                <li><a href="edit.php?id=<?= $result[0]['id'] ?>" class="no-padding marginr1">ویرایش فایل</a></li>
                <li><a href="index.php" class="no-padding marginr1">صفحه اصلی</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h3 class="right">تصاویر</h3>
        <div class="carousel carousel-slider">
          <?php foreach ($pics as $key => $value): ?>
            <a class="carousel-item" href="#"><img src="<?= $value['url'] ?>"></a>
          <?php endforeach; ?>
          <?php if (empty($pics)): ?>
            <a class="carousel-item" href="#"><img src="images/414289-PFPYAR-176.jpg"></a>
          <?php endif; ?>
        </div>
        <br>
        <br>
        <div class="right-align right-aligned">
            <ul class="collection with-header">
                <li class="collection-header"><h4>مشخصات</h4></li>
                <li class="collection-item"><div>مالک<span class="left"><?= $result[0]['owner'] ?></span></div></li>
                <li class="collection-item"><div>تلفن<span class="left"><?= $result[0]['tel'] ?></span></div></li>
                <li class="collection-item"><div>موبایل<span class="left"><?= $result[0]['mobile'] ?></span></div></li>
                <li class="collection-item"><div>منطقه/محدوده<span class="left"><?= $result[0]['zone'] ?></span></div></li>
                <li class="collection-item"><div>نوع<span class="left"><?php echo ($result[0]['house']=='rent') ? 'اجاره/رهن' : 'فروش'; ?></span></div></li>
                <li class="collection-item"><div>نوع ملک<span class="left"><?php echo ($result[0]['lot']=='apartment') ? 'آپارتمان':(($result[0]['lot']=='condo')? 'خانه':'کلنگی/زمین'); ?></span></div></li>
                <li class="collection-item"><div>سال ساخت<span class="left"><?= $result[0]['creation_year'] ?></span></div></li>
                <li class="collection-item"><div>متراژ<span class="left"><?= $result[0]['meter'] ?></span></div></li>
                <li class="collection-item"><div>واحد/طبقه<span class="left"><?= $result[0]['unit'] ?></span></div></li>
                <li class="collection-item"><div>امکانات<span class="left"><?= changeToPersian($result[0]['options']) ?></span></div><br></li>
                <li class="collection-item"><div>توضیحات<span class="left"><?= $result[0]['description'] ?></span></div></li>
                <li class="collection-item"><div>قیمت/ودیعه<span class="left"><?= $result[0]['price'] ?></span></div></li>
                <li class="collection-item"><div>اجاره ماهیانه<span class="left"><?= $result[0]['monthly_fee'] ?></span></div></li>
                <li class="collection-item"><div> آدرس<span class="left"><?= $result[0]['address'] ?></span></div></li>
            </ul>
        </div>
    </div>
</div>
<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.carousel');
        var instances = M.Carousel.init(elems, {fullWidth:true});
    });</script>
</body>
</html>
