<?php

class FastPay_Object implements ArrayAccess
{
    private $values;

    function __construct($values = array())
    {
        unset($values["object"]);
        $this->values = $values;
    }

    function executeRequest($method = "get", $url, $fields=array())
    {
        $options = array(
            "httpheader" => FastPay_Util::createHeader(),
            "userpwd" => FastPay_Util::basicAuth(),
            "ssl_verifypeer" => true,
            "timeout" => 80,
            "connecttimeout" => 30,
        );

        $fields = FastPay_Util::encode($fields);

        switch ($method) {
            case 'get':
                $url .= "?" . $fields;
                break;
            case 'post':
                $options["post"] = true;
                $options["postFields"] = $fields;
                break;
        }

        $request = new FastPay_Request($url, $options);
        list($body, $info) = $request->send();

        return FastPay_Util::parser($body, $info);
    }

    static function url($custom_url=null)
    {
        $url = array(
            FastPay::getUrl(),
            FastPay::getVersion(),
            self::getClassName(get_called_class()),
        );

        if( ! is_null($custom_url)) {
            $url = array_merge($url, $custom_url);
        }
        return implode("/", $url);
    }

    private static function getClassName($name)
    {
        # class名がFastPay_Chargeだったchargesに返す
        return strtolower(substr($name, strlen("FastPay_")) . "s");
    }

    /**
     * Get a data by key
     *
     * @param string The key data to retrieve
     * @access public
     */
    function __get ($key) {
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }

    /**
     * Assigns a value to the specified data
     *
     * @param string The data key to assign the value to
     * @param mixed  The value to set
     * @access public
     */
    function __set($key,$value) {
        $this->values[$key] = $value;
    }

    function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }

    function offsetExists($offset) {
        return isset($this->values[$offset]);
    }

    function offsetUnset($offset) {
        unset($this->values[$offset]);
    }

    function offsetGet($offset) {
        return isset($this->values[$offset]) ? $this->values[$offset] : null;
    }

}

