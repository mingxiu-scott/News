<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/21
 * Time: 17:07
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class MenuController extends Controller {

    public function index() {

        $data = array();

        if (isset($_REQUEST['type']) && in_array($_REQUEST['type'],array(0,1)))
        {
            $data['type'] = intval($_REQUEST['type']);
            $this->assign('type',$data['type']);
        }
        else
        {
            $this->assign('type',-1);
        }

//        dump($_REQUEST['type']);

        $pageNum = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        //page get['p']
        $pageSize = 3;

//        $data['type'] = 1;

        //显示菜单管理首页数据
        $res = D('Menu')->getMenuContent($data,$pageNum,$pageSize);
        //确定页码内容
        $menuCount = D('Menu')->getMenuCount($data);
        $pageObj = new \Think\Page($menuCount,$pageSize); //page对象

        $pageString = $pageObj->show();

//        dump($res);

        //将数据发送到前端界面
        $this->assign('pageStr',$pageString);
        $this->assign('menus',$res);


        $this->display();

    }

    //add
    public function add()
    {
        if ($_POST)
        {
            if (!$_POST['name'] || !isset($_POST['name']))
            {
                return show(0,'菜单名不能为空');
            }
            if (!isset($_POST['type']))
            {
                return show(0,'菜单类型不能为空');
            }
            if (!$_POST['m'] || !isset($_POST['m']))
            {
                return show(0,'模块不能为空');
            }
            if (!$_POST['f'] || !isset($_POST['f']))
            {
                return show(0,'方法不能为空');
            }
            if (!$_POST['c'] || !isset($_POST['c']))
            {
                return show(0,'控制器不能为空');
            }
            if (!$_POST['status'] || !isset($_POST['name']))
            {
                return show(0,'状态不能为空');
            }

            $res = D('Menu')->insert($_POST);
            if ($res)
            {
                return show(1,'添加成功');
            }
            return show(0,'添加失败');
        }
        $this->display();
    }


    public function delete()
    {
        if ($_POST)
        {
            $res = D('Menu')->update($_POST);
        }
        if ($res)
        {
            return show(1,'删除成功');
        }

        return show(1,'删除失败');
    }

    public function edit()
    {
        if ($_GET)
        {
            $menu_id = $_GET['id'];
            //根据id查询
            $res = D('Menu')->getMenuById($menu_id);
            $this->assign('menu',$res);
            $this->display();
        }
    }

    public function update()
    {
        if ($_POST)
        {
            $menu_id = $_POST['menu_id'];

            //删除键值对
            unset($_POST['menu_id']);

            $res = D('Menu')->updateMenuById($menu_id,$_POST);

            if ($res)
            {
                return show(1,'更新成功');
            }

            return show(0,'更新失败');
        }
    }


    public function listorder()
    {
        if ($_POST)
        {
            $listorderArray = $_POST['listorder'];

            try{
                foreach ($listorderArray as $key =>$value)
                {
                    $res = D('Menu')->updataListorderById(intval($key),intval($value));
                }
            } catch (Exception $e)
            {
                return show(0, $e->getMessage());
            }

            return show(1,'更新成功');

        }
    }

}
























