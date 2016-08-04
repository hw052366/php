<?php
namespace app\Controller\frontend;
use core\Controller;
use app\Model\ArticleModel;
use app\Model\CategoryModel;
use vendor\Pager;
use app\Model\CommentModel;
use vendor\Captcha;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/30
 * Time: 10:54
 */
class ArticleController extends Controller
{
    public function index ()
    {
       // var_dump($_GET);die;
        $where = '2>1';
        $search = isset($_REQUEST['search'])? $_REQUEST['search'] : '';
        if($search) {
            $where .= "  AND `article`.`content` LIKE '%{$search}%'";
        }
        $category_id = isset($_REQUEST['category_id'])? $_REQUEST['category_id'] : 0;
        if($category_id) {
            $where .= " AND `article`.`category_id` = $category_id";
        }
        $pagesize = 2;
        $page = isset($_GET['page'])? $_GET['page'] : 1;
        $pager = new pager(ArticleModel::getModel()->findCount($where), $pagesize, $page, 'index.php', array(
            'p' => 'frontend',
            'c' => 'Article',
            'a' => 'index',
           // 'page' => $page,
            'search' => $search,
            'category_id' => $category_id,
        ));
        $pagerButtons = $pager->showPage();
        $start = ($page-1) * $pagesize;
        $articles = ArticleModel::getModel()->findAllWithJoin($where, $start, $pagesize);
         //print_r($articles);die;
        $categories = CategoryModel::getModel()->limitlessLevelCategory(CategoryModel::getModel()->findAllWithJoin());
        $this->s->assign(array(
            'articles' => $articles,
            'categories' => $categories,
            'pagerButtons' => $pagerButtons,
            'page' => $page,
            'search' => $search,
            'category_id' => $category_id,
        ));
        $this->s->display(PLATFORM ."/article/index.html");
    }
    public function content ()
    {
        $id = $_GET['id'];
        $obj = ArticleModel::getModel();
        $obj1 = CommentModel::getModel();
        $obj->addReadCount($id);
        $article = $obj->findOneWithJoinById($id);
        $comments = $obj1->findAllWithJoin("`comment`.`article_id`= {$id}");
        $comments = $obj1->limitlessLevelComment($comments);
        $this->s->assign(array(
            'article' => $article,
            'comments' => $comments,
        ));
        $this->s->display(PLATFORM ."/article/content.html");
    }
    public function add ()
    {
        //var_dump($_REQUEST);
        $url = "?p=frontend&c=Article&a=content&id={$_GET['article_id']}";
        if(strtolower($_POST['edtCaptcha'])!=$_SESSION['trueCaptcha1'] ) {
           return  $this->redirect('验证码错误', $url);
        }
        $this->denyAccess();
        if(CommentModel::getModel()->add(array(
            'user_id' => $_SESSION['user']['id'],
            'article_id' => $_GET['article_id'],
            'parent_id' => $_POST['inpRevID'],
            'time' => time(),
            'content' => $_POST['txaArticle'],
        ))) {
            $this->redirect('添加成功', $url);
        }else {
            $this->redirect('添加失败', $url);
        }
    }
    public function good ()
    {
        $id = $_GET['article_id'];
        $url = "?p=frontend&c=Article&a=content&id={$id}";
        /*if(isset($_SESSION["flag_{$id}"]) and $_SESSION["flag_{$id}"]) {
           return $this->redirect('已赞过,不能重复点赞',$url);
        }*/
        if(ArticleModel::getModel()->addGoodCount($id)) {
            $_SESSION["flag_{$id}"] = true;
            $this->redirect('点赞成功', $url);
        }else {
            $this->redirect('点赞失败', $url);
        }
    }
    public function captcha()
    {
        $obj = new Captcha();
        $obj->generateCode();
        $_SESSION['trueCaptcha1']=$obj->getCode();
    }
    public function deleteGood ()
    {
        $id = $_GET['article_id'];
        $url = "?p=frontend&c=Article&a=content&id={$id}";
        /* if(isset($_SESSION["flag_{$id}"]) and $_SESSION["flag_{$id}"]) {
             return $this->redirect('已赞过,不能重复点赞',$url);
         }*/
        if (ArticleModel::getModel()->deleteGoodCount($id)) {
            $_SESSION["flag_{$id}"] = true;
            $this->redirect('取消点赞成功', $url);
        } else {
            $this->redirect('取消点赞失败', $url);
        }
    }
}