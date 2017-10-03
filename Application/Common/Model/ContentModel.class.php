<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/8/26
 * Time: 09:18
 */
namespace Common\Model;

use Think\Model;

class ContentModel extends Model
{

    protected $tableName = 'news';

    private $_db = '';

    public function __construct()
    {
        parent::__construct();
        $this->_db = M('news');
    }
//
//
    public function getContents($data = array())
    {
        $condition = $data;
        if (isset($data['title']) && $data['title']) {
            $condition['title'] = array('like', '%' . $data['title'] . '%');
        }
        if (!$data['catid']) {
            unset($condition['catid']);
        }

        $condition['status'] = array('neq', -1);
        $res = $this->_db->where($condition)->order('listorder desc,catid desc')->select();


        return $res;
    }


    public function updateListorderById($menu_id, $newListorder)
    {

        if (!is_numeric($menu_id) || !is_numeric($newListorder)) {
            return 0;
        }

        $data = array('listorder' => $newListorder);

        return $this->_db->where('news_id = ' . $menu_id)->save($data);
    }

    public function getNewsByIdIn($newsIds = array())
    {
        if (!is_array($newsIds) || !$newsIds) {
            return 0;
        }

        $data = array(
            'news_id' => array('in', implode(',', $newsIds))
        );

        return $this->_db->where($data)->select();
    }


    public function insert($data = array())
    {
        if (!is_array($data) || !$data) {
            return 0;

        }
        $data['create_time'] = time();
        $data['username'] = getAdminUsername();

        return $this->_db->add($data);

    }

    public function setStatusById($id)
    {
        if (!is_numeric($id) || !$id) {
            return 0;
        }
        return $this->_db->where('news_id=' . $id)->delete();
    }

    public function getNewsById($news_id)
    {
        if (!is_numeric($news_id) || !$news_id) {
            return 0;
        }

        return $this->_db->where('news_id=' . $news_id)->find();
    }

    public function updateById($news_id, $data = array())
    {
        if (!is_numeric($news_id) || !$news_id) {
            return 0;
        }

        if (!is_array($data) || !$data) {
            return 0;
        }
        $data['update_time'] = time();

        return $this->_db->where('news_id=' . $news_id)->save($data);
    }

    //查询首页右侧新闻排行的新闻信息
    public function getRankNews()
    {
        $data['status'] = array('neq', -1);

        return $this->_db->where($data)->order('count desc')->limit(0, 4)->select();

    }

    public function getNews()
    {
        $data['status'] = array('neq', -1);
        return $this->_db->where($data)->order('count desc')->select();
    }

    public function getCountById($news_id)
    {
        if (!is_numeric($news_id) || !$news_id) {
            return 0;
        }

        return $this->_db->where('news_id=' . $news_id)->field('count')->find();
    }

    public function getTitleById($news_id)
    {
        if (!is_numeric($news_id) || !$news_id) {
            return 0;
        }

        return $this->_db->where('news_id=' . $news_id)->field('title')->find();
    }


    public function updateCountById($news_id, $count)
    {
        if (!is_numeric($news_id) || !$news_id) {
            return 0;
        }

        $data['count'] = $count;

        return $this->_db->where('news_id=' . $news_id)->save($data);
    }

    public function getNewsByCatId($catID)
    {
        if (!is_numeric($catID) || !$catID){
            return 0;
        }

        $data['status'] = array('neq',-1);
        $data['catid'] = $catID;

        return $this->_db->where($data)->select();
    }

}


