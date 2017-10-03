<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/18
 * Time: 15:50
 */

namespace Admin\Model;

use Think\Model;

class AdminModel extends Model
{

//    创建数据库对象
    private $_db = '';

    //不用主动调用,在创建AdminModel的第一个对象时,自动执行
    function __construct()
    {
        $this->_db = M('admin');
    }

    public function getAdminByUsername($username)
    {
        $res = $this->_db->where("username = '$username'")->find();
        return $res;
    }

    public function getAdmins()
    {
        $res = $this->_db->select();

        return $res;
    }



}