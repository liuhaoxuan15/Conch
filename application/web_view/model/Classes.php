<?php
namespace app\web_view\model;

use think\Model;

class Classes extends Model
{
    public function types()
    {
        return $this->belongsTo('types');
    }
    public function classify()
    {
        return $this->belongsTo('classify');
    }
}
