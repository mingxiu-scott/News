<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/21
 * Time: 17:10
 */
namespace Admin\Controller;

use Think\Controller;

class PositionContentController extends Controller {

    public function index()
    {
        $data = array();
        if (isset($_REQUEST['title']) && $_REQUEST['title'])
        {
            $data['title'] = $_REQUEST['title'];
        }

//        dump($data['title']);
        $position_id = isset($_REQUEST['position_id']) ? $_REQUEST['position_id'] : 2;
        $data['position_id'] = $position_id;
        $res = D('PositionContent')->getPositionContents($data);

        $this->assign('positionId',$position_id);
        $this->assign('title',$data['title']);
        $this->assign('contents',$res);


       $positions = D('Position')->getPositions();
        $this->assign('positions',$positions);
        $this->display();
    }

    public function edit()
    {
        if ($_GET)
        {
            $id = $_GET['id'];
            $res = D('PositionContent')->getPositionContentById($id);
            $this->assign('vo',$res);
            $positions = D('Position')->getPositions();
            $this->assign('positions',$positions);
        }

        $this->display();
    }

    public function update()
    {
        if ($_POST) {
            $id = $_POST['id'];

            unset($_POST['id']);

            $res = D('PositionContent')->updateById($id, $_POST);

            if ($res) {
                show(1, '更新成功');
            }
            show(0, '更新失败');
        }

    }

    //更新排序
    public function listorder()
    {
        if ($_POST) {

            $listorder = $_POST['listorder'];

            try {
                foreach ($listorder as $key => $value) {
                    D('PositionContent')->updateListorderById(intval($key), intval($value));
                }
            } catch (Exception $e) {

                show(0, $e->getMessage());
            }
            show(1, '更新排序成功');
        }
    }

    //添加
    public function add()
    {
        if($_POST)
        {
            if(!$_POST['position_id'] || !isset($_POST['position_id']))
            {
                show(0,'推荐位ID不能为空');
            }
            if(!$_POST['title'] || !isset($_POST['title']))
            {
                show(0,'推荐位标题不能为空');
            }

            if(!$_POST['thumb'] || !isset($_POST['thumb']))
            {
                show(0,'必须上传封面图片');
            }
            if(!$_POST['url'] && !isset($_POST['']))
            {
                show(0,'url和文章ID不能为空');
            }
            if(!$_POST['status'] )
            {
                show(0,'状态值不能为空不能为空');
            }
            $res = D('PositionContent')->insert($_POST);
            if($res)
            {
                return show(1,'添加成功');
            }
            return  show(0,'添加失败');

            $positions = D('Position')->getPositions();
            $this->assign('positions',$positions);


        }

        $positions = D('Position')->getPositions();

        $this->assign('positions',$positions);


        $this->display();
    }



}