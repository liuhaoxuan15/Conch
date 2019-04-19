<?php
namespace app\web_view\controller;

use think\Controller;
use think\Db;
use app\web_view\model\Classify;
use app\web_view\model\Types;

class Home extends Controller
{
    public function index()
    {
        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $user = \think\Session::get('user');
            $this->assign("login_user", $user);
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
        // return json($array);

        // banner图 和 广告栏
        $banner = Db::name("ad")->where('ad_type', 0)->where('ad_state', 1)->order('ad_sort desc')->select();
        $right_sidebar = Db::name("ad")->where('ad_type', 1)->where('ad_state', 1)->find();
        $this->assign('right_sidebar', $right_sidebar);
        $this->assign('banner', $banner);

        // 语言培训
        $classify1_type = Db::name('types')->where('classify_id', 1)->select();
        $this->assign('classify1_type', $classify1_type);
        // return json($res);
        $classify1_classes = Db::name('types')
            ->alias('t')
            ->join('classes c', 'c.type_id = t.type_id')
            ->where('t.classify_id = 1')
            ->where('c.class_state', 1)
            ->select();
        if ($classify1_classes) {
            $array1 = array();
            foreach ($classify1_classes as $classify1_class) {
                $res = Db::name('evaluation')->where('class_id', $classify1_class['class_id'])->select();
                $score_num1 = count($res);
                if ($score_num1 != 0) {
                    $xg_avg = 0;
                    $hj_avg = 0;
                    $sz_avg = 0;
                    foreach ($res as $score) {
                        $xg_avg = $xg_avg + $score['score_xg'];
                        $hj_avg = $hj_avg + $score['score_hj'];
                        $sz_avg = $sz_avg + $score['score_sz'];
                    }
                    $score_xg = round(($xg_avg / $score_num1), 1);
                    $score_sz = round(($sz_avg / $score_num1), 1);
                    $score_hj = round(($hj_avg / $score_num1), 1);
                    $this->assign([
                        'score_xg' => $score_xg,
                        'score_sz' => $score_sz,
                        'score_hj' => $score_hj
                    ]);
                } else {
                    $score_xg = -1;
                    $score_sz = -1;
                    $score_hj = -1;
                }
                
                $classify1_class['score_xg'] = $score_xg;
                $classify1_class['score_sz'] = $score_sz;
                $classify1_class['score_hj'] = $score_hj;
                array_push($array1, $classify1_class);
            }

        }
        $this->assign('classify1_classes',$array1);


        // 音乐培训
        $classify2_type = Db::name('types')->where('classify_id', 2)->select();
        $this->assign('classify2_type', $classify2_type);
        // return json($res);
        $classify2_classes = Db::name('types')
            ->alias('t')
            ->join('classes c', 'c.type_id = t.type_id')
            ->where('t.classify_id = 2')
            ->where('c.class_state', 1)
            ->select();
        if ($classify2_classes) {
            $array2 = array();
            foreach ($classify2_classes as $classify2_class) {
                $res = Db::name('evaluation')->where('class_id', $classify2_class['class_id'])->select();
                $score_num2 = count($res);
                if ($score_num2 != 0) {
                    $xg_avg = 0;
                    $hj_avg = 0;
                    $sz_avg = 0;
                    foreach ($res as $score) {
                        $xg_avg = $xg_avg + $score['score_xg'];
                        $hj_avg = $hj_avg + $score['score_hj'];
                        $sz_avg = $sz_avg + $score['score_sz'];
                    }
                    $score_xg = round(($xg_avg / $score_num2), 1);
                    $score_sz = round(($sz_avg / $score_num2), 1);
                    $score_hj = round(($hj_avg / $score_num2), 1);
                    $this->assign([
                        'score_xg' => $score_xg,
                        'score_sz' => $score_sz,
                        'score_hj' => $score_hj
                    ]);
                    // $this->assign('score',$score);
                } else {
                    $score_xg = -1;
                    $score_sz = -1;
                    $score_hj = -1;
                }
                // return json($score_num2);
                $classify2_class['score_xg'] = $score_xg;
                $classify2_class['score_sz'] = $score_sz;
                $classify2_class['score_hj'] = $score_hj;
                array_push($array2, $classify2_class);
            }
        }
        $this->assign('classify2_classes', $array2);

        // 评分
        // $score = Db::name('')
        return $this->fetch();
    }

    public function logout()
    {
        \think\Session::delete('user');
        $this->redirect('home/index');
    }
}
