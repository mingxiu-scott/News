<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/21
 * Time: 17:10
 */
namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller {
    public function index()
    {
        $res = D('Admin')->getAdmins();

        $this->assign('admins',$res);

        $this->display();
    }
}