<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/23
 * Time: 15:15
 */
namespace Common\Model;

use Think\Model;

class PositionModel extends Model {

    private $_db = '';

    public function __construct()
    {
        parent::__construct();
        $this->_db = M('position');
    }

    public function getPositions()
    {
        $data['status'] = array('neq',-1);

        $res = $this->_db->where($data)->order('update_time desc, status desc')->select();

        return $res;
    }

    public function insert($data = array())
    {
        if (!is_array($data) || !$data)
        {
            return 0;
        }

        $data['create_time'] = time();
        $res = $this->_db->add($data);

        return $res;
    }

    public function setStatusById($id,$status)
    {
        if (!is_numeric($id) || !is_numeric($status))
        {
            return 0;
        }

        $data['status'] = $status;
        $res = $this->_db->where('id='.$id)->save($data);

        return $res;
    }

    public function getPositionById($id)
    {
        if (!is_numeric($id))
        {
            return 0;
        }

        return $this->_db->where('id='.$id)->find();
    }

    public function updatePositionById($id,$data = array())
    {
        if (!is_numeric($id) || !is_array($data) || !$data)
        {
            return 0;
        }

        $res = $this->_db->where('id='.$id)->save($data);

        return $res;
    }

}