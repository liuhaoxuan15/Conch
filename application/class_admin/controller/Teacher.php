<?php
namespace app\class_admin\controller;

use think\Controller;
use think\Db;

class Teacher extends Controller
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

        // return json($class_admin);

        return $this->fetch();
    }

    public function GoAddTeacher()
    {
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $this->assign("classInfo", $classInfo);
        $this->assign("class_admin", $class_admin);

        // 切换班级
        $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
        $this->assign("classlist",$classList);

        return $this->fetch('teacher/add');
    }

    public function GoEdit($teacher_id)
    {
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');

        $teacher = Db::name("teachers")->where('teacher_id', $teacher_id)->find();
        $this->assign("teacherInfo", $teacher);
        $this->assign("classInfo", $classInfo);
        $this->assign("class_admin", $class_admin);
        // return json($teacher_id);
        // 切换班级
        $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
        $this->assign("classlist",$classList);

        return $this->fetch('teacher/edit');
    }

    public function getTeachersList()
    {
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $class_id = $classInfo[class_id];
        $res = Db::name("teachers")->where('class_id', $class_id)->page($page,$limit)->select();
        $count = Db::name("teachers")->where('class_id', $class_id)->count();
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

    public function add()
    {
        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $class_id = $classInfo[class_id];
        // 切换班级
        $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
        $this->assign("classlist",$classList);

        $teacher_img = "";
        $file = request()->file('teacher_img'); //手册里上传文件
        if ($file) {
            $teacher_img = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'teachers');
            //取值
            if (request()->isPost()) {
                $data = [
                    'teacher_name' => input('teacher_name'),
                    'teacher_start' => input('teacher_start'),
                    'teacher_professional' => input('teacher_professional'),
                    'teacher_info' => input('teacher_info'),
                    'teacher_img' => $teacher_img->getFilename(),
                    'class_id' => $class_id,
                    'teacher_state' => 1,
                ];
            }
            $res = Db::name("teachers")->insert($data);
            // dump($data);exit;
            if ($res) {
                $this->success("添加成功", "teacher/index");
            } else {
                $this->error("添加失败");
            }
        } else {
            $this->error("添加失败，请填写完整信息");
        }
    }

    public function edit($teacher_id)
    {

        $class_admin = \think\Session::get('class_admin');
        $admin_id = $class_admin[admin_id];
        $classInfo = \think\Session::get('class');
        $class_id = $classInfo[class_id];
        // 切换班级
        $classList = Db::name("classes")->where("admin_id",$admin_id)->select();
        $this->assign("classlist",$classList);
        $info = "";
        $file = request()->file('teacher_img'); //手册里上传文件
        // return $file;
        if ($file) {
            $res = Db::name("teachers")->where("teacher_id=$teacher_id")->find();
            $teacher_img = $res["teacher_img"];
            unlink(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'teachers' .DS. $teacher_img);
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'teachers');

            if (request()->isPOST()) {
                $data = [
                    'teacher_name' => input('teacher_name'),
                    'teacher_start' => input('teacher_start'),
                    'teacher_professional' => input('teacher_professional'),
                    'teacher_info' => input('teacher_info'),
                    'teacher_img' => $info->getFilename(),
                    // 'class_id' => $class_id,
                    // 'teacher_state' => 1,
                ];
            }
            //存入数据库;
            $res = Db::name("teachers")->where("teacher_id", $teacher_id)->update($data);
            if ($res) {
                $this->success("修改老师信息成功", 'teacher/index');
                // echo "{\"success\":\"1\"}
            } else {
                $this->error("修改老师信息失败");
                
            }
        } else {
            if (request()->isPOST()) {
                $data = [
                    'teacher_name' => input('teacher_name'),
                    'teacher_start' => input('teacher_start'),
                    'teacher_professional' => input('teacher_professional'),
                    'teacher_info' => input('teacher_info'),
                    // 'teacher_img' => $info->getFilename(),
                    // 'class_id' => $class_id,
                    // 'teacher_state' => 1,
                ];
            }
            $res = Db::name("teachers")->where("teacher_id", $teacher_id)->update($data);
            if ($res) {
                $this->success("修改老师信息成功", 'teacher/index');
                // echo "{\"success\":\"1\"}
            } else {
                $this->error("修改老师信息失败");
                
            }
        }
    }
    public function logout() {
        \think\Session::delete('class_admin');
        return $this->redirect('login/index');
    }
}

