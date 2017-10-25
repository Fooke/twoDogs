<?php
namespace app\common\model;
use think\Model;

/**
 * 房间公约模型类
 *
 */
class Pact extends Model
{
  public function Room ()
  {
    return $this->belongsTo('Room');
  }
}


?>
