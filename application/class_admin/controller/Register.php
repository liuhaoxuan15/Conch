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
        if (request()->isAjax()) {
            $data = [
                'class_name'=>input('param.class_name'),
                'class_peopleNumber'=>input('param.class_peopleNumber'),
                'class_time'=>input('param.class_time'),
                'class_info'=>input('param.class_info'),
                'class_position'=>input('param.class_position'),
                'class_status'=>0,
                'account'=>input('param.account'),
                'password'=>input('param.password')
            ];
            $account = input('param.account');
        }
        $count = Db::name("classes")->where('account',$account)->count();
        // return json($count);
            if ($count == '0') {
                //存入数据库
                $res = Db::name("classes")->insert($data);
                if ($res) {
                    // dump($res);
                    // return alert_success("申请成功，请耐心等待审核通过。","index/index");
                    return json($res);
                } else {
                    return json('error');
                }
            }
            else {
                return json("该账户已存在");
            }

    }
}