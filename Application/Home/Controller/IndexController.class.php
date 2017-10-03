<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
        $navs = D('Menu')->getWebSiteMenu();

        //获取栏目
        $this->assign('navs',$navs);

        //获取首页大图新闻信息
        $res_top_pic_news =D('PositionContent')->getPositionById(2);
        $res_right_pic_news =D('PositionContent')->getPositionById(3);
        $res_right_adv_news =D('PositionContent')->getPositionById(5);

        //查询右侧文章排行信息
        $rank_news = D('Content')->getRankNews();

        $list_news = D('Content')->getNews();

        $count = D('Content')->getCountById($res_top_pic_news[0]['news_id']);

        $result = array(
          'topPicNews' => $res_top_pic_news,
          'topSmallNews' => $res_right_pic_news,
          'advNews' => $res_right_adv_news,
            'rankNews' =>$rank_news,
            'listNews' => $list_news,
            'count' => $count['count']
        );


        $this->assign('result',$result);
        $this->display();

    }
}