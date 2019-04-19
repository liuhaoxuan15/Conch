<?php
namespace app\class_admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
class index extends Controller
{
    public function index()
    {
        
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];

        // 切换班级
        $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
        $this->assign("classlist",$classList);

        $classSession = \think\Session::get('class');
        $classInfo = Db::name('classes')->where('class_id',$classSession['class_id'])->find();
        // $classInfo = Db::name("classes")->where('admin_id',$admin_id)->find();
        $type_id = $classInfo[type_id];
        $type = Db::name("types")->where('type_id',$type_id)->find();
        $classify_id = $type[classify_id];

        $classify = Db::name("classify")->where('classify_id',$classify_id)->find();

        $classifyList = Db::name("classify")->select();
        $typesList = Db::name("types")->where('classify_id',$classify_id)->select();
        $this->assign("classifyList",$classifyList);
        $this->assign("typesList",$typesList);
        $this->assign("classify",$classify);
        $this->assign("type",$type);
        $this->assign("class_admin",$class_admin);
        $this->assign("classInfo",$classInfo);  
        return $this->fetch();
	}
    public function edit(){
        $class_admin = \think\Session::get('class_admin');
        $classInfo = \think\Session::get('class');
        $this->assign("account",$class_admin);  

        $info = '';
        $file = request()->file('class_img');
        // return $file;
        if($file) {
            $res = Db::name('classes')->where('class_id',$classInfo['class_id'])->find();
            // unlink(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'classes' .DS. 'img' .DS. $res['class_img']);
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'classes' . DS . 'img');
     
                if (input('param.class_position')!='') {
                    $data = [
                        'class_name'=>input('param.class_name'),
                        'class_time'=>input('param.class_time'),
                        'class_info'=>input('param.class_info'),
                        'class_position'=>input('param.class_position'),
                        'class_img'=>$info->getFilename(),
                        'type_id'=>input('param.types')
                    ];
                } else {
                    $data = [
                        'class_name'=>input('param.class_name'),
                        'class_time'=>input('param.class_time'),
                        'class_info'=>input('param.class_info'),
                        'class_img'=>$info->getFilename(),
                        'type_id'=>input('param.types')

                    ];
                }
                $res1 = Db::name("classes")->where('class_id',$classInfo['class_id'])->update($data);
                if($res1) {
                    $this->success("修改班级信息成功",'index/index');
                    Session::set('class_admin');
                }
                else {
                    $this->error("修改班级信息失败1");
                    // dump($this);
                }
        } else {
                if (input('param.class_position')!='') {
                    $data = [
                        'class_name'=>input('param.class_name'),
                        'class_time'=>input('param.class_time'),
                        'class_info'=>input('param.class_info'),
                        'class_position'=>input('param.class_position'),
                        'type_id'=>input('param.types')

                    ];
                } else {
                    $data = [
                        'class_name'=>input('param.class_name'),
                        'class_time'=>input('param.class_time'),
                        'class_info'=>input('param.class_info'),
                        'type_id'=>input('param.types')

                    ];
            }
            $res1 = Db::name("classes")->where('class_id',$classInfo['class_id'])->update($data);
            if($res1) {
                $this->success("修改班级信息成功",'index/index');
                Session::set('class_admin');
            }
            else {
                $this->error("修改班级信息失败2");
                // dump($this);
            }
        }


    }
    public function change() {
        $class_id = input('param.class_id');
        $class = Db::name('classes')->where('class_id',$class_id)->find();
        if($class) {
            \think\Session::set('class',$class);
            return $this->success("OK","index/index");
        } else {
            return $this->error("切换班级失败");
        }
        // return json($class_id);

    }

    public function logout() {
        \think\Session::delete('class');
        return $this->redirect('login/index');
    }
}