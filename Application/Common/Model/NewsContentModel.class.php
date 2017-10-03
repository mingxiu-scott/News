<?php
/**
 * Created by PhpStorm.
 * User: liyao
 * Date: 2017/9/4
 * Time: 09:42
 */
namespace Common\Model;

use Think\Model;

class NewsContentModel extends Model {
    private $_db = '';

    public function __construct()
    {
        parent:: __construct();
        $this->_db = M('news_content');
    }

    public function insert($data = array())
    {
        if (!is_array($data) || !$data)
        {
            return 0;
        }

        $data['create_time'] = time();
        if (isset($data['content']) && $data['content'])
        {
            $data['content'] = htmlspecialchars($data['content']);
        }

        return $this->_db->add($data);
    }

    public function getContentByNewsId($news_id)
    {
        if (!is_numeric($news_id) || !$news_id)
        {
            return 0;
        }

        return $this->_db->where('news_id='.$news_id)->find();
    }

    public function updateById($news_id,$data=array())
    {
        if (!is_numeric($news_id) || !$news_id)
        {
            return 0;
        }
    }

    public function getContentById($news_id)
    {
        if (!is_numeric($news_id) || !$news_id)
        {
            return 0;
        }

        return $this->_db->where('news_id='.$news_id)->field('content')->find();
    }


}