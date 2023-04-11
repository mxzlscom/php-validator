<?php declare(strict_types=1);


namespace Mengx\Validator\Rule;


use Mengx\Validator\Exception\ValidateException;
use Mengx\Validator\RuleInterface;

class IntegerRule implements RuleInterface
{
    public static function filter(array &$options, string $key, string $keyName, string $args = null, string $message = null): void
    {
        if (!isset($options[$key])) {
            return;
        }
        $value = intval($options[$key]);
        $options[$key] = $value;
        if (is_null($args)) {
            return;
        }
        //  <
        $index = strpos($args, '<');
        if ($index !== false) {
            if ($index === 0) {
                // begin <240
                $param = intval(substr($args, 1));
                if ($value >= $param) {
                    throw new ValidateException($message ?: sprintf('%s 必须小于 %d', $keyName, $param));
                }

            } else {
                // end 240<
                $param = substr($args, 0, -1);
                if ($value <= $param) {
                    throw new ValidateException($message ?: sprintf('%s 必须大于 %d', $keyName, $param));
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
                if ($value <= $param) {
                    throw new ValidateException($message ?: sprintf('%s 必须大于 %d', $keyName, $param));
                }

            } else {
                // end 240>
                $param = substr($args, 0, -1);
                if ($value >= $param) {
                    throw new ValidateException($message ?: sprintf('%s 必须小于 %d', $keyName, $param));
                }
            }
            return;
        }
        // 1~20
        if (strpos($args, '~') !== false) {
            $params = explode('~', $args);
            $min = intval($params[0]);
            $max = intval($params[1]);
            if ($value < $min) {
                throw new ValidateException($message ?: sprintf('%s 必须大于 %d', $keyName, $min));
            }
            if ($value > $max) {
                throw new ValidateException($message ?: sprintf('%s 必须小于 %d', $keyName, $max));
            }
        }
    }
}