<?php
namespace app\class_admin\controller;
use think\Controller;
use think\Db;
class Apply extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function index1()
    {
        if(\think\Session::has('class_admin')) {
            $class_admin = \think\Session::get('class_admin');
            $res = Db::name("classify")->select();
            $this->assign('classify',$res);
            $this->assign("class_admin",$class_admin);  
            return $this->fetch();
        } else {
            return $this->error("请登录后再申请");
        }
       
	}
    public function apply() {
        $file = request()->file('class_license');
        $img = request()->file('class_img');
        if(!$file){
            return $this->error("提交申请失败，请上传营业执照");
        }
        if(!$img){
            return $this->error("提交申请失败，请上传辅导班封面图");
        }
        if($file && $img) {
            $info1 = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'classes' . DS . 'license');
        	$info2 = $img->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'classes' . DS . 'img');
            
        }

        $class_admin = \think\Session::get('class_admin');
        // return json($class_admin);
        $admin_id = $class_admin['admin_id'];
        if(request()->isPost()){//检查传参方式是否为POST
        $data=[
            'class_name'=>input('class_name'),
            'class_position'=>input('class_position'),
            'class_phone'=>input('class_phone'),
            'class_time'=>input('class_time'),
            'class_info'=>input('class_info'),
            'class_state'=>0,
            'type_id'=>input('types'),
            'class_license' => $info1->getFilename(),
            'class_img' => $info2->getFilename(),
            'apply_time' => date("Y-m-d"),
            'admin_id'=>$admin_id,
        ];

            $res=Db::table('classes')->insert($data);

            if($res){
         	$this->success('申请成功，请耐心等待审核结果','login/index');
                // return  $this->redirect('game/index');//模板跳转
            }else{
                $this->error('申请失败');
            }
        }

    }
    public function logout(){
        // 清除session（当前作用域）
        \think\Session::delete('class_admin');
        $this->redirect('login/index');
    }
    public function getTypes($classify){
        $types = Db::name("types")->where('classify_id',$classify)->select();
        $opt = '';
        foreach($types as $key=>$val){
            $opt .= "<option value='{$val['type_id']}'>{$val['type_name']}</option>";
        }
        echo ($opt);
        // foreach ($types as $type){
        //     return json($type);
        // }
        // return json($types);
        // return json($classify);
    }
}