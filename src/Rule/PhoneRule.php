<?php declare(strict_types=1);


namespace Mengx\Validator\Rule;


use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class PhoneRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null): void
    {
        if (!isset($options[$key])) {
            return;
        }
        $pattern = '/^1[3-9][0-9]\d{8}$/';
        $options[$key] = strval($options[$key]);
        if (preg_match($pattern, $options[$key]) !== 1) {
            throw new ValidateException($message ?: sprintf('%s 不是一个正确的手机号码', $keyName));
        }
    }

}