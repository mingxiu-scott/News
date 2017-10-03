<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/18
 * Time: 15:40
 *
 *
 * @param $status //状态
 * @param $message //信息
 * @param array $data
 */

//公共函数
function show($status, $message, $data = array())
{
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' =>$data
    );
    exit(json_encode($result));
}

function getMd5($str)
{
    //C()获取配置项的值
return md5($str.C('MD5_PRE'));
}

function getAdminUsername()
{
    return isset($_SESSION['adminUser']['username']) ? $_SESSION['adminUser']['username'] : '';
}

/**
 * @param $row
 * @return string
 * 获取某个菜单元素的url
 */
function getAdminUrl($row)
{
    $url = './admin.php?c='.$row['c'].'&a='.$row['f'];
    return $url;
}

//获取当前菜单的活跃状态
function getActive($conName)
{
//    CONTROLLER_NAME; //获取当前控制器的名称
//    ACTION_NAME; //获取当前方法名

    //将字符串字母全部转化为小写
    $c = strtolower(CONTROLLER_NAME);
    if ($c == strtolower($conName))
    {
        return 'class="active"';
    }
    return '';
}


//根据type返回对应的汉字名称
function getMenuType($type)
{
    return $type == 1 ? '后台模块' :($type ==0 ? '前端模块' :'');
}

function status($sta)
{
    return $sta == 1 ? '正常' : ($sta == -1 ? '关闭' :'');
}

function isThumb($thumb)
{
    if ($thumb)
    {
        return '<span style="color: red;">有</span>';
    }
    return '无';
}


function getCatName($param)
{
    return $param;
}

function getCopyFromById($webSiteMenu, $catid)
{
    for ($i = 0; $i < count($webSiteMenu); $i++){
        if ($webSiteMenu['$i']['menu_id'] == $catid){
            return   $webSiteMenu['$i']['name'];
        }
    }
}

function getCopyFormById(){
    $data = C('COPY_FROM');
    return $data;
}

