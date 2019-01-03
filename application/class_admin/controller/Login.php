<?php
namespace app\class_admin\controller;
use think\Controller;
use think\Db;
class Login extends Controller
{
    public function index()
    {
        if (request()->isPOST()) {//用于自提交   
            $captcha=input('verifycode');
            if(!captcha_check($captcha)){
            // echo "<script>alert('验证失败!');</script>";
                $this->error("验证码错误");
        }        
            $admin_accout = input('admin_account');
            $admin_password = input('admin_password');
            $admin =Db::name("admins")->where('admin_account',$admin_accout)->find();
                if (!$admin) {
                    $this->error("账号不存在");
                    // echo "<script>alert('账号不存在！');</script>";
    //                      return 1;
                }
                else if ($admin_password!=$admin['admin_password']) {
                    $this->error("密码错误");
                    // echo "<script>alert('密码错误!');</script>";
    //                      return 2;
                }
                
                else {
                        \think\Session::set('login_admin',$admin_accout);
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