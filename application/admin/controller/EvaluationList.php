<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class EvaluationList extends Controller
{
    public function index()
    {
        $admin = \think\Session::get('super_admin');
        // return json($res);
        $this->assign('super_admin',$admin);
        
        return $this->fetch();
    }
    public function getEvaluationList() {
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $res = Db::name('evaluation')
                ->alias('e')
                ->join('classes c','e.class_id = c.class_id')
                ->join('users u','u.user_id = e.user_id')
                ->where('e.evaluation_content','<>','')
                ->page($page,$limit)
                ->select();
        $count = count($res);
        
        $this->assign("UserList", $res);
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code' => 0, 'count' => $count, 'data' => $res]);
    }
    public function del($evaluation_array) {
        // return json($evaluation_array.length);
        $evaluation_id = '';
        $length = count($evaluation_array);
        // return json($evaluation_array[1]);
        for($i = 0; $i< $length ; $i++){
            $evaluation_id = $evaluation_array[$i];
            $res = Db::name('evaluation')->where('evaluation_id',$evaluation_id)->delete();
        }
        // 
        return json("删除成功");
    }
   
}