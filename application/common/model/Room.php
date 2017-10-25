<?php
namespace app\common\model;
use think\Model;

/**
 * 房间模型类
 *
 */
class Room extends Model
{
  public function User ()
    {
    	return $this->belongsTo('User');
    }
}


?>
