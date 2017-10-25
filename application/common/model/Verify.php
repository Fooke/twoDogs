<?php
namespace  app\common\model;

use app\common\model\Sms;
use think\Model;

class Verify extends Model
{

  /**
   * 添加Verify对象
   *
   * @param $phoneNumber 用户名手机
   */
    public static function addVerify($data = array())
    {
        $verifyMap = array('phoneNumber' => $data['phoneNumber']);
        $Verify = Verify::get($verifyMap);        //判断表中对象是否已经存在
        if ($Verify) {                            //如果表中该phoneNUmber对应的对象已经存在
            $Verify->checkNumber = $data['checkNumber'];    //更改验证码
            $result = $Verify->save();
        } else {
            $Verify1 = new Verify;                          //创建对象
            $result = $Verify1->save($data);
        }
        if ($result) {                                     //如果保存成功
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 发送验证码
     *
     * @param $phoneNumber 用户名手机
     */
    public static function authCode($phoneNumber)
    {
        $code =rand(100000, 999999);
        //发送短信
        $Sms = new Sms();
        //测试模式
  $status = $Sms->send_verify($phoneNumber, $code);            //发送验证码

  if ($status) {                                            //如果发送成功
      $data = array();
      $data['status'] = 200;
      $data['code'] = $code;
      return    $data;        //返回状态数组
  } else {
      $data = array();
      $data['status'] = 500;
      $data['error'] = $Sms->error;
      return $data;            //返回状态数组
  }
    }
}
