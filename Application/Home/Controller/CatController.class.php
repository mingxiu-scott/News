<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 2017/9/5
 * Time: 上午9:24
 */

namespace Home\Controller;

use Think\Controller;

class CatController extends Controller
{
    public function index()
    {
        $catID = $_GET['id'];


        //根据catid获取对应的内容
        if ($catID <= 0 || !$catID) {
            $this->error('id不合法');
        }

        $listNews = D('content')->getNewsByCatId($catID);

        $res_right_adv_news = D('PositionContent')->getPositionById(5);

        //查询右侧文章排行信息
        $rank_news = D('Content')->getRankNews();


        $result = array(
            'listNews' => $listNews,
            'rankNews' => $rank_news,
            'advNews' => $res_right_adv_news,
            'catId' => $catID
        );

        $this->assign('result', $result);

        $this->display();
    }

    public function error($message)
    {
        $message = $message ? $message : '系统发生错误';
        $this->assign('message', $message);
        $this->display('Index/error');
    }
}


