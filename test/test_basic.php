<?php declare(strict_types=1);

namespace Mengx\test;

require __DIR__.'/../vendor/autoload.php';

use Mengx\Validator\Validator;

class test_basic
{

    // 格式化输入
    public static function test_format(){
        $params = ['name' => 1];
        $rules = ['name' => 'str'];
        $r = Validator::filter($params,$rules);
        var_export($r);
        // 输出的是 字符串
    }


    // 消息提示1
    public static function test_message1(){
        $params = [];
        $rules = ['name:名字' => 'req'];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }
    // 消息提示2
    public static function test_message2(){
        $params = [];
        $rules = ['name' => 'req:姓名不能为空！'];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }

    // 多重验证1
    public static function test_check(){
        $params = ['name' => 1];
        $rules = ['name' => 'req,str'];
        $r = Validator::filter($params,$rules);
        var_export($r);
        // 输出的是 字符串
    }
    // 多重验证2
    public static function test_check2(){
        $params = ['name' => 1];
        $rules = ['name' => [
            'req','str',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
        // 输出的是 字符串
    }

    // 字符串验证
    public static function test_float(){
        $params = ['age' => 5];
        $rules = ['age' => [
            'req','float!>1','float!<3',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }

    // 汉字验证
    public static function test_ch(){
        $params = ['name' => '萌新'];
        $rules = ['name' => [
            'req','ch',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }

    // 身份证验证
    public static function test_id(){
        $params = ['id_number' => '360124200012121111'];
        $rules = ['id_number' => [
            'req','id',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }

    // 数字验证
    public static function test_int(){
        $params = ['age' => '20000'];
        $rules = ['age' => [
            'req','int!>1','int<10000',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }
    // 数组验证
    public static function test_list(){
        $params = ['items' => [1,2,3]];
        $rules = ['items' => [
            'req','list',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }
    // 连接验证&提取
    public static function test_url1(){
        $params = ['link' => '分享一个网址： https://www.baidu.com/s?ie=UTF-8&wd=Warning%3A%20Module%20%27ssh2%27%20already%20loaded%20in%20Unknown%20on%20line%200 是一个网址'];
        $rules = ['link' => [
            'req','url',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }
    // 正则验证
    public static function test_regex(){
        $params = ['number' => '001231'];
        $rules = ['number' => [
            'req','regex!/^[\d]*$/',
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }
    // 正则验证2
    public static function test_regex2(){
//        $params = ['number' => 'T001231'];// error
        $params = ['number' => '001231'];
        $rules = ['number' => [
            'req',Validator::makeRule('regex','/^[\d]*$/','请输入正确的编号')
        ]];
        $r = Validator::filter($params,$rules);
        var_export($r);
    }

    // 验证子对象
    public static function test_child_list(){
        $params = [
            'contacts' => [
                ['name' => '张三','age' => 24],
                ['name' => '李四','age' => 'fa'],
                ['name' => '王五','age' => '22'],
            ],
        ];

        $rules = [
            'contacts' => ['req',[
                'name' => ['req'],
                'age' => ['req','int'],
            ]]
        ];

        $r = Validator::filter($params,$rules);
        var_export($r);
    }

    // 验证子对象
    public static function test_child_object(){
        $params = [
            'contact' =>                 ['name' => '张三','age' => 12],
        ];

        $rules = [
            'contact' => [[
                'name' => 'str',
                'age' => 'req,int',
            ]],
        ];

        $r = Validator::filter($params,$rules);
        var_export($r);
    }

}


//test_basic::test_regex2();
//test_basic::test_child_list();
test_basic::test_child_object();

