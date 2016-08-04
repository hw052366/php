<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25
 * Time: 11:31
 */

namespace app\Model;


class ArticleModel extends \core\Model
{
      public static $table = 'article';
      public  function getStatusLabel()
      {
            if($this->status == 1) {
                return '草稿';
            } else if ($this->status == 2) {
                  return '公开';
            } else if ($this->status == 3) {
                  return '隐藏';
            }
      }

      /**
       * @param string $where
       * @param bool $start
       * @param bool $pagesize
       * @return mixed
       */
      public function findAllWithJoin ($where = '2>1', $start = false, $pagesize = false)
      {
            $sql = "SELECT `article`.*, `category`.`name` AS category_name, `user`.`name` AS user_name, count(`comment`.`id`) AS comment_count
                FROM `article`
                LEFT JOIN `category` ON `article`.`category_id`=`category`.`id`
                LEFT JOIN `user` ON `article`.`user_id`=`user`.`id`
                LEFT JOIN `comment` ON `article`.`id` = `comment`.`article_id`
                where {$where} GROUP BY `article`.`id`";
            if ($start !== false) {
                  $sql .= " LIMIT {$start} , {$pagesize}";
            }
            //echo $sql;die;
            $articles = $this->getAll($sql);
            // 提取所有文章的第一张图片
            $pregex = "/\"([https|http]+\:.+?)\"/i";
            foreach($articles as $article) {
                  $matchs = array();
                  preg_match($pregex, $article->content, $matchs);
                  $firstImageUrl = "";
                  if (isset($matchs[1])) {
                        $firstImageUrl = $matchs[1];
                  }
                  $article->firstImageUrl = $firstImageUrl;
            }
            return $articles;
      }
      public function findOneWithJoinById($id)
      {
            $sql = <<<SQL
                   SELECT `article`.*, `category`.`name` AS category_name, `user`.`name` AS user_name, count(`comment`.`id`) AS comment_count
                FROM `article`
                LEFT JOIN `category` ON `article`.`category_id`=`category`.`id`
                LEFT JOIN `user` ON `article`.`user_id`=`user`.`id`
                LEFT JOIN `comment` ON `article`.`id` = `comment`.`article_id`
                where `article`.`id` = '{$id}'
                 GROUP BY `article`.`id`;
SQL;
            return $this->getOne($sql);

      }
    public function addReadCount($id)
    {
        $sql = <<<SQL
          UPDATE `article` SET `read_count` = `read_count` + 1 WHERE id={$id}
SQL;
          return $this->exec($sql);
    }
    public function addGoodCount ($id)
    {
        $sql = <<<SQL
       UPDATE `article` SET `good` = `good` + 1,flag = 1 WHERE `id` = {$id}
SQL;
       return $this->exec($sql);
    }
    public function deleteGoodCount ($id)
    {
        $sql = <<<SQL
       UPDATE `article` SET `good` = `good` - 1,flag =0  WHERE `id` = {$id}
SQL;
        return $this->exec($sql);
    }
}