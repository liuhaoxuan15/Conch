<?php
namespace app\class_admin\controller;
use think\Controller;
use think\Db;
class Register extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function register() {
        if(request()->isPost()){
            $captcha = input('param.verifycode');
            $m = input('param.admin_account');
            
            $yanzheng = Db::name("smscode")->where('mobile',$m)->where('code',$captcha)->find();
            if(!$yanzheng) {
                return $this->error("验证码错误");
            } else {
                $data = [
                    'admin_account' => $m,
                    'admin_password' => input('param.admin_password'),
                ];
                $res = Db::table('admins')->insert($data);
                if($res){
                    \think\Session::set('class_admin',$data);
                    $this->success('注册成功','apply/index1');
                       // return  $this->redirect('game/index');//模板跳转
                   }else{
                       $this->error('注册失败');
                }
            }

    }
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

    public function sendMessage()
    {
        $m = input('param.m');
        $randNum = rand(0000, 9999);
        $u = '703929634';
        $p = md5('lhx1115');
        $c = input('param.c');
        $url = "http://api.smsbao.com/sms?u=" . $u . "&p=" . $p . "&m=" . $m . "&c=" . $c . $randNum;

        $isCreat = Db::name("smscode")->where('mobile', $m)->find();
        $isRegister = Db::name("admins")->where('admin_account', $m)->find();
        if($isRegister) {
            return json("该手机号已被注册");
        } else {
            $file = file_get_contents($url);
            if($file == 51) {
                return json("请输入正确的手机号");
            } else if($file == -1) {
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