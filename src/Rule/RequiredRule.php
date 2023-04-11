<?php declare(strict_types=1);


namespace Mengx\Validator\Rule;


use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class RequiredRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null):void
    {
        if(isset($options[$key])){
            return;
        }
        throw new ValidateException($message?:sprintf('%s 不能为空',$keyName));
    }

}