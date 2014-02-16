<?php

class FastPay_Card extends FastPay_Object
{
    static function create(array $fields)
    {
        $instance = new self;
        return $instance->executeRequest("post", $instance->url(), $fields)->send();
    }
}

