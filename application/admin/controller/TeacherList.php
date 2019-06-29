<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class TeacherList extends Controller
{
    public function index()
    {
        $admin = \think\Session::get('super_admin');
        // return json($res);
        $this->assign('super_admin',$admin);
        return $this->fetch();
    }
    public function getTeacherList() {
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $res = Db::table('classes')
                    ->alias('c')              
                    ->join('teachers t','t.class_id = c.class_id')
                    ->page($page,$limit)
                    ->select();
        // $res = Db::name("teachers")->page($page,$limit)->select();
        // $count = Db::name('teachers')->count();
        $count = Db::name("teachers")->count();
        
        $this->assign("TList", $res);
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code' => 0, 'count' => $count, 'data' => $res]);
    }
    public function ice($teacher_id)
    {
        $res = Db::name("teachers")->where('teacher_id', $teacher_id)->update(['teacher_state' => 0]);
        if ($res) {
            return json("冻结成功");
        }
    }
    public function pass($teacher_id)
    {
        $res = Db::name("teachers")->where('teacher_id', $teacher_id)->update(['teacher_state' => 1]);
        if ($res) {
            return json("已通过");
        }
    }
    public function logout() {
        \think\Session::delete('super_admin');
        return $this->redirect('login/index');
    }
}