<?php declare(strict_types=1);


namespace Mengx\Validator\Rule;


use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class ListRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null):void
    {
        if(!isset($options[$key])){
            return;
        }
        if(!is_array($options[$key])){
            throw new ValidateException($message ?: sprintf('%s必须为一个数组',$keyName));
        }
    }

}