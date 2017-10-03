<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/21
 * Time: 17:09
 */
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class ContentController extends Controller
{
    public function index()
    {

        $data = array();
        if ($_REQUEST['title'] && isset($_REQUEST['title'])) {
            $data['title'] = $_REQUEST['title'];
        }

        if (($_REQUEST['catid'] == 0 || $_REQUEST['catid']) && isset($_REQUEST['catid'])) {
            $catId = $_REQUEST['catid'];
            $data['catid'] = $catId;
        }

        $titleValue = $_REQUEST['title'];

//        dump($data);

        $res = D('Content')->getContents($data);


        $menu = D('Menu')->getWebSiteMenu();

        $positions = D('Position')->getPositions();

        $this->assign('positions', $positions);

        $this->assign('news', $res);


        $this->assign('webSiteMenu', $menu);

        $this->assign('titleValue', $titleValue);

        $this->display();
    }


    public function listorder()
    {
        if ($_POST) {
            $listorderArray = $_POST['listorder'];
            try {
                foreach ($listorderArray as $key => $value) {
                    D('Content')->updateListorderById(intval($key), intval($value));
                }
            } catch (Exception $e) {
                return show(0, $e->getMessage());
            }
            return show(1, '更新成功');
        }
    }

    public function push()
    {
        if ($_POST) {
            if (!isset($_POST['newsIDs']) || !$_POST['newsIDs'])
            {
                return show(0, '请选择推送的文章');
            }

            $newsIDs = $_POST['newsIDs']; //数组
            $position_id = $_POST['position_id']; //数字

            $newsArray = D('Content')->getNewsByIdIn($newsIDs);

            try {
                foreach ($newsArray as $news) {
                    $data = array(
                        'position_id' => $position_id,
                        'title' => $news['title'],
                        'news_id' => $news['news_id'],
                        'thumb' => $news['thumb'],
                        'create_time' => $news['create_time'],
                        'status' => $news['status']
                    );


                    D('PositionContent')->insert($data);
                }


            } catch (Exception $e) {

                return show(0, $e->getMessage());
            }

            return show(1, '添加到推荐位成功');


        }

    }

    public function add()
    {
        if ($_POST)
        {
            if (!isset($_POST['title']) || !$_POST['title']) {
                show(0, '标题不能为空');
            }
            if (!isset($_POST['small_title']) || !$_POST['small_title']) {
                show(0, '小标题不能为空');
            }
            if (!isset($_POST['catid']) || !$_POST['catid']) {
                show(0, '请选择文章栏目');
            }
            if (!isset($_POST['copyfrom']) || !$_POST['copyfrom']) {
                show(0, '请选择文章来源');
            }
            if (!isset($_POST['title_font_color']) || !$_POST['title_font_color']) {
                show(0, '请选择标题颜色');
            }
            if (!isset($_POST['keywords']) || !$_POST['keywords']) {
                show(0, '关键字不存在');
            }
            if (!isset($_POST['content']) || !$_POST['content']) {
                show(0, '文章不存在');
            }

            if (isset($_POST['news_id']) && $_POST['news_id'])
            {
                $id = $_POST['news_id'];
                unset($_POST['news_id']);
                $newsContent['content'] = $_POST['content'];
                $result = D('Content')->updateById($id,$_POST);
                if ($result)
                {
                    $res_news_content = D('NewsContent')->updateById($id,$newsContent);

                    if ($res_news_content)
                    {
                        return show(1,'更新成功');
                    }
                    else
                    {
                        return show(1,'主表更新成功,副表更新失败');
                    }
                }
                else
                {
                    return show(0,'更新失败');
                }
            }
            $newsId = D('Content')->insert($_POST);

            if ($newsId) {
                $newsContentData['content'] = $_POST['content'];
                $newsContentData['news_id'] = $newsId;

                $cId = D('NewsContent')->insert($newsContentData);

                if ($cId) {
                    return show(1, '新增成功');
                } else {
                    return show(1, '主表插入成功,副表插入失败');
                }
            }
            else
            {
                return show(0, '新增失败');
            }
        }


        $titleFontColor = C('TITLE_FONT_COLOR');
        $this->assign('titleFontColor',$titleFontColor);
        $menus = D('Menu')->getWebSiteMenu();
        $this->assign('webSiteMenu',$menus);
        $copyfrom = C('COPY_FROM');
        $this->assign('copyfrom',$copyfrom);

        $this->display();
    }

    public function delete()
    {
        if ($_POST)
        {
            $news_id = $_POST['id'];
            $res = D('Content')->setStatusById($news_id);

            if ($res)
            {
                return show(1,'删除成功');
            }
            return show(0,'删除失败');

        }
    }

    public function edit()
    {
        if ($_POST)
        {

        }

        if ($_GET)
        {
         $news_id = $_GET['id'];
        }
        $res = D('Content')->getNewsById($news_id);
        $content =D('NewsContent')->getContentByNewsId($news_id);
        $res['content']= $content['content'];

        $this->assign('news',$res);
        $titleFontColor = C('TITLE_FONT_COLOR');
        $this->assign('titleFontColor',$titleFontColor);
        $menus = D('Menu')->getWebSiteMenu();
        $this->assign('webSiteMenu',$menus);
        $copyfrom = C('COPY_FROM');
        $this->assign('copyfrom',$copyfrom);


        $this->display();

    }


}