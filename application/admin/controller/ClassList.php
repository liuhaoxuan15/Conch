<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class Classlist extends Controller
{
    public function index()
    {
        
        return $this->fetch();
    }
    public function getClassList() {
        $res = Db::query('select * from classes');
        $count = Db::name('classes')->count();
        $this->assign("class",$res); 
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code'=>0,'count'=>$count,'data'=>$res]);
    }
    public function ice($class_id) {
        $res = Db::name('classes')->where('class_id',$class_id)->update(['class_state' => '2']);
        if($res) {
            return json("冻结成功");
        }
        else {
            // return json("冻结失败");
            return json($res);
        }
    }
}