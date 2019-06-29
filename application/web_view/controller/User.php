<?php
namespace app\web_view\controller;

use think\Controller;
use think\Db;
use app\web_view\model\Types;
class User extends Controller
{
    public function index()
    {
        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id',$a['user_id'])->find();
            $this->assign("login_user", $user);
        }

        return $this->fetch();
    }

    public function sendMessage()
    {
        $m = input('param.m');
        $randNum = rand(0000, 9999);
        $u = '703929634';
        $p = md5('lhx1115');
        $c = input('param.c');
        $url = "http://api.smsbao.com/sms?u=" . $u . "&p=" . $p . "&m=" . $m . "&c=" . $c . $randNum;

        $file = file_get_contents($url);
        $data = [
            'code' => $randNum,
            'update_time' => date('Y-m-d H-i-s')
        ];
        $res = Db::name("smscode")->where('mobile', $m)->update($data);
        return $file;

    }

    public function editPassword(){
        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id',$a['user_id'])->find();
            $this->assign("login_user", $user);
        }

        if(request()->isPost()){
            $code = input('param.verifycode');
            $user_phone = input('param.phone');
            $password = input('param.user_password');
            $res = Db::name('smscode')->where('mobile',$user_phone)->find();
            // return json($res);
            if($code != $res['code']){
                return $this->error('修改失败，验证码错误');
            } else {
                $res1 = Db::name('users')->where('user_id',$a['user_id'])->update(['user_password'=>$password]);
                if($res1) {
                    \think\Session::clear();
                    return $this->success('修改密码成功，请重新登录','login/index');
                } else {
                    return $this->error('修改失败');
                }
            }
        }
    }

    public function editInfo(){
        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id',$a['user_id'])->find();
            $this->assign("login_user", $user);
        }
        $info = '';
        $file = request()->file('user_img');
        $res = Db::name('users')->where('user_id',$a['user_id'])->find();
        if($file) {
            if($res['user_img'] != 'default.jpg'){
                unlink(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'users' .DS. $res['user_img']);
            }
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'users');
            $data = [
                'user_img' => $info->getFilename(),
                'user_name' => input('param.user_name')
            ];

        } else {
            $data = [
                'user_name' => input('param.user_name')                
            ];
        }
        $res1 = Db::name('users')->where('user_id',$a['user_id'])->update($data);
        if($res1) {
            return $this->success('修改成功');
        } else {
            return $this->error('修改失败');
        }
    }
    
    public function logout()
    {
        \think\Session::delete('user');
        $this->success('已退出','home/index');
    }
}
