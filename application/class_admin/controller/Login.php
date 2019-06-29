<?php
namespace app\class_admin\controller;

use think\Controller;
use think\Db;
use think\Session;

class Login extends Controller
{
    public function index() {
        return $this->fetch();
    }
    public function login()
    {
        if (request()->isAjax()) { //用于自提交   
            $captcha = $_POST['verifycode'];
            $account = $_POST['account'];
            $password = $_POST['password'];

            // $admin_id = Db::table("admins")->where('admin_account', $account)->value('admin_id');
            $admin = Db::table("admins")->where('admin_account', $account)->find();
            // return json($admin);
            // 选择班级
            $classList = Db::name("classes")->where("admin_id",$admin['admin_id'])->select();
            // return json($classList);
            $this->assign("classlist",$classList);

            // return json($res);
            // $state = Db::name('classes')->where('admin_account',$account)->value('class_state');
            if (!$admin) {
                return json("账号不存在");
                // return json($state);
            } else if ($password != $admin['admin_password']) {
                return json("密码错误");
            } else if (!captcha_check($captcha)) {
                return json("验证码错误");
            } else if ($classList) {
                \think\Session::set('class_admin', $admin);
                return json($classList);
            } 
            else {
                \think\Session::set('class_admin', $admin);
                return json("未注册辅导班");
            }
        }
        return $this->fetch();
    }
    public function register()
    {
        return $this->redirect('register/index');
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
}

