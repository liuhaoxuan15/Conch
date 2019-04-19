<?php
namespace app\class_admin\controller;

use think\Controller;
use think\Db;
use \think\Session;

class Photos extends Controller
{
    public function index()
    {
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        // 切换班级
        $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
        $this->assign("classlist",$classList);
        $this->assign("class_admin", $class_admin);
        $this->assign("classInfo", $classInfo);
        return $this->fetch();
    }
    public function getPhotosList()
    {
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $this->assign("class_admin", $class_admin);
        $this->assign("classInfo", $classInfo);
        
        $limit = $_GET['limit'];
        $page = $_GET['page'];

        $photos = Db::name("photos")->where('class_id', $classInfo['class_id'])->page($page,$limit)->select();
        $count = Db::name("photos")->where('class_id', $classInfo['class_id'])->count();
        $this->assign('photos', $photos);
        $this->assign('count',$count);

        return json(['code' => 0, 'count' => $count, 'data' => $photos]);
    }
    public function GoAddPhoto()
    {
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
         // 切换班级
         $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
         $this->assign("classlist",$classList);
         
        $classInfo = \think\Session::get('class');
        $this->assign("classInfo", $classInfo);
        $this->assign("class_admin", $class_admin);
        return $this->fetch('photos/add');
    }
    public function add()
    {

        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');

        $file = $this->request->file('file');
        if ($file) {
            //图片存的路径
            $imgUrl= ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'classes' . DS . 'photos';
            // $imgUrl = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'classes' . DS . 'photos');
            // 移动到框架应用根目录/public/uploads/ 目录下

            $info = $file->validate(['ext' => 'jpg,png,jpeg'])->rule('uniqid')->move($imgUrl);
            
            $error = $file->getError();
            //验证文件后缀后大小
            if (!empty($error)) {
                dump($error);
                exit;
            }
            if ($info) {
                // 成功上传后 获取上传信息
                //获取图片的名字
                $imgName = $info->getFilename();
                $photo = $imgUrl . "/" . $imgName;
                $data = [
                    'photo_img' => $imgName,
                    'uploadTime' => date('Y-m-d H:i:s'),
                    'photo_state' => 1,
                    'class_id' => $classInfo['class_id']
                ];
                $res = Db::name("photos")->insert($data);
                if($res) {
                    return json(['code' => 1, 'msg' => '成功', 'data' => $data]);
                } else {
                    return json(['code' => 404, 'msg' => '失败', 'data' => '上传失败']);
                }
                // return json($data);
                //获取图片的路径
                
            } else {
                // 上传失败获取错误信息
                return $file->getError();
            }
        } else {
            $photo = '';
        }
        // if ($photo !== '') {
        //     return json(['code' => 1, 'msg' => '成功', 'data' => $res]);
        // } else {
        //     return json(['code' => 404, 'msg' => '失败', 'data' => '上传失败']);
        // }
    }

    public function del($photo_id) {
        // 删除图片
        $photo_img = Db::name("photos")->where('photo_id',$photo_id)->value('photo_img');
        if(Db::name("photos")->delete($photo_id)){
            unlink(ROOT_PATH.'public'.DS.'static'.DS.'images'. DS . 'classes' . DS . 'photos' . DS . $photo_img);               
                return json("删除成功");          
            }else{
                return json("删除失败");
            }
    }
    public function show($photo_id) {
        // 显示图片
        $photo_state = Db::name("photos")->where('photo_id',$photo_id)->value('photo_state');
        if(Db::name("photos")->update($photo_state,1)){
            // 删除图片           
                return json("修改成功");
            }else{
                return json("修改失败");
            }
    }
    public function hide($photo_id) {
        // 显示图片
        $photo_state = Db::name("photos")->where('photo_id',$photo_id)->value('photo_state');
        if(Db::name("photos")->update($photo_state,0)){
            // 删除图片           
                return json("修改成功");
            }else{
                return json("修改失败");
            }
    }
}

