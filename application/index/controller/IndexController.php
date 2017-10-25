<?php
namespace app\index\controller;

use think\Controller;
use app\common\model\User;
use app\common\model\Label;
use app\common\model\Pact;
use app\common\model\Room;
use app\common\model\Sms;
use app\common\model\Groupchat;
use app\common\model\Userchat;
use app\common\model\Friend;
use app\common\model\Hx;
use app\common\model\Collect;
use app\common\model\Verify;
use app\common\model\Bill;
use think\Request;

class IndexController
{
    public static function fooke()
    {

      $Hx = new Hx;
//      return $Hx->addGroupsUser(30408908537857,'13049000001');
  $data = $Hx->groupsUser(30408908537857);
  var_dump($data);
  exit;
    echo $data[3]['owner'];

      /*
      $Room = Room::get(1);
      var_dump($Room);
      $result = json_encode($Room);
      $info = json_decode($result,true);
      echo "\n";
      var_dump($info);
      exit;
      $data = array();
      $data['room'] = $Room;
      echo $data['room']->roomName;
       */
}
}
