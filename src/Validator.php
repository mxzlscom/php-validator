<?php declare(strict_types=1);


namespace Mengx\Validator;


use Mengx\Validator\Rule\ChineseRule;
use Mengx\Validator\Rule\FloatRule;
use Mengx\Validator\Rule\IdentityRule;
use Mengx\Validator\Rule\IntegerRule;
use Mengx\Validator\Rule\ListRule;
use Mengx\Validator\Rule\PhoneRule;
use Mengx\Validator\Rule\RegexRule;
use Mengx\Validator\Rule\RequiredRule;
use Mengx\Validator\Rule\StringRule;
use Mengx\Validator\Rule\UrlRule;

class Validator
{
    /**
     * 验证规则别名
     * @var array
     */
    private static array $aliasMap = [
        'req' => RequiredRule::class,
        'str' => StringRule::class,
        'ch' => ChineseRule::class,
        'float' => FloatRule::class,
        'id' => IdentityRule::class,
        'int' => IntegerRule::class,
        'list' => ListRule::class,
        'phone' => PhoneRule::class,
        'url' => UrlRule::class,
        'regex' => RegexRule::class,
    ];


    /**
     * 排除某些规则
     * @param array $rules
     * @param array $excludeRules
     * @return array
     */
    public static function excludeRules(array $rules,array $excludeRules):array{
        // 要判断 rules 中是否使用了 key:alias 的键，如果是这样
        foreach ($excludeRules as $key => $value){
            if(is_array($value)){
                // 数组套数组，通过key 区分吗
                $rules[$key] = self::excludeRules($rules[$key],$value);
            }else{
                // 删除掉
                if(isset($rules[$value])){
                    unset($rules[$value]);
                }else{
                    // 判断是否存在  k:a 格式
                    $needle = $value.':';
                    foreach ($rules as $originalRuleKey => $originalRuleValue){
                        if(strpos($originalRuleKey,$needle) !== false){
                            unset($rules[$originalRuleKey]);
                            break;
                        }
                    }
                }
            }
        }
        return $rules;
    }



    /**
     * 排除某些参数
     * @param array $params
     * @param array $keys
     * @return array
     */
    public static function exclude(array $params,array $keys):array{
        foreach ($keys as $key){
            if(isset($params[$key])){
                unset($params[$key]);
            }
        }
        return $params;
    }



    /**
     * 过滤参数，不再验证名单中的参数将被过滤
     * @param array $params
     * @param array $rules
     * @return array
     */
    public static function filter(array $params,array $rules):array{
        $filteredOptions = [];
        foreach ($rules as $originalKey => $originalRule){

            if(strpos($originalKey,':') !== false){
                $keyOptions = explode(':',$originalKey);
                $key = $keyOptions[0];
                $keyName = $keyOptions[1]; // 年龄
            }else{
                $key = $keyName = $originalKey; // age
            }

            // 要明确的事，过滤可能过滤出空数据，这个是允许的。也就是没有任何数据，或者说是一个空数组，也就是说我最后是要返回一个空数组出去的
            if(is_array($originalRule)){
                // 判断普通数组和map
                $preRules = $originalRule;
            }else{
                $preRules = [];
                if(strpos($originalRule,',') === false){
                    $preRules[] = $originalRule;
                }else{
                    $preRules = explode(',',$originalRule);
                }
            }

            $columnRules = [];
            // parse original rules
            foreach ($preRules as $str){
                if(is_string($str)){
                    // handle message
                    if($index = strpos($str,':') === false){
                        $message = null;
                    }else{
                        $strOptions = explode(':',$str);
                        $message = $strOptions[1];
                        $str = $strOptions[0];
                    }
                    // handle rule args
                    if($index = strpos($str,'!') === false){
                        $args = null;
                        $ruleName = $str;
                    }else{
                        $strOptions = explode('!',$str);
                        $args = $strOptions[1]; // 20~100
                        $ruleName = $strOptions[0]; // int
                    }
                    // check
                    $columnRules[] = [
                        'rule' => $ruleName,
                        'option' => [
                            'message' => $message,
                            'args' => $args,
                        ],
                    ];
                }elseif($str instanceof ValidatorRule){
                    $columnRules[] = [
                        'rule' => $str->getRule(),
                        'option' => [
                            'message' => $str->getMessage(),
                            'args' => $str->getArgs(),
                        ],
                    ];
                }
            }

            foreach ($columnRules as $columnRule){
                $instance = self::$aliasMap[$columnRule['rule']];
                $instance::filter($params,$key,$keyName,$columnRule['option']['args'],$columnRule['option']['message']);
            }

            if(isset($params[$key])){
                $filteredOptions[$key] = $params[$key];
            }
        }
        return $filteredOptions;
    }

    public static function makeRule(string $ruleAlias,$args=null,string $message=null):ValidatorRule{
        return new ValidatorRule($ruleAlias,$args,$message);
    }

}