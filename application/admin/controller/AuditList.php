<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class Auditlist extends Controller
{
    public function index()
    {
        $admin = \think\Session::get('super_admin');
        // $res = Db::query("select * from classes c, types t, classify y where c.class_state <> 1 and c.type_id = t.type_id and t.classify_id = y.classify_id");
        // return json($res);
        $res = Db::name('classes')
                    ->alias('c')
                    ->join('admins a','c.admin_id = a.admin_id')
                    ->select();
        $this->assign('class',$res);
        $this->assign('super_admin',$admin);
        return $this->fetch();
    }
    public function getAuditList() {
        $limit = $_GET['limit'];
        $page = $_GET['page'];
        // $res = Db::query("select * from classes c, types t, classify y where c.class_state <> 1 and c.type_id = t.type_id and t.classify_id = y.classify_id");
        $res = Db::name('classes')
                    ->alias('c')
                    ->join('types t','c.type_id = t.type_id')
                    ->join('classify y','t.classify_id = y.classify_id')
                    ->join('admins a','c.admin_id = a.admin_id')
                    ->where('c.class_state','<>',1)
                    ->page($page,$limit)
                    ->select();
        $count = Db::name('classes')->where('class_state','<>',1)->count();
        // $this->assign("class",$res); 
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
    public function reject($class_id) {
        $res = Db::name('classes')->where('class_id',$class_id)->update(['class_state' => '2']);
        if($res) {
            return json("操作成功");
        }
        else {
            // return json("冻结失败");
            return json("该俱乐部已被冻结,请勿重复操作");
        }
    }
}