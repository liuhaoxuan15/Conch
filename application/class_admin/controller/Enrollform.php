<?php
namespace app\class_admin\controller;

use think\Controller;
use think\Db;

class Enrollform extends Controller
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

    public function getEnrollList()
    {
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $class_id = $classInfo[class_id];
        $res = Db::name("enrollform")
                    ->alias('e')
                    ->join('users u','u.user_id = e.user_id')
                    ->where('class_id', $class_id)
                    ->page($page,$limit)
                    ->select();
        $count = Db::name("enrollform")->where('class_id', $class_id)->count();
        $this->assign("TList", $res);
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code' => 0, 'count' => $count, 'data' => $res]);
    }

    public function remarks($enrollForm_id,$remarks){
        $res = Db::name('enrollform')->where('enrollForm_id',$enrollForm_id)->update(['remarks'=>$remarks]);
        if($res){
            $res1 = Db::name('enrollform')->where('enrollForm_id',$enrollForm_id)->update(['hascontect'=>1]);
            return json("添加备注成功");
        } else {
            return json("添加备注失败");
        }
    }

    public function del($enrollForm_id){
        $res = Db::name('enrollform')->delete($enrollForm_id);
        if($res){
            return json("删除成功");
        } else {
            return json("删除失败");
        }
    }

    public function pass($enrollForm_id){
        $res = Db::name('enrollform')->where('enrollForm_id',$enrollForm_id)->update(['hascontect'=>1]);
        if($res){
            return json("操作成功");
        } else {
            return json("操作失败");
        }
    }
    public function logout() {
        \think\Session::delete('class_admin');
        return $this->redirect('login/index');
    }
}

