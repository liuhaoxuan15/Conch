<?php
namespace app\class_admin\controller;
use think\Controller;
use think\Db;
class Teacher extends Controller
{
    public function index()
    {
        $class = \think\Session::get('class_admin');
        $class_id = $class[class_id];
        $classInfo = Db::name('classes')->where('class_id',$class_id)->find();
        $this->assign("class",$classInfo);  
        return $this->fetch();
	}

}