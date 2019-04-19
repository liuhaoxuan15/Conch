<?php
namespace app\web_view\model;

use think\Model;

class Types extends Model
{
    public function classify()
    {
        return $this->belongsTo('classify');
    }
    public function classes() {
        return $this->hasMany('classes','type_id','type_id');
    }
}
