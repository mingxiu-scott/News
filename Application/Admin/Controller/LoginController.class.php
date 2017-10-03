<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/18
 * Time: 10:00
 */

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function index()
    {

        if (session('adminUser'))
        {
            $this->redirect('/admin.php?c=index');
        }


        //显示与这个对应的视图文件:
        $this->display();


    }

    public function check()
    {
        $username = I('username');
        $password = I('password');

        if (!trim($username))
        {
            //用户名不能为空
            show(0,'用户名不能为空');
        }

        if (!trim($password))
        {
            //密码不能为空
            show(0,'密码不能为空');
        }

        //和数据库匹配信息
        $res = D('Admin')->getAdminByUsername($username);

        //判断结果
        if (!$res)
        {
            show(0,'该用户不存在');
        }

        if ($res['password'] != getMd5($password))
        {
            show(0,'密码错误');
        }

        session('adminUser',$res);

        show(1,'登录成功');

    }

    public function loginout(){
        session('adminUser',null);
        $this->redirect('/admin.php?c=login');
    }
}