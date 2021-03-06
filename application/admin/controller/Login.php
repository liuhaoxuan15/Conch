<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Login extends Controller
{
    public function index()
    {
        if (request()->isAjax()) {//用于自提交   
            $captcha=input('param.verifycode');
            // return $captcha;
            $account = input('param.account');
            $password = input('param.password');
            $admin =Db::name("master")->where('master_account',$account)->find();
            // return json($admin);
            // return $admin;
            if (!$admin) {
                // return json("账号不存在");
                return json("账号不存在");
            }
            else if ($password!=$admin['master_password']) {
                return json("密码错误");
            }
            else if(!captcha_check($captcha)){
                return json("验证码错误");
            } 
            else {
                \think\Session::set('super_admin',$admin);
                return json("登录成功");
                // \think\Session::set('class_admin',$admin);
                $this->redirect('index/index');
            }           
        }
            return $this->fetch();	
    }
    public function register(){
        return $this->redirect('register/index');
    }
    public function show_captcha(){
        ob_clean();
        $captcha = new \think\captcha\Captcha();
        $captcha->useZh=true;
        $captcha->zhSet="1234567890qwertyuiopasdfghjklzxcvbnmQWERTUIOPASDFGHJKLZXCVBNM";
        $captcha->fontSize = 20;
        $captcha->length   = 3;
        $captcha->useNoise = false;
        return $captcha->entry();
    
    }

}