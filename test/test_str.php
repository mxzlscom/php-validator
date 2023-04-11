<?php declare(strict_types=1);


namespace Mengx\test;

require __DIR__.'/../vendor/autoload.php';

use Mengx\Validator\Validator;

class test_str
{

    // 验证方式1
    public static function test_filter1(){
        $params = ['name' => 'Tio'];
        $rules = ['name' => 'str!2~12:名字应2~12个字符之间'];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }


    // 验证方式2
    public static function test_filter2(){
        $params = ['name' => 'T1222222222222222222'];
        $rules = ['name' => 'str!>2:名字应大于2个字符,str!<12:名字应小于12个字符'];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }

    // 中文验证
    public static function test_filter3(){
        $params = ['name' => 'T11'];
        $rules = ['name' => [
            'str!>2','ch'
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }

}

test_str::test_filter3();