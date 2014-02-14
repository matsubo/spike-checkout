<?php

class FastPay_CardError extends FastPay_Error
{
    function __construct($http_status=null, $http_body=null, $code=null)
    {
        parent::__construct($http_status, $http_body);
        $this->code = $code;
    }
}

