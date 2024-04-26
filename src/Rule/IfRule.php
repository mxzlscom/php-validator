<?php

namespace Mengx\Validator\Rule;

use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class IfRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null): void
    {

        if(!$args){
            throw new ValidateException('未设置有效的验证参数');
        }

        if (preg_match('/^[a-zA-Z_]+=[a-zA-Z_0-9]+$/', $args) !== 1) {
            throw new ValidateException('未设置有效的验证参数');
        }
        $params = explode('=',$args);
        $ifKey = $params[0];
        $ifValue = $params[1];
        // 如果存在目标值，则进行判断
        if(isset($options[$ifKey]) && $options[$ifKey] == $ifValue){
            // 必须存在当前值
            if(!isset($options[$key])){
                throw new ValidateException($message?:sprintf('%s 不能为空',$keyName));
            }
        }
    }

}