<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location:index.php');
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
         <h5 class="center">ورود به برنامه</h5>
        <form class="col s10 authfield" action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
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
            <input type="submit" name="submit" class="btn green"value="ورود">
            <a href="signup.php" class="btn blue marginr1">ثبت نام</a>
        </form>
     </div>
 </div>
 <!--JavaScript at end of body for optimized loading-->
 <script type="text/javascript" src="js/materialize.min.js"></script>
 </body>
 </html>
