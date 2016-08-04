<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/27
 * Time: 10:46
 */

namespace app\Model;


class CommentModel extends \core\Model
{
      public static $table = 'comment';
      public function findAllWithJoin ($where = '2>1',$start = false, $pagesize = false)
      {
          $sql = "SELECT `comment`.*, a.content AS parent_content, `user`.`name` AS user_name, `article`.`title`
                FROM `comment`
                LEFT JOIN `comment` AS a ON `comment`.`parent_id`=a.`id`
                LEFT JOIN `user` ON `comment`.`user_id`=`user`.`id`
                LEFT JOIN `article` ON `comment`.`article_id`=`article`.`id`
                 where {$where}";
          if($start !== false) {
              $sql .= "  LIMIT {$start}, {$pagesize}";
          }
          //echo $sql;die;
          return $this->getAll($sql);
      }
    public function limitlessLevelComment($comments, $parentId =0)
    {
         $limitlessComments=array();
        foreach ($comments as $comment) {
            if($comment->parent_id == $parentId) {
                //$category->level =$level;
                $comment->childrens = $this->limitlessLevelComment($comments, $comment->id);
                $limitlessComments[] = $comment;
            }
        }
        return  $limitlessComments;
    }
}