<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class Classlist extends Controller
{
    public function index()
    {
        $admin = \think\Session::get('super_admin');
        // return json($res);
        $this->assign('super_admin',$admin);
        return $this->fetch();
    }
    public function getClassList() {
        $limit = $_GET['limit'];
        $page = $_GET['page'];
        // $res = Db::query("select * from admins a, classes c, types t, classify y where c.class_state = 1 and c.type_id = t.type_id and t.classify_id = y.classify_id and c.admin_id = a.admin_id");
        $res = Db::name('admins')
                    ->alias('a')
                    ->join('classes c','c.admin_id = a.admin_id')
                    ->join('types t','c.type_id = t.type_id')
                    ->join('classify y','t.classify_id = y.classify_id')
                    ->where('c.class_state = 1')
                    ->page($page,$limit)
                    ->select();
        $count = Db::name('classes')->where('class_state',1)->count();
        // $admin = Db::name('classes')->alias('c')->join('admins a','')
        // $this->assign("class",$res); 
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code'=>0,'count'=>$count,'data'=>$res]);
    }
    public function ice($class_id) {
        $res = Db::name('classes')->where('class_id',$class_id)->update(['class_state' => '2']);
        // 
        if($res) {
            return json("冻结成功");
        }
        else {
            // return json("冻结失败");
            return json($res);
        }
    }
}