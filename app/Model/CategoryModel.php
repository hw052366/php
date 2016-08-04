<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/24
 * Time: 15:25
 */

namespace app\Model;


class CategoryModel extends \core\Model
{
     public static $table = 'category';
    public function limitlessLevelCategory($categories, $level = 0, $parentId = 0)
    {
        //var_dump($categories); die;
        static $limitlessCategories=array();
        foreach ($categories as $category) {
               if($category->parent_id == $parentId) {
                   $category->level =$level;
                     $limitlessCategories[] = $category;
                   $this->limitlessLevelCategory($categories, $level+1, $category->id);
               }
        }
        return  $limitlessCategories;
    }
    public function findAllWithJoin ()
    {
        $sql = <<<SQL
        SELECT `category`.*, count(`article`.`id`) as article_count
        FROM `category`
        LEFT JOIN `article` ON `category`.`id` = `article`.`category_id`
         GROUP BY `category`.`id`;
SQL;
       // echo $sql;die;
        return $this->getAll($sql);
    }
}