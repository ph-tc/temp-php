<?php

    require_once "include/inc.config.php"; # загрузим кфг

    if( !isset($_SESSION['shtora'] ) ) # убита штора
    {
        unset( $_SESSION['shtora'], $_SESSION['phone'], $_SESSION['uid'] );

        die( json_encode( ['status' => -1, 'url' => '/index.php' ] ) ); # надо отправить на авторизацию новую
    }

    if( time() - $_SESSION['start_time'] > 30 ) # ограничение времени шторы
    {
        $ses = $_SESSION;

        unset( $_SESSION['shtora'], $_SESSION['phone'], $_SESSION['uid'] );

        die( json_encode( ['status' => -2, 'url' => '/index.php?error=phone&msisdn='.$ses['phone'], 'session' => print_r( $ses, 1 ), 'time' => time() ] ) ); # надо отправить на авторизацию новую    
    }

    $initData = array(
        'partner_id' => $a_cfg['service_partner_id'],
        'route' => $a_cfg['service_route'],
        'num' => $_SESSION['phone']
    );

    ksort( $initData );
    
    $initData['sign'] = md5( md5( $a_cfg['service_hash'] . implode($initData, ',') . $a_cfg['service_name'] ) );
  
    $data = file_get_contents( 'http://api.idvlp.pw/get-info?'.http_build_query( $initData ) );

    $data = (array)json_decode( $data );

    file_put_contents('logs/datas.txt', "\r\n".date("Y-m-d H:i:s")." - ".print_r($data,1)."\r\n", FILE_APPEND | LOCK_EX);

    if( $data['status'] != true )
    {
        die( json_encode( ['status' => 2, 'url' => false ] ) ); # надо подождать активации  
    }

    if( $data['data']->status != 'stopped' && $data['data']->status != 'not_paid' && $data['data']->status != 'false' ) # статусы при которых подписка активна
    {
        die( json_encode( ['status' => -3, 'url' => $_SESSION['shtora'] ] ) ); # надо отправить на авторизацию новую    
    }

    die( json_encode( ['status' => 1, 'url' => false ] ) ); # надо подождать активации    

        
