<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/28
 * Time: 09:19
 */
namespace Admin\Controller;

use Common\Model\ContentModel;

class ImageController extends ContentModel {

    public function ajaxuploadimage()
    {
        $upload = D('UploadImage');
        //res是上传成功后图片的绝对路径
        $res = $upload->imageUpload();
        if ($res === false)
        {
            return show(0,'上传失败');
        }
        else
        {
            return show(1,'上传成功',$res);
        }
    }
}