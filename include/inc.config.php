<?php

	session_start(); // Включим сессию на всех страницах

    # если есть pid запомним его
    if( isset($_GET['pid']) )
        $_SESSION['pid'] = $_GET['pid'];


    # если pid нету - дадим любое для работы скрипта
    if( !isset($_SESSION['pid']) )
        $_SESSION['pid'] = -1;

    # если нету шторы, создадим параметры под нее
    if( !isset($_SESSION['shtora']) )
        $_SESSION['shtora'] = $_SESSION['start_time'] = $_SESSION['uid'] = $_SESSION['phone'] = false; // По умолчанию запрашивать нечего

	// Получение реального IP
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

    // пошли переменные
    $s_rsaPrivateKey = 'MIIEpAIBAAKCAQEAlXNQhAfjfVniQ05PuAqk0Rquyu5RKlR1NpN31jOwvhelqJ4faAdlZ0unUV5+MA2ps/9WPitU4W0Fcuel/aY5eB7VtMRbPBX2wlwp3RmauCK2oyduBW5oLyKI86t5d0ZnLqIQg0JCuOAYa8stwclLKmQ1AE85tlvF8SZ+Ul8iWluBbSUMo6eDmw7l4d/CO5YeOEendzWRfnwUMP5hyCBN/sXRU3Js36CxTwjZbs43R6gH3GvWmAY7930VVqRROFihhrpnBUwlLMIMauiKruZb4VD0y7nAVjZNXt+1AKhOjJ3qt5gZASjuLWxk2mUVUx15a9rInbIcpc/8pCbMoZmucwIDAQABAoIBAQCEj9NkOWcUoeyrjMPzWCWXgJZ4U+lUpbOOZEHQkur7whfjt9XdvWm5tQZFi45ca1IS4bKK1H6mscA6irTWh2HEZX1jqSPP6R+GiJ9tia+OEuRzVZ8mXCc3X+egU4IbRSxy1bfV5akvOT8QJhmBIV51zIqiqqNjWIX8AAveXponEErGRizusRt/utbmVcjGWjLKOKG/EtCYp9COFgSBXLmGaRx0q8r3DTIV/6lf+9lxVnh3UeyVAgglhbky4DqfcajF4sOy3iG3fp7E4CDDwR/sxnNTAnjS3uBs/e0Mp04xfUmLbSAVEck7dItiefmiLDIAgEY8yCWJn4I6+mVYRuDhAoGBAP14/WronxoQXK5DnPyFznQgvcs+AvqhrXBId2nBouJ9GR+W7hxjdCv6A1e7AeGcSCE4X0elG1iWFRMTX0I76ib+5dKXyeCpQmErTmnxjvBft3ojOU2MmaSRdaegt/gOwSao2g8MqRDK5O8nq0wYMFf22RzCb+ExAzrYmnwGvKMDAoGBAJbwzJ73L1CkpYOH6+fsRxSNly+53wKZvlzbahlaG/D5K4+V5N7OCmvWX1WsmxACMUK7Bs/Sf4Rwn0UAG/WrdzFhWyQivbis8jvdOrl7r129gf9Us6y22BVlveR6ZCM+t8g+FKtLJU6iFQAF2wV6goEFmMgaPae+UmRy9ALEtTPRAoGBAMR1vpXab1bYT72SEl93pqlDp1ecXNq97ZwVzthdiU5a/9oINc4zF5vuUCDzhWXEp/N3qgHx6twil3sNjMvdfIN1FdTAaWyERDrkQgbDf7K3vZIhMwz0aTGwvKyMWYsehH7eaQU5HuExIXhsGs0EApRrc6Ri4Cx+vK4jrLlsz1DZAoGAJfJLvvstrfx2j+av7BJ+nDAsfhcgdarpLLcMqWr5807xIJvyegEapZmzRfqq0Q98CuayA7VL0aPupo4seUquIH/1RdRmFfOEwoAPr2nk4JAwClzk/trI4Dg/0Rzj5+hwk6rnz1iI/IfK98KBGZN/E6iwjD3smitC03YC2l9RnsECgYBG5SObAP/mp58wojxk0Hoek/MiRq9hOP7OMPxFiC6tFXUELdSmXTK286PK1ohJoj+LgtWJRBmRsOvxbdZnkAM4dwCLrev3ewDaJUOLKRMEOVK1MSofxnYuwzWiXETDMtLnTIjb+i3vsTEiTEwHTeTVwjmcmHPv3bEZ65IRhkPF7g==';

    $a_cfg = [
    	'service_route' => 'N9ZUhVij68d9q7Ju',
    	'service_hash' => 'lFxJBfSRdT',
    	'service_name' => 'http://izuchai.dance',
    	'service_partner_id' => '2006'
    ];

