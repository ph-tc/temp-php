<?php

    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);

    require_once "include/inc.config.php"; # загрузим кфг

    $phone = "";

    $button_link = false;

    // Поработаем с кукой и определялкой

    // Мы не получили номер телефона в GET
    if( isset( $_GET['msisdn'] ) )
    {
        // Получили телефон с гет запроса
        $phone = $_GET['msisdn'];
    }
    elseif( isset( $_POST['phone'] ) )
    {
        // Получили телефон с гет запроса
        $_POST['phone'] = preg_replace("/[^0-9]/", '', $_POST['phone']);

        $phone = $_POST['phone'];
    }
    elseif( !isset($_GET['iphlr_data']) && !isset($_GET['iphlr_err']) )
    {
        // Раньше в кукис номер телефона не был записан
        if( !isset( $_COOKIE['msisdn'] ) && !$_SESSION['has_redirect'] )
        {
            $_SESSION['has_redirect'] = true; // Скажем скрипту что в рамках текущей работы браузера он уже пробовал определить

            #die( header("Location: http://iphlr.ru/v2/izuchaidance?redirect_url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ); // Редиректим к текущей странице, на ней же определялка и реализована
            $button_link = "http://iphlr.ru/v2/izuchaidance?redirect_url=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // Редиректим к текущей странице, на ней же определялка и реализована
        }
        elseif( isset( $_COOKIE['msisdn'] ) )
        {
            // Раньше сохраняли куку с определенным номером
            $phone = $_COOKIE['msisdn'];

            setcookie('msisdn', $phone, time() + (3600 * 24 * 30)); // сутки пользуемся кукой
        }
    }
    elseif( isset($_GET['iphlr_data']) )
    {

        // дешифруем 
        include('Crypt/RSA.php');

        $rsa = new Crypt_RSA();

        $rsa->loadKey( $s_rsaPrivateKey); // private key
        
        $rsa->setHash('sha256');
        $rsa->setMGFHash('sha256');

        $decrypt = $rsa->decrypt(base64_decode($_GET['iphlr_data']));

        $data = (array)json_decode( $decrypt );

        // Получили телефон с гет запроса
        $phone = $data['msisdn'];

        setcookie('msisdn', $phone, time() + (3600 * 24 * 30)); // сутки пользуемся кукой


    }

    if( $phone ) # номер определили и сделаем активацию и на редирект с кодом
    {
        unset( $_SESSION['shtora'] );

        $initData = array(
            'route' => $a_cfg['service_route'],
            'pid' => $_SESSION['pid'],
            'ip' => getUserIP(),
            'success_url' => 'http://izuchai.dance/',
            'fail_url' => isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'http://'.$_SERVER['HTTP_HOST']."/action.php",
            'phone' => $phone,
            'partner_id' => $a_cfg['service_partner_id']
        );

        ksort( $initData );

        $initData['sign'] = md5( md5( $a_cfg['service_hash'] . implode($initData, ',') . $a_cfg['service_name'] ) );

        $data = file_get_contents( 'http://api.idvlp.pw/get-link?'.http_build_query( $initData ) );
    
        file_put_contents('logs/get-link.txt', "\r\n".date("Y-m-d H:i:s")." - ".'http://api.idvlp.pw/get-link?'.http_build_query( $initData )." - ".print_r($data,1)."\r\n", FILE_APPEND | LOCK_EX);

        $respJson = json_decode( $data );

        if( isset( $respJson->uid ) )
        {
            # покажем шаблон 
            require_once("template/header.php");

            $tpl_phone = $phone;
            $tpl_uid = @$respJson->uid;
            $tpl_pid = @$_SESSION['pid'];

            require_once("template/input_code.php");
            require_once("template/script_code.php");
            require_once("template/footer.php");

            exit; # закончим шаблон для пина
        }
    }
    
    # номер не определили надо вручную пин запросить
    require_once("template/header.php");
    require_once("template/input_phone.php");
    require_once("template/footer.php");
