<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class Auditlist extends Controller
{
    public function index()
    {
        $res = Db::name("classes")->where('class_state',0)->select();
        $this->assign("auditlist",$res); 
        return $this->fetch();
    }
    // public function ice($class_id) {
    //     $res = Db::name('classes')->where('class_id',$class_id)->update(['class_state' => '2']);
    //     if($res) {
    //         return json("冻结成功");
    //     }
    //     else {
    //         // return json("冻结失败");
    //         return json($res);
    //     }
    // }
}