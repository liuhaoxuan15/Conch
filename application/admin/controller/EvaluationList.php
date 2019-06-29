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
        $res = Db::name('evaluation')->delete($evaluation_array);
        if($res){
            return json("删除成功");
        } else {
            return json("删除失败");
        }
    }
    public function logout() {
        \think\Session::delete('super_admin');
        return $this->redirect('login/index');
    }
   
}