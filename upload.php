<?php
$target_dir = 'uploads/';
$addressList = [];
foreach ($_FILES as $key=>$value) {
    $target_file = $target_dir . basename($value['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($value['tmp_name']);
    if ($check) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    if ($value['size'] > 500000) {
        $uploadOk = 0;
    }

    if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif' && $imageFileType != 'jpeg') {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo 'error';
    } else {
        chmod('uploads/', 0777);
        if (move_uploaded_file($value["tmp_name"], $target_file)) {
            array_push($addressList,$target_file);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}