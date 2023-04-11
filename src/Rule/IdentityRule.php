<?php declare(strict_types=1);


namespace Mengx\Validator\Rule;


use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class IdentityRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null):void
    {
        if(!isset($options[$key])){
            return;
        }
        // 身份证验证
        $options[$key] = strval($options[$key]);
        $pattern = '/^[1-9]\d{5}(18|19|20)\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/';
        if(preg_match($pattern,$options[$key]) !== 1){
            throw new ValidateException($message ?: sprintf('%s 不正确',$keyName));
        }
    }
}