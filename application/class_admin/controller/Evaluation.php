<?php
namespace app\class_admin\controller;

use think\Controller;
use think\Db;

class Evaluation extends Controller
{
    public function index()
    {

        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $this->assign("classInfo", $classInfo);
        $this->assign("class_admin", $class_admin);

        // 切换班级
        $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
        $this->assign("classlist",$classList);


        return $this->fetch();
    }

    public function getEvaluationList()
    {
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $class_id = $classInfo[class_id];
        $res = Db::name("evaluation")
                    ->alias('e')
                    ->join('users u','u.user_id = e.user_id')
                    ->where('e.class_id', $class_id)
                    ->page($page,$limit)
                    ->select();
        $count = Db::name("evaluation")->where('class_id', $class_id)->count();
        $this->assign("TList", $res);
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code' => 0, 'count' => $count, 'data' => $res]);
    }

    public function logout() {
        \think\Session::delete('class_admin');
        return $this->redirect('login/index');
    }
}

