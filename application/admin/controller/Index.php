<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class index extends Controller
{
    public function index()
    {
    	// // $clubs = Db::query('select * from club_club');
        // // $this->assign("clubs",$clubs);
        // $class = \think\Session::get('class_admin');
        // $class_id = $class[class_id];
        // $classInfo = Db::name('classes')->where('class_id',$class_id)->find();
        // $this->assign("class",$classInfo);  
        // echo 123;
        return $this->fetch();
	}
}