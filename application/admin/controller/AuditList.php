<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class Auditlist extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function getAuditList() {
        $res = Db::name("classes")->where("class_state","<>","1")->select();
        $count = Db::name('classes')->where("class_state","<>","1")->count();
        $this->assign("class",$res); 
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code'=>0,'count'=>$count,'data'=>$res]);
    }
    public function pass($class_id) {
        $res = Db::name('classes')->where('class_id',$class_id)->update(['class_state' => '1']);
        if($res) {
            return json("审核通过");
        }
        else {
            // return json("冻结失败");
            return json($res);
        }
    }
}