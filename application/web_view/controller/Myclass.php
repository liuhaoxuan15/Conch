<?php
namespace app\web_view\controller;
use think\Session;
use think\Controller;
use think\Db;
use app\web_view\model\Types;
class Myclass extends Controller
{

    public function index()
    {

        // Session
        $hasUser = \think\Session::has('user');
        $this->assign('hasUser', $hasUser);
        if ($hasUser) {
            $a = \think\Session::get('user');
            $user = Db::name('users')->where('user_id',$a['user_id'])->find();
            $this->assign("login_user", $user);
        }

        $isCollect = Db::name('enrollform')
                        ->alias('e')
                        ->join('users u','e.user_id = u.user_id')
                        ->join('classes l','l.class_id = e.class_id')
                        ->where('u.user_id',$user['user_id'])
                        ->paginate(3,false,['type' => 'layui\Layui']);
                        $page = $isCollect->render();
                        $this->assign('page',$page);
        if($isCollect){
            $array = array();     
            foreach($isCollect as $coClass){
                $res = Db::name('evaluation')->where('class_id', $coClass['class_id'])->select();
                $score_num = count($res);
                if($score_num != 0) {
                    $xg_avg = 0;
                    $hj_avg = 0;
                    $sz_avg = 0;
                    foreach($res as $score) {
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
                } else {
                    $score_xg = -1;
                    $score_sz = -1;
                    $score_hj = -1;
                }
                $coClass['score_xg'] = $score_xg;
                $coClass['score_sz'] = $score_sz;
                $coClass['score_hj'] = $score_hj;
                array_push($array,$coClass);
            }

            // return json($array); 
            $this->assign('collectClass',$array);
        }
        
        return $this->fetch();
    }

}
