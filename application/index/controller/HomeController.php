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
use app\index\controller\IndexController;

/**
 * 首页控制器类
 *
 */
class HomeController extends Controller
{
    public function index()
    {
        $value = session('name');
        var_dump($value) ;
        if (!$value) {
            echo "is null";
        }
    }



    // +----------------------------------------------------------------------
    //
    //
    // | 首页
    //
    //
    // +----------------------------------------------------------------------




    // +----------------------------------------------------------------------
    // | 首页->查询
    // +----------------------------------------------------------------------





    // +----------------------------------------------------------------------
    // | 首页->创建房间
    // +----------------------------------------------------------------------



    /**
     * 首页->创建房间
     * 展示创建房间界面
     *
     * @param $user_id 用户ID
     * @param $postData 传入的房间数据
     */
    public function newRoom()
    {
        $postData = Request::instance()->param();
        $this->assign('data', $postData);
        return $this->fetch;
    }



    /**
     * 首页->创建房间->选择标签
     * 自定义标签
     *
     * @param $user_id 用户ID
     * @param $postData 传入的房间数据
     */
    public function addLabel()
    {
        $postData = Request::instance()->param();
        $this->assign('data', $postData);
        return $this->fetch;
    }



    /**
     * 首页->创建房间->添加组员
     * 群组添加组员
     *
     * @param $user_id 用户ID
     * @param $postData 传入的房间数据
     */
    public function addMember()
    {
        $postData = Request::instance()->param();
        $Hx = new Hx;
        $friendData = $Hx->showFriend($postData['user_id']);    //获取用户好友
        if ($friendData) {
            $this->assign('friendData', $postData);    //返回用户好友数据
        } else {
            $this->assign('friendData', 0);            //如果用户没有好友，则返回0
        }
        $this->assign('data', $postData);
        $this->fetch;
    }


    /**
     * 首页->创建房间->创建房间
     * 创建房间
     *
     * @param $postData 传入的房间数据
     */
    public function addRoom()
    {
        $postData = Request::instance()->param();
        $putData['user_id'] = $postData['user_id'];   //创建返回数组
        $friend = $postData['friend'];
        $label = $postData['label'];
        unset($postData['friend']);
        unser($postData['label']);
        $Room = new Room;
        if ($Room = $Room->save($postData)) {
            $Hx = new Hx;
            $groupId = $Hx->createGroups($Room->id, $postData['user_id'], $postData['brief']); //创建IM数组
            if ($groupId) {
                $putData['status'] = 1;
            } else {
                $putData['status'] = 0;   //IM群组创建失败
            }
        } else {
            $putData['status'] = 0;   //房间创建失败
        }
        $this->assign('$data', $putData);
        return $this->fetch();
    }



    // +----------------------------------------------------------------------
    // | 首页->房间简介
    // +----------------------------------------------------------------------

    /**
     * 首页->房间简介->简介首页
     * 显示房间简介(首页界面)
     *
     * @param $user_id  用户ID
     */
    public function showHome()
    {
          define(num, 10);
        $user_id = Request::instance()->param('user_id');
        $begin = Room::max('id');              //若无断点，则以表的最大ID为读取起点
        $homeData = array();                  //输出数组
        $RoomData = array();                  //输出数组->房间数组
        $k = 0;                               //做循环判断用，保证输出十个数据
        while ($k = num) {
            $Room = Room::get($begin);
            if ($Room) {                      //如果该ID对应的房间存在
                $data = array();              //
                $Data['Room'] = $Room;
                $Hx = new Hx;
                $friendArray = $Hx->groupsUser($Room->group_id);
                $count = count($friendArray);
                $friend = array();          //data内的好友数组
                $friend[] = User::get($friend[$count-1]['owner']);
                for ($i=0; $i < $count-1; $i++) {
                    $friend[] =  User::get($friend[$i]['member']);
                }
                $data['friend'] = $friend;
                $map = array('user_id' => $user_id ,'room_id' => $Room->id);
                $result = Collect::where($map)->select();
                if ($result) {
                    $data['Collect'] = 1;
                } else {
                    $data['Collect'] = 0;
                }
                $RoomData[] = $data;
                $begin --;
                $k ++;
            } else {
                $begin --;
                continue;
            }
        }
        $homeData['user_id'] = $user_id;
        $homeData['Room'] = $RoomData;
        $this->assign('data', $homeData);
    }

    /**
     * 首页->房间简介->加入房间
     * 加入房间
     *
     * @param $user_id  用户ID
     * @param $room_id  房间ID
     */
    public function joinRoom()
    {
        $user_id = Request::instance()->param('user_id');
        $room_id = Request::instance()->param('room_id');
        $putData['user_id'] = $user_id;
        $Room = Room::get($room_id);
        if ($Room) {                      //如果房间存在
            $Hx = new Hx;
            if ($Hx->addGroupsUser($Room->id, $user_id)) {   //如果添加组员成功
                $putData['status'] = 1;     //无异常
            } else {
                $putData['status'] = 0;  //添加组员失败
            }
        } else {
            $putData['status'] = 0;  //房间不存在
        }
        $this->assign('data', $putData);
        return $this->fetch();
    }


    /**
     * 首页->房间简介->查看组员
     * 查看组员信息
     *
     * @param $user_id  用户ID
     * @param $member_id  被查看者ID
     */
    public function checkMember()
    {
        $user_id = Request::instance()->param('user_id');
        $member_id = Request::instance()->param('member_id');
        $putData['user_id'] = $user_id;
        $putData['friendStatus'] = 0;       //默认好友状态为0
        $Member = User::get('member_id');
        if ($Member) {
            $Hx = new Hx;
            $friendArray = $Hx->showFriend($user_id);
            if ($friendArray) {
                if (in_array($member_id, $friendArray)) {
                    $putData['friendStatus'] = 1;       //好友状态为1
                }
                $putData['status'] = 1;     //无异常
            } else {
                $putData['status'] = 0;  //查找用户好友失败
            }
        } else {
            $putData['status'] = 0;  //用户不存在
        }
        $this->assign('memberData', $Member);  //返回用户数据
        $this->assign('data', $putData);       //返回状态数据
        return $this->fetch();
    }




    // +----------------------------------------------------------------------
    // | 首页->选项(右上角)
    // +----------------------------------------------------------------------
}
