<?php

class FastPay_Error extends Exception
{
    function __construct($http_status=null, $http_body=null)
    {
        $message = sprintf("Status:%s, Body:%s", $http_status, $http_body);
        parent::__construct($message);
        $this->http_status = $http_status;
        $this->http_body = json_decode($http_body);
    }

    function getHttpStatus()
    {
        return $this->http_status;
    }

    function getHttpBody()
    {
        return $this->http_body;
    }

    function __toString()
    {
        return get_class($this) . " (Status " . $this->http_status . ") " . json_encode($this->http_body);
    }

}

