<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class index extends Controller
{
    public function index()
    {
        $admin = \think\Session::get('super_admin');
        $this->assign('super_admin',$admin);

        // 饼图-培训下的班级数量
        $classify_num = Db::name('classify')
                        ->alias('i')
                        ->join('types t','t.classify_id = i.classify_id')
                        ->join('classes c','c.type_id = t.type_id')
                        ->select();
        // return json($classify_num);
        return $this->fetch();
	}
}