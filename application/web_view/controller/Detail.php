<?php
namespace app\web_view\controller;

use think\Session;
use think\Controller;
use think\Db;
use app\web_view\model\Types;

class Detail extends Controller
{

    public function index($class_id)
    {
        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id', $a['user_id'])->find();
            $this->assign("login_user", $user);
            // 判断收藏
            $hasCollection = Db::name('collection')->where('user_id', $user['user_id'])->where('class_id', $class_id)->find();
            if ($hasCollection) {
                $this->assign('hasCollection', $hasCollection);
            }

            // 判断是否预约
            $hasEnrollform = Db::name('enrollform')->where('user_id', $user['user_id'])->where('class_id', $class_id)->find();
            // return json($hasEnrollform);
            if ($hasEnrollform) {
                $this->assign('hasEnrollform', $hasEnrollform);
            }
        }

        // 分类
        $classify = Db::name('classify')->select();
        // return json($classify);
        if ($classify) {
            $array = array();
            foreach ($classify as $row) {
                $type_class = Types::with('classes')->where('classify_id', $row['classify_id'])->select();
                // return json($type_class);
                $row['type'] = $type_class;
                array_push($array, $row);
            }
        }
        $this->assign('classify_type', $array);

        // 预约人数
        $enterNum = Db::name('enrollform')->where('class_id', $class_id)->count();
        $this->assign('enterNum', $enterNum);

        // 班级信息
        $class = Db::name("classes")->where("class_id", $class_id)->find();
        $this->assign('class', $class);

        // 班级分类
        $class_type = Db::name('types')->where('type_id', $class['type_id'])->find();
        $class_classify = Db::name('classify')->where('classify_id', $class_type['classify_id'])->find();
        $this->assign('class_type', $class_type);
        $this->assign('class_classify', $class_classify);

        // 班级照片
        $class_photos = Db::name('photos')->where('class_id', $class_id)->where('photo_state', 1)->select();
        if ($class_photos) {
            $this->assign('class_photos', $class_photos);
        }


        // 名师风采
        $hasTeacher = Db::name('teachers')->where('class_id', $class_id)->where('teacher_state', 1)->select();
        $teacher = Db::name('teachers')->where('class_id', $class_id)->where('teacher_state', 1)->paginate(3, true, ['var_page' => 't_page']);
        if ($hasTeacher) {
            $this->assign('class_teacher', $teacher);
            $page2 = $teacher->render();
            $this->assign('page2', $page2);
        }


        // 评价列表
        $hasEvaluation = Db::name('evaluation')
            ->alias('e')
            ->join('users u', 'e.user_id = u.user_id')
            ->where('e.class_id', $class_id)
            ->select();
        $evaluation = Db::name('evaluation')
            ->alias('e')
            ->join('users u', 'e.user_id = u.user_id')
            ->where('e.class_id', $class_id)
            ->paginate(3, false, ['var_page' => 'e_page', 'type' => 'layui\Layui']);
        if ($hasEvaluation) {
            $evpage = $evaluation->render();
            $this->assign('evpage', $evpage);
            $this->assign("evaluationList", $evaluation);
        }


        // 评分
        $scores = Db::name('evaluation')->where('class_id', $class_id)->select();
        // return json($scores); 
        $score_num = count($scores);
        if ($score_num != 0) {
            $xg_avg = 0;
            $hj_avg = 0;
            $sz_avg = 0;
            foreach ($scores as $score) {
                $xg_avg = $xg_avg + $score['score_xg'];
                $hj_avg = $hj_avg + $score['score_hj'];
                $sz_avg = $sz_avg + $score['score_sz'];
            }
            $score_xg = round(($xg_avg / $score_num), 1);
            $score_sz = round(($sz_avg / $score_num), 1);
            $score_hj = round(($hj_avg / $score_num), 1);
            $this->assign([
                'score_xg' => $score_xg,
                'score_sz' => $score_sz,
                'score_hj' => $score_hj
            ]);
            $this->assign('score', $score);
        }
        $this->assign('score_num', $score_num);


        return $this->fetch();
    }

    // 预约
    public function enter($class_id)
    {
        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id', $a['user_id'])->find();
            $this->assign("login_user", $user);
        } else {
            return $this->error("预约失败，请登录后再试");
        }
        $data = [
            'enrollForm_time' => date('Y-m-d H-i-s'),
            'class_id' => $class_id,
            'user_id' => $user['user_id'],
        ];
        $res1 = Db::name('enrollform')->where('class_id', $class_id)->where('user_id', $user['user_id'])->find();
        if ($res1) {
            return $this->error("您已预约，请勿重复预约");
        }
        $res = Db::name('enrollform')->insert($data);

        if ($res) {
            return $this->success("预约成功");
        } else {
            return $this->error("预约失败");
        }

        return json($class_id);
    }

    // 评价
    public function comment($class_id)
    {
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id', $a['user_id'])->find();

            $this->assign("login_user", $user);

            if (request()->isPost()) {
                $data = [
                    'evaluation_content' => input('param.content'),
                    'evaluation_time' => date('Y-m-d H-i-s'),
                    'user_id' => $user['user_id'],
                    'class_id' => $class_id,
                    'score_xg' => input('param.score_xg'),
                    'score_sz' => input('param.score_sz'),
                    'score_hj' => input('param.score_hj'),
                ];

                $res = Db::name('evaluation')->insert($data);
                if ($res) {
                    return $this->success("评价成功");
                } else {
                    return $this->error("评价失败");
                }
            } else {
                return json("error");
            }
        } else {
            return $this->error("评价失败，请登录后再试");
        }
    }

    // 收藏
    public function collection($class_id, $flag)
    {
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id', $a['user_id'])->find();
            $this->assign("login_user", $user);
            if ($flag == 0) {
                $res = Db::name('collection')->where('user_id', $user['user_id'])->where('class_id', $class_id)->delete();
                if ($res) {
                    return $this->success("已取消收藏");
                }
            } else {
                $data = [
                    'user_id' => $user['user_id'],
                    'class_id' => $class_id,
                    'collection_time' => date('Y-m-d H-i-s')
                ];
                $res = Db::name('collection')->insert($data);
                if ($res) {
                    return $this->success("收藏成功");
                }
            }
        } else {
            return $this->error("收藏失败，请登录后重试");
        }
    }
    // 退出
    public function logout()
    {
        // 清除session（当前作用域）
        \think\Session::delete('user');
        $this->redirect('login/index');
    }
}
