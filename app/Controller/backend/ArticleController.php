<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/25
 * Time: 11:30
 */

namespace app\Controller\backend;
use app\Model\CategoryModel;
use app\Model\ArticleModel;
use vendor\Pager;
class ArticleController extends \core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->denyAccess();
    }

    public function index ()
    {
           $obj = CategoryModel::getModel();
           $obj1 = ArticleModel::getModel();
           $where = "2>1";
           $category = isset($_REQUEST['category'])? $_REQUEST['category'] : 0;
           if ($category) {
               $where.= " AND `article`.`category_id` = {$category}";
           }
           $status = isset($_REQUEST['status'])? $_REQUEST['status'] : 0;
           if ($status) {
               $where.= " AND `article`.`status` = {$status}";
           }
           $istop = isset($_REQUEST['istop'])? $_REQUEST['istop'] : 0;
           if ($istop) {
               $where.= " AND `article`.`top` = 1";
           }
           $search = isset($_REQUEST['search'])? $_REQUEST['search'] : '';
           if ($search) {
               $where.= " AND `article`.`title` LIKE '%{$search}%'";
           }
           $pagesize = 2;
           $page = isset($_GET['page'])? $_GET['page'] : 1;
           $pager = new pager($obj1->findCount($where), $pagesize, $page, 'index.php', array(
               'p' => 'backend',
               'c' => 'Article',
               'a' => 'index',
               'category' => $category,
               'status' => $status,
               'istop' => $istop,
               'search' => $search,
           ));
           $pagerButtons = $pager->showPage();
           $start = ($page - 1) * $pagesize;
            $articles = $obj1->findAllWithJoin($where, $start, $pagesize);
            $categories = $obj->limitlessLevelCategory($obj->findAll());
            //print_r($categories);die;
            $this->loadHtml('article/index', array(
                'articles' => $articles,
                'categories' => $categories,
                'pagerButtons' => $pagerButtons,
                'category' => $category,
                'status' => $status,
                'istop' => $istop,
                'search' => $search,
                'page' => $page,
            ));
    }
    public function add ()
    {
        $obj = CategoryModel::getModel();
        $obj1 = ArticleModel::getModel();
        if(empty($_POST)) {
            $categories = $obj->findAll();
            $categories = $obj-> limitlessLevelCategory($categories);
            $this->loadHtml('article/add', array(
               'categories' => $categories,
            ));
            } else {
                //var_dump($_POST);die;
            if($obj1->add(array(
                'title' => $_POST['Title'],
                'content' => $_POST['Content'],
                'category_id' => $_POST['CateID'],
                'status' => $_POST['Status'],
                'user_id' => $_SESSION['user']['id'],
                'top' => isset($_POST['isTop'])? 1 : 0,
                'date' => strtotime($_POST['PostTime']),
                ))) {
                $this->redirect('添加成功', '?p=backend&c=Article&a=index');
            }else {
                $this->redirect('添加失败', '?p=backend&c=Article&a=add');
            }

        }
    }
    public function delete ()
    {
        $id = $_GET['id'];
        $obj = ArticleModel::getModel();
        if ($obj->deleteById($id)) {
            $this->redirect('删除成功', '?p=backend&c=Article&a=index');
        } else {
            $this->redirect('删除失败,请重试', '?p=backend&c=Article&a=index');
        }
    }
    public function update ()
    {
        $obj = CategoryModel::getModel();
        $obj1 = ArticleModel::getModel();
        $id = $_GET['id'];
       if(empty($_POST)) {
           $article = $obj1->findById($id);
           $categories = $obj->limitlessLevelCategory($obj->findAll());
           $this->loadHtml('article/update', array(
               'article' => $article,
               'categories' => $categories,
           ));
       }else {
           if (empty($_POST['Title'])) {
               return $this->redirect('标题不能为空', '?p=backend&c=Article&a=update');
           }
           $flag = $obj1->updateById($id,array(
               'title' => $_POST['Title'],
               'content' => $_POST['Content'],
               'category_id' => $_POST['CateID'],
               'status' => $_POST['Status'],
               'user_id' => $_SESSION['user']['id'],
               'top' => isset($_POST['isTop'])? 1 : 0,
               'date' => strtotime($_POST['PostTime']),
           ));
           if($flag === 1 || $flag === 0) {
               $this->redirect('修改成功', '?p=backend&c=Article&a=index');
           }else {
               $this->redirect('修改失败', '?p=backend&c=Article&a=add');
           }
       }
    }
}