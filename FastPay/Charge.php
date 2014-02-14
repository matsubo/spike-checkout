<?php

class FastPay_Charge extends FastPay_Object
{
    static function create(array $fields)
    {
        $instance = new self;
        return $instance->executeRequest("post", $instance->url(), $fields);
    }

    static function retrieve($id)
    {
        $instance = new self;
        return $instance->executeRequest("get", $instance->url(array($id)));
    }

    static function all($fields)
    {
        $instance = new self;
        return $instance->executeRequest("get", $instance->url(), $fields);
    }

    function refund()
    {
        return $this->executeRequest("post", $this->url(array($this->id, "refund")));
    }

    function capture()
    {
        return $this->executeRequest("post", $this->url(array($this->id, "capture")));
    }
}
