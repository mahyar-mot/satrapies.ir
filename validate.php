<?php
foreach ($_POST as $key=>$value){
    $value = is_array($value) ? $value : checkInput($value);
    if (empty($value) && in_array($key, $required)){
        $missing[] = $key;
        $$key = '';
    }elseif (in_array($key, $expected)){
        $$key = $value;
    }
}
function formValidate(&$arr, $input, $field){
    switch ($field){
        case 'name':
            $i = preg_match('/[0-9]/', $input) ? '<span class="red-text">فقط حروف قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
        case 'tel':
            $i = preg_match('/[a-zA-Z]/', $input) ? '<span class="red-text">فقط عدد قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
        case 'mobile':
            $i = preg_match('/[a-zA-Z]/', $input) ? '<span class="red-text">فقط عدد قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
        case 'creation_year':
            $i = preg_match('/[a-zA-Z]/', $input) ? '<span class="red-text">فقط عدد قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
        case 'unit':
            $i = preg_match('/[a-zA-Z]/', $input) ? '<span class="red-text">فقط عدد قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
        case 'meter':
            $i = preg_match('/[a-zA-Z]/', $input) ? '<span class="red-text">فقط عدد قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
        case 'price':
            $i = preg_match('/[a-zA-Z]/', $input) ? '<span class="red-text">فقط عدد قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
        case 'monthly_fee':
            $i = preg_match('/[a-zA-Z]/', $input) ? '<span class="red-text">فقط عدد قابل قبول است</span>' : null;
            $arr[$field] = $i;
            break;
    }
}
function checkInput($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
