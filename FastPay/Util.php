<?php

class FastPay_Util
{
    static function encode(array $fields, $innerkey = null)
    {
        $ret = array();
        foreach ($fields as $key => $value) {
            if (is_string($value) || is_integer($value)) {
                if ( ! is_null($innerkey)) {
                    $key = $innerkey . "[" . $key . "]";
                }
                $ret[] = urlencode($key) . "=" . urlencode($value);
            } elseif (is_array($value)) {
                $ret[] = self::encode($value, $key);
            }
        }

        return implode("&", $ret);
    }

    static function createHeader(array $header = array())
    {
        $base = array(
            "content-type: application/x-www-form-urlencoded",
            "host: wallet-api.yahooapis.jp",
        );

        $base[] = "user-agent: FastPay-php v" . FastPay::VERSION;

        return array_merge($base, $header);
    }

    static function parser($body, $info)
    {
        $jsonData = json_decode($body, true);

        if (isset($jsonData["error"]["type"])) {
            switch ($jsonData["error"]["type"]) {
                case 'card_error':
                    throw new FastPay_CardError($info["http_code"], $body, $jsonData["error"]["code"]);
                    break;
                case 'api_error':
                    throw new FastPay_ApiError($info["http_code"], $body);
                    break;
                case 'invalid_request_error':
                    throw new FastPay_InvalidRequestError($info["http_code"], $body);
                    break;
            }
        }

        return self::convertFastPayObject($jsonData);
    }

    static function convertFastPayObject($jsonData)
    {
        if ($jsonData["object"] === "list") {
            $responseList = array();
            for ($i = 0; $i < $jsonData["count"]; $i++) {
                if (isset($jsonData["data"][$i])) array_push($responseList, self::returnFastPayObject($jsonData["data"][$i]));
            }
            return $responseList;
        } else {
            return self::returnFastPayObject($jsonData);
        }
    }

    static function basicAuth()
    {
        return FastPay::getSecret() . ":";
    }

    private static function returnFastPayObject($object)
    {
        switch (gettype($object)) {
            case "array":
                foreach ($object as $key => $value) {
                    if ( ! is_null(self::checkFastPayObject($key))) {
                        $object[$key] = self::returnFastPayObject($value);
                    }
                }
                if(isset($object["object"])) {
                    $className = self::checkFastPayObject($object["object"]);
                    return new $className($object);
                } else {
                    return $object;
                }
                break;
            default:
                return $object;
        }
    }

    private static function checkFastPayObject($name)
    {
        $classes = array(
            "charge" => "FastPay_Charge",
            "card" => "FastPay_Card",
        );

        return array_key_exists($name, $classes) ?  $classes[$name] : "FastPay_Object";
    }
}
