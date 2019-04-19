<?php
namespace app\web_view\model;

use think\Model;

class Classify extends Model
{
    public function types()
    {
        return $this->hasMany('types','classify_id','classify_id');
    }
    public function classes()
    {
        return $this->hasMany('classes','type_id','classify_id');
    }
}
