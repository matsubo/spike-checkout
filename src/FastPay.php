<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__)));

class FastPay
{
    private static $secret = null;
    private static $url = "https://fastpay.yahooapis.jp";
    private static $version = "v1";

    const VERSION = 0.1;

    static function setUrl($_url)
    {
        self::$url = $_url;
    }

    static function getUrl()
    {
        return self::$url;
    }

    static function setSecret($_secret)
    {
        self::$secret = $_secret;
    }

    static function getSecret()
    {
        if (self::$secret === null) {
            throw new Exception("Check your secret here: http://fastpay.yahoo.co.jp/account");
        }
        return self::$secret;
    }

    static function setVersion($_version)
    {
        self::$version = $_version;
    }

    static function getVersion()
    {
        return self::$version;
    }
}

require_once "FastPay/Object.php";
require_once "FastPay/Util.php";
require_once "FastPay/Charge.php";
require_once "FastPay/Card.php";
require_once "FastPay/Request.php";
require_once "FastPay/Error.php";
require_once "FastPay/Errors/ApiError.php";
require_once "FastPay/Errors/CardError.php";
require_once "FastPay/Errors/ConnectionError.php";
require_once "FastPay/Errors/InvalidRequestError.php";
