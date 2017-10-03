<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/21
 * Time: 14:28
 */
namespace Common\Model;

use Think\Model;

class MenuModel extends Model {
    private $_db = '';

    public function __construct()
    {
        parent::__construct();
        $this->_db = M('menu');
    }

    public function getAdminMenu(){

        //条件
        $condition = array(
            'status' => array('neq',-1),
            'type' => 1
        );
        $res = $this->_db->where($condition)->order('listorder desc, menu_id desc')->select();

        return $res;
    }



    //根据条件获取菜单管理内容
    public function getMenuContent($condition=array(),$pageNum = 0,$pageSize = 3)
    {


        if (!is_array($condition))
        {
            return 0;
        }

        if (!is_numeric($pageNum) || !is_numeric($pageSize))
        {
            return 0;
        }

        if (in_array(intval($condition['type']),array(0,1)) && $condition !=null)
        {
            $dataCon['type'] = intval($condition['type']);
        }



        $dataCon['status'] = array('neq',-1);


//        dump($dataCon);


        $offset = ($pageNum - 1) * $pageSize;

        $res = $this->_db->where($dataCon)->order('listorder desc, menu_id desc')->limit($offset,$pageSize)->select();

        return $res;

    }

    //获取菜单数据总行数
    public function getMenuCount($data)
    {
        if (!is_array($data))
        {
            return 0;
        }

        if (in_array(intval($data['type']),array(0,1)) && $data != null)
        {
            $dataCon['type'] = intval($data['type']);
        }

        $dataCon['status'] = array('neq',-1);

        return $this->_db->where($dataCon)->count();
    }


    //添加数据方法
    public function insert($data)
    {
        if (!$data || !is_array($data))
        {
            return 0;
        }

        $res = $this->_db->add($data);
        return $res;
    }

    public function update($data)
    {
        if (!$data || !is_array($data))
        {
            return 0;
        }
        $dataCon = array(

            'status' => $data['status']
        );
        $res = $this->_db->where('menu_id='.$data['id'])->save($dataCon);

        return $res;
    }

    //根据id获取一行数据
    public function getMenuById($menu_id)
    {
        if (!is_numeric($menu_id))
        {
            return 0;
        }

        $res = $this->_db->where('menu_id='.$menu_id)->find();

        return $res;
    }

    public function updateMenuById($menu_id,$data)
    {
//        dump($menu_id);
//        dump($data);
        if (!is_numeric($menu_id) || !is_array($data))
        {
            return 0;
        }

        $res = $this->_db->where('menu_id='.$menu_id)->save($data);

//        dump($res);
        return $res;
    }


    public function updataListorderById($menu_id,$newListorder)
    {
        if (!is_numeric($menu_id) || !is_numeric($newListorder))
        {
            return 0;
        }

        $data = array(
          'listorder' => $newListorder
        );

        $res = $this->_db->where('menu_id='.$menu_id)->save($data);

        return $res;

    }

    public function getWebSiteMenu()
    {
        $data = array(
            'status' => 1,
            'type' => 0
        );
        return $this->_db->where($data)->select();
    }

}


















