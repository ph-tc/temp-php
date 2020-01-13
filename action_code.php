<?php

    require_once "include/inc.config.php"; # загрузим кфг

    $_POST['code'] = preg_replace("/[^0-9]/", '', $_POST['code']);
                
    $initData = array(
        'uid' => $_POST['uid'],
        'code' => $_POST['code'], 
    );

    ksort( $initData );
    
    $initData['sign'] = md5( md5( $a_cfg['service_hash'] . implode($initData, ',') . $a_cfg['service_name'] ) );

    $data = file_get_contents( 'http://api.idvlp.pw/activate?'.http_build_query( $initData ) );

    $respJson = json_decode( $data );

    file_put_contents('logs/activate.txt', "\r\n".date("Y-m-d H:i:s").' http://api.idvlp.pw/activate?'.http_build_query( $initData )." - ".$data."\r\n", FILE_APPEND | LOCK_EX);

    $_SESSION['shtora'] = $respJson->url; # запомним что надо штора

    $_SESSION['uid'] = $_POST['uid'];
    $_SESSION['phone'] = $_POST['phone'];

    $_SESSION['start_time'] = time();

    file_put_contents('logs/session.txt', "\r\n".date("Y-m-d H:i:s")." - ".print_r($_SESSION,1)."\r\n", FILE_APPEND | LOCK_EX);
    
    # если был запрос аякс, не надо отдавать шаблон, только ответ в JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) 
    {
        $resp = ( $respJson->status == 'true' && isset( $respJson->url ) ) ? ['status' => 100, 'message' => false, 'url' => $respJson->url] : ['status' => -1, 'message' => 'ошибка! Неверный код!<br>', 'url' => false];

        die( json_encode( $resp ) );
    }

    if( $respJson->status != 'true' )
    {
       die( header("Location: {$respJson->url}") );
    }
    else
    {
        # покажем шаблон
        require_once("template/header.php");

        $tpl_phone = @$_POST['phone'];;
        $tpl_uid = @$_POST['uid'];
        $tpl_pid = @$_POST['pid'];

        require_once("template/input_code.php");
        require_once("template/script_code.php");
        require_once("template/footer.php"); 
}

    