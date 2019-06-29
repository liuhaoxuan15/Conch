<?php
namespace app\web_view\controller;

use think\Controller;
use think\Db;

class Register extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function register()
    {
        if (request()->isPost()) {
            $code = input('param.verifycode');
            $data = [
                'user_name' => input('param.user_name'),
                'user_password' => input('param.password'),
                'user_phone' => input('param.user_phone'),
                'user_img' => 'default.jpg',
            ];
            $password = input('param.password');
            if($password!=$data['user_password']){
                return $this->error("两次密码不一致，请重新输入");
            }
            $smscode = Db::name("smscode")->where('mobile',$data['user_phone'])->value('code');
            if($smscode == $code) {
                $res = Db::name("users")->insert($data);
                if($res){
                    return $this->success("注册成功,请登录","login/index");
                } else {
                    return $this->error("注册失败");
                }
            } else {
                return $this->error("验证码错误");
            }
        }
    }

    public function show_captcha()
    {
        ob_clean();
        $captcha = new \think\captcha\Captcha();
        $captcha->useZh = true;
        $captcha->zhSet = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTUIOPASDFGHJKLZXCVBNM";
        $captcha->fontSize = 20;
        $captcha->length   = 3;
        $captcha->useNoise = false;
        return $captcha->entry();
    }

    public function sendMessage()
    {
        $m = input('param.m');
        $randNum = rand(0000, 9999);
        $u = '703929634';
        $p = md5('lhx1115');
        $c = input('param.c');
        $url = "http://api.smsbao.com/sms?u=" . $u . "&p=" . $p . "&m=" . $m . "&c=" . $c . $randNum;

        $isCreat = Db::name("smscode")->where('mobile', $m)->find();
        $isRegister = Db::name("users")->where('user_phone', $m)->find();
        if ($isRegister) {
            return json("该手机号已被注册");
        } else {
            // $file 是访问$url后返回的结果
            $file = file_get_contents($url);
            if ($file == 51) {
                return json("请输入正确的手机号");
            } else if ($file == -1) {
                return json("请输入手机号");
            } else {
                if ($isCreat) {
                    $data = [
                        'code' => $randNum,
                        'update_time' => date('Y-m-d H-i-s')
                    ];
                    $res = Db::name("smscode")->where('mobile', $m)->update($data);
                    return $file;
                } else {
                    $data = [
                        'mobile' => $m,
                        'code' => $randNum,
                        'create_time' => date('Y-m-d H-i-s'),
                        'update_time' => date('Y-m-d H-i-s')
                    ];
                    $res = Db::name("smscode")->insert($data);
                    return $file;
                }
            }
        }
    }
}
