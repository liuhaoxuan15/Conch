<?php
namespace app\web_view\controller;

use think\Controller;
use think\Db;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function login()
    {
        if (request()->isAjax()) {
            $account = $_POST['account'];
            $password = $_POST['password'];
            $user = Db::name("users")->where('user_phone', $account)->find();
            // return json($user);
            // return $admin;
            if (!$user) {
                // return json("账号不存在");
                return json("账号不存在");
            } else if ($password != $user['user_password']) {
                return json("密码错误");
            } else {
                // \think\Session::set('class_admin',$admin);
                \think\Session::set('user', $user);
                return json($user);
                // $this->redirect('home/index');                
                return json("登录成功");
            }
        }
    }

    public function sendMessage()
    {
        $m = input('param.m');
        $randNum = rand(0000, 9999);
        $u = '703929634';
        $p = md5('lhx1115');
        $c = input('param.c');
        $url = "http://api.smsbao.com/sms?u=" . $u . "&p=" . $p . "&m=" . $m . "&c=" . $c . $randNum;

        $isRegister = Db::name("admins")->where('admin_account', $m)->find();
        if (!$isRegister) {
            return json("该手机号尚未注册");
        } else {
            $file = file_get_contents($url);
            if ($file == 51) {
                return json("请输入正确的手机号");
            } else if ($file == -1) {
                return json("请输入手机号");
            } else {
                    $data = [
                        'code' => $randNum,
                        'update_time' => date('Y-m-d H-i-s')
                    ];
                    $res = Db::name("smscode")->where('mobile', $m)->update($data);
                    return $file;
            }
        }
    }

    public function retrieve()
    {
    // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id', $a['user_id'])->find();
            $this->assign("login_user", $user);
        }

        if (request()->isPost()) {
            $code = input('param.re_verifycode');
            $user_phone = input('param.re_phone');
            $password = input('param.re_password');
            $res = Db::name('smscode')->where('mobile', $user_phone)->find();
            $user_id = Db::name('users')->where('user_phone',$user_phone)->value('user_id');
            // return json($res);
            if(!$code){
                return $this->error('请输入验证码');
            }
            
            if ($code != $res['code']) {
                return $this->error('验证码错误');
            } else {
                $res1 = Db::name('users')->where('user_id', $user_id)->update(['user_password' => $password]);
                if ($res1) {
                    \think\Session::clear();
                    return $this->success('修改密码成功，请登录', 'login/index');
                } else {
                    return $this->error('修改失败');
                }
            }
        }
    }
}
