<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {

        if (!session('adminUser'))
        {
            $this->redirect('/admin.php?c=login');

        }
        //显示与这个对应的视图文件:
        $this->display();

    }
}