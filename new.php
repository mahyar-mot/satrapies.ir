<?php
$missing = [];
$error = [];
$name = $tel = $mobile = $zone = $house = $lot = $creation_year = $meter = $unit = $description = $price = $monthly_fee = $address = "";
$options = [];
$empty = '<span class="red-text">نباید خالی باشد</span>';

 if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['submit'])){
     $required =['name', 'tel', 'mobile', 'creation_year', 'meter', 'unit', 'price', 'address'];
     $expected = ['name', 'tel', 'mobile', 'zone', 'house', 'lot', 'creation_year', 'meter', 'unit', 'options', 'description', 'price', 'monthly_fee', 'address'];
     require 'validate.php';
     formValidate($error, $name,'name');
     formValidate($error, $tel,'tel');
     formValidate($error, $mobile,'mobile');
     formValidate($error, $creation_year, 'creation_year');
     formValidate($error, $meter, 'meter');
     formValidate($error, $unit, 'unit');
     formValidate($error, $price, 'price');
     formValidate($error, $monthly_fee, 'monthly_fee');

     if ($house == 'rent' && $monthly_fee == ''){
         $error['monthly_fee'] = '<span class="red-text">لطفا مبلغ اجاره را مشخص کنید</span>';
     }

     foreach ($error as $key => $value){
         if (is_null($value)) unset($error[$key]);
     }

     if (!($error || $missing)){
         $result = ['owner'=>$name, 'tel'=>$tel, 'mobile'=>$mobile, 'zone'=>$zone, 'house'=>$house, 'lot'=>$lot, 'creation_year'=>$creation_year,
             'meter'=>$meter, 'unit'=>$unit, 'options'=>implode(',',$options), 'description'=>$description, 'price'=>$price, 'monthly_fee'=>$monthly_fee, 'address'=>$address];
         require 'DbConnection.php';
         $record = new DbConnection();
         $row = $record->insertRecord("INSERT INTO houses (owner ,tel ,mobile , zone, house, lot, creation_year, meter, unit, options, description, price, monthly_fee, address)
                            VALUES (:owner, :tel, :mobile, :zone, :house, :lot, :creation_year, :meter, :unit, :options, :description, :price, :monthly_fee, :address)", $result);

         if (is_string($row) && ($_FILES['image']['name'] != '')){
             require 'upload.php';
             foreach ($addressList as $url){
                 $record->insertRecord("INSERT INTO pics (url ,house_id) VALUES (?,?)", [$url, $row]);
             }
             header("Location:detail.php?id=$row");
         }
     }

 }



?>
<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->

    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="css/style.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <title>سیستم فایل املاک</title>
</head>

<body class="amber lighten-5">
<div>
    <nav>
        <div class="nav-wrapper amber darken-4">
            <a href="index.php" class="brand-logo left">سیستم فایل املاک</a>
            <ul class="right">
                <li><a href="index.php">صفحه اصلی</a></li>
            </ul>
        </div>
    </nav>
     <div class="container">
         <h4 class="center-align">لطفا مشخصات ملک را وارد کنید</h4>
            <?php
                if ($missing || $error){
                    echo '<script> M.toast({html:"خطا در ثبت لطفا دوباره سعی کنید"})</script>';
                }
            ?>
         <form id="formedit" class="col s12" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
             <div class="input-field col s12">
                 <input id="name" type="text"  name="name" class="validate" value="<?php if ($error || $missing) echo htmlentities($name);?>">
                 <label for="name">نام مالک</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('name', $missing)){echo $empty;}elseif ($error && array_key_exists('name',$error)){ echo $error['name'];} ?></span>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="tel" type="text" name="tel" class="validate" value="<?php if($error||$missing) echo htmlentities($tel);?>" >
                 <label for="tel">تلفن</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('tel', $missing)){ echo $empty;}elseif ($error && array_key_exists('tel',$error)){ echo $error['tel'];} ?></span>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="mobile" type="text" name="mobile" class="validate" value="<?php if ($error||$missing) echo htmlentities($mobile);?>" >
                 <label for="mobile">موبایل</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('mobile', $missing)){ echo $empty;}elseif ($error && array_key_exists('mobile',$error)){ echo $error['mobile'];} ?></span>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="zone" type="text" name="zone" class="validate" value="<?php if ($error||$missing) echo htmlentities($zone);?>" >
                 <label for="zone">منطقه/محدوده</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"></span>
             </div>
             <br>
             <div >
                 <label for="sell">
                     <input class="with-gap" id="sell" name="house" type="radio" value="sell" <?php if (($error||$missing) && $house == 'sell') echo 'checked'?> />
                     <span>فروش</span>
                 </label>
                 <label for="rent" class="marginr1">
                     <input class="with-gap" id="rent" name="house" type="radio" value="rent" <?php if (($error||$missing) && $house == 'rent') echo 'checked'?> />
                     <span>اجاره/رهن</span>
                 </label>
                 <?php if ($_POST && !isset($_POST['house'])&& $house =='') echo '<span class="red-text">یک گزینه را انتخاب کنید</span>'; ?>
             </div>
             <br>
             <div>
                 <label for="apartment">
                     <input class="with-gap" id="apartment" name="lot" type="radio" value="apartment" <?php if (($error||$missing)&& $lot == 'apartment') echo 'checked'?>/>
                     <span>آپارتمان</span>
                 </label>
                 <label for="condo" class="marginr1">
                     <input class="with-gap" id="condo" name="lot" type="radio" value="condo" <?php if (($error||$missing)&& $lot == 'condo') echo 'checked'?>/>
                     <span>خانه</span>
                 </label>
                 <label for="old-house" class="marginr1">
                     <input class="with-gap" id="old-house" name="lot" type="radio" value="old_house" <?php if (($error||$missing)&& $lot =='old_house') echo 'checked'?> />
                     <span>کلنگی/زمین</span>
                 </label>
                 <?php if ($_POST && !isset($_POST['lot']) && $lot=='')echo '<span class="red-text">یک گزینه را انتخاب کنید</span>';?>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="creation-year" type="number" name="creation_year" class="validate" value="<?php if ($error||$missing) echo htmlentities($creation_year); ?>">
                 <label for="creation-year">سال ساخت</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('creation-year', $missing)){ echo $empty ;} elseif ($error && array_key_exists('creation_year',$error)){ echo $error['creation_year'];}?></span>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="meter" type="number" name="meter" class="validate" value="<?php if ($error||$missing) echo htmlentities($meter);?>">
                 <label for="meter">متراژ</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('meter', $missing)){ echo $empty;}elseif ($error && array_key_exists('meter',$error)){ echo $error['meter'];} ?></span>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="unit" type="number" name="unit" class="validate" value="<?php if ($error||$missing) echo htmlentities($unit); ?>">
                 <label for="unit">طبقه/واحد</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('unit', $missing)){ echo $empty;}elseif ($error && array_key_exists('unit',$error)){echo $error['unit'];} ?></span>
             </div>
             <br>
             <br>
             <div>
                 <span>امکانات : </span>
                 <label>
                     <input id="luxury" type="checkbox" name="options[]" value="luxury" <?php if (($missing||$error)&& in_array('luxury',$options)) echo 'checked'; ?> />
                     <span>لوکس</span>
                 </label>
                 <label class="marginr1">
                     <input id="renovate" type="checkbox" name="options[]" value="renovate" <?php if (($missing||$error)&& in_array('renovate', $options)) echo 'checked'; ?>/>
                     <span>بازسازی</span>
                 </label>
                 <label class="marginr1">
                     <input id="parking" type="checkbox" name="options[]" value="parking" <?php if (($error||$missing)&& in_array('parking', $options)) echo 'checked'; ?> />
                     <span>پارکینگ</span>
                 </label>
                 <label class="marginr1">
                     <input id="storage" type="checkbox" name="options[]" value="storage" <?php if (($error||$missing)&& in_array('storage', $options)) echo 'checked'; ?> />
                     <span>انباری</span>
                 </label>
                 <label class="marginr1">
                     <input id="elevator" type="checkbox" name="options[]" value="elevator" <?php if (($error||$missing)&& in_array('elevator', $options)) echo 'checked';?> />
                     <span>آسانسور</span>
                 </label>
                 <label class="marginr1">
                     <input id="aircon" type="checkbox" name="options[]" value="aircon" <?php if (($error||$missing)&& in_array('aircon', $options)) echo 'checked';?> />
                     <span>کولرگازی</span>
                 </label>
                 <label class="marginr1">
                     <input id="toilet" type="checkbox" name="options[]" value="toilet" <?php if (($error||$missing)&& in_array('toilet', $options)) echo 'checked'; ?> />
                     <span>فرنگی</span>
                 </label>
             </div>
             <br>
             <div class="input-field col s12">
                 <textarea id="description" class="materialize-textarea" name="description"><?php if ($missing||$error) echo htmlentities($description); ?></textarea>
                 <label for="description">توضیحات</label>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="price" name="price" type="text" class="validate" value="<?php if ($error||$missing) echo htmlentities($price);?>">
                 <label for="price">قیمت/ودیعه</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('price', $missing)){ echo $empty;}elseif ($error && array_key_exists('price',$error)){echo $error['price'];} ?></span>
             </div>
             <br>
             <div class="input-field col s12">
                 <input id="monthly-fee" name="monthly_fee" type="text" class="validate" value="<?php if ($error||$missing) echo htmlentities($monthly_fee); ?>">
                 <label for="monthly-fee">اجاره ماهیانه</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($error && array_key_exists('monthly_fee',$error)){echo $error['monthly_fee'];} ?></span>
             </div>
             <br>
             <div class="input-field col s12">
                 <textarea id="address" class="materialize-textarea" name="address"><?php if ($error||$missing) echo htmlentities($address); ?></textarea>
                 <label for="address">آدرس</label>
                 <span class="helper-text right" data-error="نادرست" data-success="درست"><?php if ($missing && in_array('address', $missing)) echo $empty ?></span>
             </div>
             <br>
             <div class="file-field input-field">
                 <div class="btn cyan darken-1">
                     <span>عکس</span>
                     <input type="file" name="image">
                 </div>
                 <div class="file-path-wrapper">
                     <input class="file-path validate" type="text" placeholder="Upload a Picture">
                 </div>
             </div>
             <br>
             <div class="input-field">
                <button id="nextpic" class="btn-small cyan">عکس بعدی</button>
             </div>
             <br>
             <div id="submit" class="input-field col s12">
                 <input type="submit" name="submit" value="ثبت" class="btn btn-large green">
             </div>
         </form>
     </div>
</div>
<script>
    var ele = document.querySelector('#nextpic');
    var subbmit = document.querySelector('#submit');
    ele.addEventListener('click',function (e) {
        e.preventDefault();
        var i = document.querySelectorAll('.file-field').length;
        var node = "             <div class=\"file-field input-field\">\n" +
        "                 <div class=\"btn cyan darken-1\">\n" +
        "                     <span>عکس</span>\n" +
        "                     <input type=\"file\" name=\"image"+i+"\">\n" +
        "                 </div>\n" +
        "                 <div class=\"file-path-wrapper\">\n" +
        "                     <input class=\"file-path validate\" type=\"text\" placeholder=\"Upload a Picture\">\n" +
        "                 </div>\n" +
        "             </div>\n"+
        "<br>";
        submit.insertAdjacentHTML('beforebegin',node);
    })
</script>
</body>
</html>
