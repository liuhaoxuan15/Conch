<?php
namespace app\class_admin\controller;
use think\Controller;
use think\Db;
class index extends Controller
{
    public function index()
    {
    	// $clubs = Db::query('select * from club_club');
    	// $this->assign("clubs",$clubs);
        return $this->fetch();
	}

}