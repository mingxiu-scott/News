<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/24
 * Time: 13:48
 */
namespace Common\Model;

use Think\Model;

class PositionContentModel extends Model {

    private $_db = '';

    public function __construct()
    {
        parent::__construct();
        $this->_db = M('position_content');
    }

    public function getPositionContents($data = array())
    {
        //title 和 position_id
        $condition = $data;
        if (isset($data['title']) && $data['title'])
        {
            $condition['title'] = array('like','%'.$data['title'].'%');
        }

        $condition['status'] = array('neq',-1);
        $res = $this->_db->where($condition)->order('listorder desc,id desc')->select();

        return $res;

    }

    public function getPositionContentById($id)
    {
        if (!is_numeric($id))
        {
            return 0;
        }

        return $this->_db->where('id='.$id)->find();
    }

    public function updateListorderById($id, $newListorder)
    {
        if (!is_numeric($id) || !is_numeric($newListorder)) {
            return 0;
        }

        $data['listorder'] = $newListorder;

        return $this->_db->where('id=' . $id)->save($data);

    }

    public function insert($data = array())
    {

//        dump($data);
        if (!is_array($data) || !$data)
        {
            throw_exception('数据不符合要求');
        }
        if ($data['create_time'])
        {
            $data['create_time'] = time();
        }

        return $this->_db->add($data);
    }

    public function updateById($id,$data = array())
    {
        if (!is_numeric($id) || !is_array($data))
        {
            return 0;
        }

        $res = $this->_db->where('id='.$id)->save($data);

        return $res;
    }

    public function getPositionById($position_id)
    {
        if (!is_numeric($position_id) || !$position_id)
        {
            return 0;
        }

        $data = array(
          'position_id' => $position_id,
            'status' =>array('neq',-1)
        );

        return $this->_db->where($data)->order('listorder desc,create_time desc')->select();
    }
}