<?php declare(strict_types=1);


namespace Mengx\Validator\Rule;


use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class StringRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null): void
    {
        // 不存在不验证
        if (!isset($options[$key])) {
            return;
        }
        $value = trim(strval($options[$key]));
        $options[$key] = $value;
        if (is_null($args)) {
            return;
        }
        // 2~11
        $len = mb_strlen($value);
        //  <
        $index = strpos($args, '<');
        if ($index !== false) {
            if ($index === 0) {
                // begin <240
                $param = intval(substr($args, 1));
                if ($len >= $param) {
                    throw new ValidateException($message ?: sprintf('%s 不能超出 %d 个字符', $keyName, $param));
                }

            } else {
                // end 240<
                $param = substr($args, 0, -1);
                if ($len <= $param) {
                    throw new ValidateException($message ?: sprintf('%s 不能少于 %d 个字符', $keyName, $param));
                }
            }
            return;
        }
        //  >
        $index = strpos($args, '>');
        if ($index !== false) {
            if ($index === 0) {
                // begin >240
                $param = substr($args, 1);
                if ($len <= $param) {
                    throw new ValidateException($message ?: sprintf('%s 必须大于 %d 个字符', $keyName, $param));
                }

            } else {
                // end 240>
                $param = substr($args, 0, -1);
                if ($len >= $param) {
                    throw new ValidateException($message ?: sprintf('%s 不能超出 %d 个字符', $keyName, $param));
                }
            }
            return;
        }
        // 1~20
        if (strpos($args, '~') !== false) {
            $params = explode('~', $args);
            $min = intval($params[0]);
            $max = intval($params[1]);
            if ($len < $min) {
                throw new ValidateException($message ?: sprintf('%s 不能少于 %d 个字符', $keyName, $min));
            }
            if ($len > $max) {
                throw new ValidateException($message ?: sprintf('%s 不能超出 %d 个字符', $keyName, $max));
            }
        }
    }
}