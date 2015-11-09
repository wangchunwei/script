<?php

$url = "http://shifu.baidu.com/submit/activity/pocket201510sendvcode";//有短信请求的API
for($i = 0; $i < 4; $i ++) {
    $mobile = "1371". mt_rand(0000000, 9999999);
    $post = array("phone" => $mobile, "bdsToken" => "2c29b051385b42ecc13e7bf3360dd0b3", "bdstt" => "1447048261");
    $res = query($url, array(), $post);
    var_dump($res);
    var_dump($mobile);
    die();
    $res = json_decode($res, true);

}

function query($url, $get=array(), $post = array()) {

    $urlPrefix = $url;
     
    $query = http_build_query($get);
    $url = $urlPrefix.(strpos($urlPrefix, "?") ? "&" : "?") . $query;

    $opt = array(
            CURLOPT_RETURNTRANSFER  => TRUE,
            CURLOPT_HEADER          => FALSE,
            CURLOPT_FOLLOWLOCATION  => FALSE,
            CURLOPT_ENCODING        => "",

            CURLOPT_AUTOREFERER     => TRUE,
            CURLOPT_CONNECTTIMEOUT  => 1,
            CURLOPT_TIMEOUT         => 5,
            CURLOPT_SSL_VERIFYHOST  => 0,
            CURLOPT_SSL_VERIFYPEER  => FALSE,
            CURLOPT_VERBOSE         => FALSE,
    );
     
    $ch = curl_init();
    curl_setopt_array($ch, $opt);
     
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:8.8.8.8'));  //构造IP
    curl_setopt($ch, CURLOPT_REFERER, "http://shifu.baidu.com/activity/pocket201510");   //构造来路
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if($post) {
        $post = http_build_query($post);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $raw   = curl_exec($ch);
    $errno = curl_errno($ch);

    if ($errno == CURLE_COULDNT_CONNECT) {
        echo "connect wrong {$url}";
        die();
    }

    return $raw;
}