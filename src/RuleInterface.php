<?php

namespace Mengx\Validator;

interface RuleInterface
{
    public static function filter(array &$options,string $key,string $keyName,string $args = null,string $message = null):void;
}