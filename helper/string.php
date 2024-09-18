<?php



function randomString ($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function randomCode () {
    // code is 4 integer
    $num = '0123456789';
    $numLength = strlen($num);
    $code = '';
    for ($i = 0; $i < 4; $i++) {
        $code .= $num[rand(0, $numLength - 1)];
    }
    return $code;
}
function randomName () {
    $res = "ahexvps_". randomString(10);
    return $res;

}


?>