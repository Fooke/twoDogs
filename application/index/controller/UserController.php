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

/**
 * 我的控制器类
 *
 */
class UserController extends Controller
{

  // +----------------------------------------------------------------------
    // | 我的
    // +----------------------------------------------------------------------

    /**
     * 我的->编辑
     * 我的信息简介
     *
     * @param $user_id 用户名id
     */
    public function index()
    {
        $id = Request::instance()->param('user_id');
        $User = User::get($id);
        if ($User) {
            return $User;
        } else {
            return 0;
        }
    }







    // +----------------------------------------------------------------------
    // | 我的->编辑
    // +----------------------------------------------------------------------

    /**
     * 我的->编辑
     * 我的信息简介
     *
     * @param $user_id 用户名id
     */
    public function myInformation()
    {
        $user_id = Request::instance()->param('user_id');
        $User = User::get($user_id);
        $putData['status'] = 1;
        $putData['user_id'] = $user_id;
        $putData['User'] = $User;
        $this->assign('data', $putData);
        return $this->fetch();
        /*
               $this->assign('image',$User->image);
               $this->assign('nickName',$User->nickName);
               $this->assign('province',$User->province);
               $this->assign('city',$User->city);
               $this->assign('brief',$User->brief);
               $this->assign('phoneNumber',$User->phoneNumber);
              */
    }

    /**
     * 我的->编辑->昵称
     * 更改昵称
     *
     * @param $user_id 用户名id
     * @param $nickName 用户名新昵称
     */
    public function changeNickNameShow()
    {
        $user_id = Request::instance()->param();
        $putData['status'] = 1;
        $putData['user_id'] = $user_id;
        $this->assign('data', $putData);
        return $this->fetch();
    }

    public function changeNickName()
    {
        $postData = Request::instance()->param();
        $User = User::get($postData['id']);
        $User->nickName = $postData['nickName'];
        if ($User->save()) {
            $putData['status'] = 1;
        } else {
            $putData['status'] = 0;
        }
        $putData['user_id'] = $postData['user_id'];
        $this->assign('data', $putData);
        return $this->fetch('myInformation');
    }


    /**
     * 我的->编辑->地区
     * 更改地区
     *
     * @param $user_id 用户名id
     * @param $province 省份
     * @param $city 城市
     * @param $area 区
     */

     public function changeAreaShow()
     {
         $user_id = Request::instance()->param();
         $putData['status'] = 1;
         $putData['user_id'] = $user_id;
         $this->assign('data', $putData);
         return $this->fetch();
     }

    public function changeArea()
    {
        $user_id = Request::instance()->param('user_id');
        $User = User::get($user_id);
            $User->province = $postData['province'];
            $User->city = $postData['city'];
            $User->area = $postData['area'];
            if ($User->save()) {
              $putData['status'] = 1;
            } else {
              $putData['status'] = 0;
            }
            $putData['user_id'] = $user_id;
            $this->assign('data', $putData);
            return $this->fetch('myInformation');
    }

    /**
     * 我的->编辑->简介
     * 更改简介
     *
     * @param $user_id 用户名id
     * @param $brief 简介
     */

     public function changeBriefShow()
     {
         $user_id = Request::instance()->param();
         $putData['status'] = 1;
         $putData['user_id'] = $user_id;
         $this->assign('data', $putData);
         return $this->fetch();
     }

    public function changeBrief()
    {
        $user_id = Request::instance()->param('user_id');
        $User = User::get($user_id);
            $User->brief = $postData['brief'];
            if ($User->save()) {
              $putData['status'] = 1;
            } else {
              $putData['status'] = 0;
            }
            $putData['user_id'] = $user_id;
            $this->assign('data', $putData);
            return $this->fetch('myInformation');
    }

    /**
     * 我的->编辑->实名信息
     * 实名认证信息
     *
     * @param $user_id 用户名id
     */
    public function showPapers()
    {
        $user_id = Request::instance()->param('user_id');
        $User = User::get($user_id);
            if ($User->papersStatus) {
              $putData['status'] = 1;
            } else {
              $putData['status'] = 0;
            }
            $putData['user_id'] = $user_id;
            $this->assign('data', $putData);
            return $this->fetch();
    }

    /**
     * 我的->编辑->头像
     * 更换头像
     *
     * @param $user_id 用户名id
     * @param $image 用户头像
     */
     public function changeImageShow()
     {
         $user_id = Request::instance()->param();
         $putData['status'] = 1;
         $putData['user_id'] = $user_id;
         $this->assign('data', $putData);
         return $this->fetch();
     }

    public function changeImage()
    {
        $file = request()->file('image');
        $user_id = Request::instance()->param('user_id');
        $User = User::get($user_id);
            if ($file) {                  //如果接收到文件
                $info = $file->move(ROOT_PATH . 'static/image');            // 移动到框架应用根目录/public/uploads/ 目录下
                if ($info) {
                    $url = 'http://   /  /uploads'.'/'.$info->getSaveName();      //完善url
                    $User->image = $url;
                    if ($User->save()) {
                      $putData['status'] = 1;
                    } else {
                      $putData['status'] = 0;
                    }
                } else {
                  $putData['status'] = 0;        // 上传失败获取错误信息
                }
            }
            $putData['user_id'] = $user_id;
            $this->assign('data', $putData);
            return $this->fetch('myInformation');
    }



    // +----------------------------------------------------------------------
    // | 我的->收藏
    // +----------------------------------------------------------------------

    /**
     * 我的->收藏
     * 收藏内容
     *
     * @param $user_id 用户名id
     */
    public function myCollect()
    {
        $postData = Request::instance()->param();
        $User = User::get($postData['id']);
        if ($User) {                                          //如果用户存在
          $map = array('user_id' => $postData['id']);         //构建查询数组
            $Collect = Collect::where($map)->select();        //获取Collect表中对应user_id的所有信息(数组)
            if ($count =count($Collect)) {                    //如果数组不为为空
              for ($i=0; $i <$count ; $i++) {                 //循环输出房间信息
                $room_id = $Collect[$i]->room_id;
                  $Room = Room::get($room_id);
                  echo $Room;
              }
            } else {
                echo 'no collect';
            }
        } else {
            echo 'no user';
        }
    }

    /**
     * 我的->收藏
     * 取消收藏
     *
     * @param $user_id 用户名id
     * @param $room_id 房间id
     */
    public function deleteCollect()
    {
        $postData = Request::instance()->param();
        $User = User::get($postData['id']);
        if ($User) {                                          //如果用户存在
          $map = array('user_id' => $postData['id'] , 'room_id' => $postData['room_id']);     //构建查询数组
            $Collect = Collect::where($map)->select();        //获取Collect表中对应信息(数组)
            if ($count =count($Collect)) {                    //如果数组不为为空
                $collect = Collect::get($Collect[0]->id);     //获取收藏对象
                if ($collect->delete()) {
                    echo 'success';
                } else {
                    echo "delete faile";
                }
            } else {
                echo 'no collect';
            }
        } else {
            echo 'no user';
        }
    }


    // +----------------------------------------------------------------------
    // | 我的->设置
    // +----------------------------------------------------------------------

    /**
     * 我的->设置->账号安全
     * 手机以及绑定账号信息
     *
     * @param $user_id 用户名id
     */
    public function accountSecurity()
    {
        $postData = Request::instance()->param();
        $User = User::get($postData['id']);
        if ($User) {
            echo $User->phoneNumber;
            if ($User->boundStatus) {
                echo 'had bound';
            } else {
                echo "no bound";
            }
        } else {
            echo 'no user';
        }
    }



    /**
     * 我的->设置->账号安全->手机号码->发送验证码
     * 发送手机验证码
     *
     * @param $phoneNumber 用户名手机
     */
    public function sendCheckNumber()
    {
        $phoneNumber = Request::instance()->param('phoneNumber');
        $data = Verify::authCode();       //发送短信验证码
        if ($data['status'] == 200) {     //200为发送成功
          $verifyData['phoneNumber'] = $phoneNumber;      //构造Verify数组
          $verifyData['checkNumber'] = $data['checkNumber'];
            if (Verify::addVerify($verifyData)) {           //如果Verify表保存成功
                echo "success";
            } else {
                echo "save faile";
            }
        } else {
            echo $data['error'];          //发送失败
        }
    }

    /**
     * 我的->设置->账号安全->手机号码
     * 更改手机号码
     *
     * @param $phoneNumber 用户名手机
     * @param $new_phoneNumber 用户名手机
     * @param $checkNumber 用户名手机
     */
    public function change_phoneNumber()
    {
        $phoneNumber = Request::instance()->param('phoneNumber');
        $new_phoneNumber = Request::instance()->param('new_phoneNumber');
        $checkNumber = Request::instance()->param('checkNumber');
        $userMap = array('phoneNumber' => $phoneNumber);    //构造user查询数组
        $verifyMap =array('phoneNumber' => $phoneNumber);   //构造Verify查询数组
        $User = User::get($userMap);
        $Verify = Verify($verifyMap);
        if ($User && $Verify) {                              //如果User和Verify对应数据都存在
          if ($Verify->checkNumber == $checkNumber) {        //如果验证码正确
              $User->phoneNumber = $new_phoneNumber;         //更改手机号码
              if ($User->save() && $Verify->delete()) {     //如果User表保存成功并且Verify对应数据删除成功
                echo "success";
              } else {
                  echo "save faile";
              }
          } else {
              echo "checkNumber not right";
          }
        } else {
            echo "no found";
        }
    }

    /**
     * 我的->设置->实名认证
     * 显示实名认证信息
     *
     * @param $id 用户名id
     */
    public function myPapers()
    {
        $postData = Request::instance()->param();
        $User = User::get($postData['id']);
        if ($User) {
            if ($User->papersStatus) {      //判断用户实名认证状态
                /*
                $this->assign('papersType',$User->papersType);
                $this->assign('trueName',$User->trueName);
                */
            } else {
                echo "no Papers";
            }
        } else {
            echo "no User";
        }
    }

    /**
     * 我的->设置->实名认证
     * 添加用户实名认证信息
     *
     * @param $id 用户名id
     * @param $papersType 证件类型
     * @param $papersNumber
     */
    public function addPapers()
    {
        $postData = Request::instance()->param();
        $User = User::get($postData['id']);
        if ($User) {
            $User->papersTypes = $postData['papersType'];
            $User->papersNumber = $postData['papersNumber'];
            $User->papersStatus = 1;
            if ($User->save()) {
                echo 'success';
            } else {
                echo 'save faile';
            }
        } else {
            echo "no User";
        }
    }


    /**
     * 我的->设置->隐私设置
     * 显示用户验证设置
     *
     * @param $id 用户名id
     */
    public function showVerify()
    {
        $id = Request::instance()->param('id');
        $User = User::get($postData['id']);
        if ($User) {
            return $User->verifyStatus;
        } else {
            echo "no User";
        }
    }


    /**
     * 我的->设置->隐私设置
     * 修改用户验证设置
     *
     * @param $id 用户名id
     */
    public function change_verify()
    {
        $id = Request::instance()->param('id');
        $User = User::get($postData['id']);
        if ($User) {
            $User->verifyStatus = !$User->verifyStatus;   //改变用户验证设置
          if ($User->save()) {                          //保存用户验证设置
            return 1;
          } else {
              echo 'save faile';
          }
        } else {
            echo "no User";
        }
    }

    // +----------------------------------------------------------------------
    // | 我的->出游保证金
    // +----------------------------------------------------------------------



    /**
     * 我的->出游保证金->当前出游保证金
     * 显示个人出游保证金
     *
     * @param $id 用户名id
     */
    public function myPromiseMoney()
    {
        $id = Request::instance()->param('id');
        $User = User::get($id);
        $data = array();
        if ($User) {
            $map = array('user_id' => $id);
            $Pact = Pact::where($map)->select();                //获取Pact查询数据
            if ($count = count($Pact)) {                        //如果Pact没有user_id对应对象
                for ($i = 0; $i < $count ; $i++) {                 //循环输出信息
                    if ($Pact[$i]->payStatus) {
                        $data[] = $Pact[$i];
                    }
                }
                if (count($data)) {                              //如果$data数组中的支付状态都为零
                    var_dump($data);
                } else {
                    echo "no Pact";
                }
            } else {
                echo "no Pact";
            }
        } else {
            echo "no User";
        }
    }

    /**
     * 我的->出游保证金->历史账单
     * 显示个人历史账单
     *
     * @param $id 用户名id
     */

    public function myBill()
    {
        $id = Request::instance()->param('id');
        $User = User::get($id);
        $data = array();
        if ($User) {
            $map = array('user_id' => $id);
            $Bill = Bill::where($map)->select();                //获取Bill查询数据
                if ($count = count($Bill)) {                        //如果Bill没有user_id对应对象
                    var_dump($Bill[0]) ;
                } else {
                    echo "no Bill";
                }
        } else {
            echo "no User";
        }
    }


    /**
     * 我的->出游保证金->历史账单(当前出游保证金)->订单信息
     * 显示订单信息
     *
     * @param $room_id 房间id
     */

    public function showOrder()
    {
        $room_id = Request::instance()->param('room_id');
        $Room = Room::get($room_id);
        $data = array();
        if ($User) {
            return $Room;
        } else {
            echo "no Room";
        }
    }



    // +----------------------------------------------------------------------
    // | 我的->推荐二狗
    // +----------------------------------------------------------------------
}
