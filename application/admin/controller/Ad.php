<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use \think\Session;
use \think\Request;
class Ad extends Controller
{
    public function index()
    {
        $admin = \think\Session::get('super_admin');
        $this->assign('super_admin',$admin);
        return $this->fetch();
    }
    public function bannerAd() {
        $admin = \think\Session::get('super_admin');
        $this->assign('super_admin',$admin);


        return $this->fetch();
    }
    public function rightAd() {
        $admin = \think\Session::get('super_admin');
        $this->assign('super_admin',$admin);
        return $this->fetch();
    }

    public function getAdList() {
        // return json($type);
        $ad_type = $_GET['ad_type'];
        $limit = $_GET['curr'];
        $page = $_GET['nums'];
        $ad = Db::name("ad")->where('ad_type',$ad_type)->page($page,$limit)->select();
        $count = Db::name("ad")->where('ad_type',$ad_type)->count();
        $this->assign("count",$count);
        $this->assign("banner",$ad);
        return json(['code'=> 0, 'count' => $count, 'data' => $ad]);
    }

    public function del($ad_id) {
        // 删除图片
        $ad_img = Db::name("ad")->where('ad_id',$ad_id)->value('ad_img');
        if(Db::name("ad")->delete($ad_id)){
            unlink(ROOT_PATH.'public'.DS.'static'.DS.'images'. DS . 'banner' . DS . $ad_img);               
                return json("删除成功");          
            }else{
                return json("删除失败");
            }
    }
    public function change($ad_id) {
        $ad_state = Db::name("ad")->where('ad_id',$ad_id)->value('ad_state');
        if($ad_state == 0) {
            if(Db::name("ad")->where('ad_id',$ad_id)->update(['ad_state'=>'1'])){          
                return json("修改成功");
            }else{
                return json("修改失败");
            }
        } else {
            if(Db::name("ad")->where('ad_id',$ad_id)->update(['ad_state'=>'0'])){          
                return json("修改成功");
            }else{
                return json("修改失败");
            }
        }

    }
    public function GoAddBanner($ad_type) {  
        // return json($ad_type);
        $admin = \think\Session::get('super_admin');
        $this->assign('super_admin',$admin);
        $this->assign('ad_type',$ad_type);
        return $this->fetch('banner_ad_add');
    }
    public function addBanner($ad_type) {
        $admin = \think\Session::get('super_admin');
        // return json($admin);
        $info = '';
        $file = $this->request->file('file');
        if ($file) {
            $imgUrl= ROOT_PATH . 'public' . DS . 'static' . DS . 'images' . DS . 'banner';
            $info = $file->validate(['ext' => 'jpg,png,jpeg'])->rule('uniqid')->move($imgUrl);
            $error = $file->getError();
            if (!empty($error)) {
                dump($error);
                exit;
            }
            if ($info) {
                $imgName = $info->getFilename();
                $photo = $imgUrl . "/" . $imgName;
                $data = [
                    'ad_type' => $ad_type,
                    'ad_sort' => 0,
                    'ad_img' => $imgName,
                    'upload_time' => date('Y-m-d H:i:s'),
                    'ad_state' => 1,
                    'master_id' => $admin['master_id']
                ];
                $res = Db::name("ad")->insert($data);
                if($res) {

                    return json(['code' => 1, 'msg' => '成功', 'data' => $data]);
                } else {
                    return json(['code' => 404, 'msg' => '失败', 'data' => '上传失败']);
                }
            } else {
                return $file->getError();
            }
        } else {
            $photo = '';
        }
    }
    
    public function editSort($ad_id,$ad_sort){
        preg_match_all('/\d+/',$ad_sort,$arr);
        $arr = join('',$arr[0]);

        $res = Db::name("ad")->where('ad_id',$ad_id)->update(['ad_sort'=>$arr]);
        // return $res;
        if($res) {
            return json("修改成功");
        } else {
            return json("修改失败");
        }
    }

    public function logout() {
        \think\Session::delete('super_admin');
        return $this->redirect('login/index');
    }
}