<?php
namespace app\class_admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class index extends Controller
{
    public function index()
    {
    	// $clubs = Db::query('select * from club_club');
        // $this->assign("clubs",$clubs);
        $class = \think\Session::get('class_admin');
        $class_id = $class[class_id];
        $classInfo = Db::name('classes')->where('class_id',$class_id)->find();
        $this->assign("class",$classInfo);  
        return $this->fetch();
	}
    public function edit(){
        $class= \think\Session::get('class_admin');
        
        $this->assign("account",$class);  
        if(request()->isPost()){
            if (input('param.class_position')!='') {
                $data = [
                    'class_name'=>input('param.class_name'),
                    'class_peopleNumber'=>input('param.class_peopleNumber'),
                    'class_time'=>input('param.class_time'),
                    'class_info'=>input('param.class_info'),
                    'class_position'=>input('param.class_position'),
                ];
            } else {
                $data = [
                    'class_name'=>input('param.class_name'),
                    'class_peopleNumber'=>input('param.class_peopleNumber'),
                    'class_time'=>input('param.class_time'),
                    'class_info'=>input('param.class_info')
                ];
            }
        }
        // echo($class_id[class_id]);
        // echo(123);
        $res = Db::name("classes")->where('class_id',$class[class_id])->update($data);
        if($res) {
            $this->success("修改班级信息成功",'index/index');
            Session::set('class_admin');
        }
        else {
            // $this->error("修改班级信息失败");
            dump($this);
        }
    }
}