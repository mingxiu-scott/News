<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/9/4
 * Time: 16:52
 */
namespace Home\Controller;

use Think\Controller;

class DetailController extends Controller
{

    public function index()
    {
        if ($_GET) {
            $news_id = $_GET['id'];


            if ($news_id <= 0 || !$news_id){
                $this->error('id不合法');
            }

            $navs = D('Menu')->getWebSiteMenu();

            //更新阅读量
            $count = D('content')->getCountById($news_id)['count'];

            $newCount = intval($count) + 1;

            $res =D('content')->updateCountById($news_id,$newCount);

            if (!$res){
                $this->error('未知错误');
            }

            //获取新闻标题
            $title = D('content')->getTitleById($news_id);

            //获取新闻详情
            $content = D('NewsContent')->getContentById($news_id);


            //查询右侧文章排行信息
            $rank_news = D('Content')->getRankNews();
            $list_news = D('Content')->getNews();


            $result = array(
                'title' => $title['title'],
                'content' => htmlspecialchars_decode($content['content'])
            );

            $this->assign('navs',$navs);
            $this->assign('vo', $result);
        }


        $this->display();
    }


    public function error($message)
    {
        $message = $message ? $message : '系统发生错误';
        $this->assign('message',$message);
        $this->display('Index/error');
    }
}