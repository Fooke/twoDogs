<?php
namespace app\common\model;
use think\Model;

/**
 *房间标签模型类 
 *
 */

class Label extends Model
{
  public function Room ()
    {
    	return $this->belongsTo('Room');
    }
}


?>
