<?php
namespace app\web_view\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\web_view\model\Types;
use extend\layui;
class ClassList extends Controller
{

    public function index($classify_id,$type_id)
    {

        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id',$a['user_id'])->find();
            $this->assign("login_user", $user);
        }

        // 所有分类
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
        
        // XX培训
        // XX培训下的所有类
        $classifyx_type = Db::name('types')->where('classify_id', $classify_id)->select();
        $this->assign('classifyx_type', $classifyx_type);

        // XX培训 classify
        $this_classify = Db::name('classify')->where('classify_id',$classify_id)->find();
        $this->assign('this_classify',$this_classify);

        // XX培训下的所有班级
        // $classify_classes = Db::query("select * from types t,classes c where t.classify_id = '$classify_id' and c.type_id = t.type_id");
        $classify_classes = Db::name('types')
                            ->alias('t')
                            ->join('classes c','c.type_id = t.type_id')
                            ->where('t.classify_id',$classify_id)
                            ->paginate(2,false,['var_page' => 'ify_page','type' => 'layui\Layui']);
        $ify_page = $classify_classes->render();
        $this->assign('ify_page',$ify_page);

        if ($classify_classes) {
            $array1 = array();
            foreach ($classify_classes as $classify_class) {
                $res = Db::name('evaluation')->where('class_id', $classify_class['class_id'])->select();
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

                $classify_class['score_xg'] = $score_xg;
                $classify_class['score_sz'] = $score_sz;
                $classify_class['score_hj'] = $score_hj;
                array_push($array1, $classify_class);
            }
            $this->assign('classify_classes', $array1);

        }
        // return json($array1);

        // XX类下的班级
        if($type_id != 0) {
            $type_classes = Db::name("classes")->where("type_id",$type_id)->paginate(1,false,['var_page' => 'tp_page','type' => 'layui\Layui']);
            $tp_page = $type_classes->render();
            $this->assign('tp_page',$tp_page);
            if ($type_classes) {
                $array2 = array();
                foreach ($type_classes as $type_class) {
                    $res = Db::name('evaluation')->where('class_id', $type_class['class_id'])->select();
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
                    } else {
                        $score_xg = -1;
                        $score_sz = -1;
                        $score_hj = -1;
                    }
    
                    $type_class['score_xg'] = $score_xg;
                    $type_class['score_sz'] = $score_sz;
                    $type_class['score_hj'] = $score_hj;
                    array_push($array2, $type_class);
                }
                $this->assign('type_classes',$array2);
            }
            // return json($array2);
        }


        return $this->fetch();
    }


}
