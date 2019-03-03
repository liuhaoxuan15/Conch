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
    
    public function GoAddTeacher(){
        return $this->fetch();
    }

    public function getTeachersList() {
        // $res = Db::query('select * from classes');
        $class = \think\Session::get('class_admin');
        $class_id = $class[class_id];
        // echo($class_id);
        $res = Db::query("select * from users u, teaching t where t.class_id = '$class_id' and t.user_id = u.user_id");
        // $res = Db::name('users')->where('user_type',1)->select();
        $count = Db::name('teaching')->where('class_id',$class_id)->count();
        $this->assign("TList",$res); 
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code'=>0,'count'=>$count,'data'=>$res]);
    }
}