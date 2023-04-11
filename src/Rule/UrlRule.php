<?php declare(strict_types=1);


namespace Mengx\Validator\Rule;


use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class UrlRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null):void
    {
        if (!isset($options[$key])) {
            return;
        }
        $str = strval($options[$key]);
        if($options[$key]){
            $pattern = "/(http:\/\/|https:\/\/)?[a-zA-Z\d\-]+[.]{1}[a-zA-Z\d\-\/+_#%?=&]+[.]{1}[a-zA-Z\d\-\/+_#%?=&\.]*/";
            preg_match($pattern,$str,$result);
            if(isset($result[0])){
                $options[$key] = $result[0];
            }else{
                throw new ValidateException($message ?: sprintf('%s 不是一个正确的链接',$keyName));
            }
        }
    }
}