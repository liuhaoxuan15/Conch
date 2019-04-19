<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class UserList extends Controller
{
    public function index()
    {
        $admin = \think\Session::get('super_admin');
        // return json($res);
        $this->assign('super_admin',$admin);
        return $this->fetch();
    }
    public function getUserList() {
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $res = Db::table('users')->page($page,$limit)->select();
        // $res = Db::name("teachers")->page($page,$limit)->select();
        // $count = Db::name('teachers')->count();
        $count = count($res);
        
        $this->assign("UserList", $res);
        // $listres = $list->append('[$res]')->toJson();
        // dump($res);
        return json(['code' => 0, 'count' => $count, 'data' => $res]);
    }
    public function ice($user_id) {
        $res = Db::name('users')->where('user_id',$user_id)->update(['user_state' => '0']);
        // 
        if($res) {
            return json("冻结成功");
        }
        else {
            // return json("冻结失败");
            return json($res);
        }
    }
    public function pass($user_id) {
        $res = Db::name('users')->where('user_id',$user_id)->update(['user_state' => '1']);
        // 
        if($res) {
            return json("操作成功");
        }
        else {
            // return json("冻结失败");
            return json($res);
        }
    }
}