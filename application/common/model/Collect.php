<?php
namespace app\common\model;
use think\Model;

/**
 * 收藏关系模型类
 *
 */
class Collect extends Model
{
  public function User ()
    {
    	return $this->belongsTo('User');
    }

}
