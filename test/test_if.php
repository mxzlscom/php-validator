<?php declare(strict_types=1);


namespace Mengx\test;

require __DIR__.'/../vendor/autoload.php';

use Mengx\Validator\Validator;

class test_str
{

    // 验证方式1
    public static function test_filter1(){
        $params = ['type' => 'INCR','money_incr' => 66.6];
        $rules = ['type' => ['req','str'],'money_incr' => ['if!type=INCR:请填写添加的金额','float!>0:请填写正确的金额']];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }




}

test_str::test_filter1();