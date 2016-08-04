<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/27
 * Time: 10:44
 */

namespace app\Controller\backend;
use app\Model\CommentModel;
use vendor\Pager;
class CommentController extends \core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->denyAccess();
    }
    public function index ()
    {
       // var_dump($_REQUEST);
        $obj = CommentModel::getModel();
        $where = '2>1';
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
        if ($search) {
            $where .= " AND `comment`.`content` LIKE '%{$search}%'";
        }
        $pagesize = 1;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page-1) * $pagesize;
        $pager = new Pager($obj->findCount($where), $pagesize, $page, 'index.php', array(
            'p' => 'backend',
            'a' => 'index',
            'c' => 'Comment',
            'search' => $search,
        ));
        $pagerHtml = $pager->showPage();
        //echo $pagerHtml;
        $comments = $obj->findAllWithJoin($where, $start, $pagesize);
        $this->loadHtml('comment/index',array(
            'comments' => $comments,
            'search' => $search,
            'pagerHtml' => $pagerHtml,
            'page' => $page,
        ));
    }
    public function delete ()
    {
        $id = $_GET['id'];
        if(CommentModel::getModel()->deleteById($id)) {
            $this->redirect('删除成功', '?p=backend&c=Comment&a=index');
        } else {
            $this->redirect('删除失败', '?p=backend&c=Comment&a=index');
        }
    }
}