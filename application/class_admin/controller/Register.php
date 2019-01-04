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
        if (request()->isPost()) {
            $data = [
                'class_name'=>input('param.class_name'),
                'class_peopleNumber'=>input('param.class_peopleNumber'),
                'class_time'=>input('param.class_time'),
                'class_info'=>input('param.class_info'),
                'class_position'=>input('param.class_position'),
            ];
        }

        //存入数据库
        $res = Db::name("classes")->insert($data);
        if($res){
            return alert_success("申请成功，请耐心等待审核通过。",'index/index');
        } else {
            return alert_error("申请失败");
        }

    }
}