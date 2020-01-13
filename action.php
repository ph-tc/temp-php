<?php

    function getUserIP()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    // запустим сессию чтобы не делать лишних переходов
    session_start();

    $initData = array(
        'route' => 'N9ZUhVij68d9q7Ju',
        'pid' => $_SESSION['pid'],
        'ip' => getUserIP(),
        'success_url' => 'http://izuchai.dance/',
        'fail_url' => isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'http://'.$_SERVER['HTTP_HOST']."/action.php",
        'phone' => $_POST['phone'],
        'partner_id' => 2006,
    );

    ksort( $initData );

    $initData['sign'] = md5( md5( 'lFxJBfSRdT' . implode($initData, ',') . 'http://izuchai.dance' ) );

    $data = file_get_contents( 'http://api.idvlp.pw/get-link?'.http_build_query( $initData ) );

    $respJson = json_decode( $data );

    if( $respJson->status != 'true' )
    {
        $_SESSION['has_redirect'] = true;
        die( header("Location: /?error") );
    }

    