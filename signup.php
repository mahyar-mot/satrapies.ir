<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location:index.php');
    exit;
}
$username = $email = $password = $passwordrepeat = $error = $success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    foreach ($_POST as $key => $value) {
        $value = ($key === 'password') ? $value : checkInput($value)  ;
        $$key = $value;
    }
    if (empty($username) || empty($email) || empty($password) || empty($passwordrepeat)) {
        $error = "تمامی فیلدها اجباری است";
    }else{
        if (strlen($username)<3) {
            $error ="نام کاربری حداقل شامل ۳ کارکتر باید باشد";
        }
        }if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "<br> ایمیل وارد شده صحیح نیست";
        }
        if ($password === $passwordrepeat) {
            if (strlen($password)<6) {
                $error .= "<br>رمز عبور حداقل باید شامل ۶ کارکتر باشد";
            }else {
                $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            }
        }else{
            $error .= "<br> رمز عبورها یکسان نیست";
    }
    if ($error === '') {
        require 'DbConnection.php';
        $record = new DbConnection();
        $newuser = $record->insertRecord("INSERT INTO users (username, email, password) VALUES (?, ?, ?)", [$username, $email, $hashedpassword]);
        if ($newuser == 0) {
            $error .= "این ایمیل قبلا ثبت شده است";
        }else {
            $success = "ثبت نام با موفقیت انجام شد";
            echo "<script>setTimeout(function(){window.location.replace('login.php')},3000);</script>";
        }
    }
}

// FUNCTIONS

function checkInput($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
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
     <title>سیستم فایل املاک</title>
 </head>

 <body class="amber lighten-5">
 <div class="detail">
     <nav>
         <div class="nav-wrapper amber darken-4">
             <a href="index.php" class="brand-logo left">سیستم فایل املاک</a>

         </div>
     </nav>
     <div class="container">
         <h5 class="center">لطفا مشخصات  زیر را برای ثبت نام وارد کنید</h5>
         <br>
         <div class="center red-text"><?= $error;?></div>
         <div class="center green-text"><?= $success;?></div>
        <form class="col s10 authfield" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <div class="input-field">
                <input id="username" type="text" name="username" class="validate" value="">
                <label for="username">نام کاربری:</label>
                <span class="helper-text right" data-error="نادرست" data-success="درست"></span>
            </div>
            <br>
            <div class="input-field">
                <input id="email" type="email" name="email" class="validate" value="">
                <label for="email">ایمیل:</label>
                <span class="helper-text right" data-error="نادرست" data-success="درست"></span>
            </div>
            <br>
            <div class="input-field">
                <input id="password" type="password" name="password" class="validate" value="">
                <label for="password">رمز عبور:</label>
                <span class="helper-text right" data-error="نادرست" data-success="درست"></span>
            </div>
            <br>
            <div class="input-field">
                <input id="passwordrepeat" type="password" name="passwordrepeat" class="validate" value="">
                <label for="passwordrepeat">تکرار رمز عبور:</label>
                <span class="helper-text right" data-error="نادرست" data-success="درست"></span>
            </div>
            <br>
            <input type="submit" name="signup" class="btn green"value="ثبت نام">
            <input type="reset" name="reset" class="btn red marginr1"value="پاک کردن ">
        </form>
     </div>
 </div>
 <!--JavaScript at end of body for optimized loading-->
 <script type="text/javascript" src="js/materialize.min.js"></script>
 </body>
 </html>
