<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/24
 * Time: 15:29
 */

namespace app\Controller\backend;
use app\Model\CategoryModel;

class CategoryController extends \core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->denyAccess();
    }

    public function index ()
    {
        $categories = CategoryModel::getModel()->findAllWithJoin();
        $categories = CategoryModel::getModel()->limitlessLevelCategory($categories);
        $this->loadHtml('category/index',array(
            'categories' => $categories,
        ));
    }
    public function add ()
    {
        if(empty($_POST)) {
            $categories = CategoryModel::getModel()->limitlessLevelCategory( CategoryModel::getModel()->findAll());
            $this->loadHtml('category/add',array(
                'categories' => $categories,
            ));
        }else {
           if(CategoryModel::getModel()->add(array(
               'sort' => $_POST['Order'],
               'name' => $_POST['Name'],
               'nickname' => $_POST['Alias'],
               'parent_id' => $_POST['ParentID'],
           ))) {
               $this->redirect('添加成功', '?p=backend&c=Category&a=index');
           }else {
               $this->redirect('添加失败,请稍后再试...', '?p=backend&c=Category&a=add');
           }
        }
    }
    public function delete ()
    {
          $id = $_GET['id'];
        if(CategoryModel::getModel()->findCount("parent_id='{$id}'")>0) {
            $this->redirect('不允许删除有子分类的分类', '?p=backend&c=Category&a=index');
            die;
        }
            if (CategoryModel::getModel()->deleteById($id)) {
                $this->redirect('删除成功', '?p=backend&c=Category&a=index');
            }else {
                $this->redirect('删除失败', '?p=backend&c=Category&a=index');
            }
    }
    public function update ()
    {
        $id = $_GET['id'];
        $obj = CategoryModel::getModel();
        if(empty($_POST)) {
            $category = $obj->findById($id);
           // print_r($icategory);
            $categories = $obj->limitlessLevelCategory(CategoryModel::getModel()->findAll());
            $this->loadHtml('category/update', array(
                'category' => $category,
                'categories' => $categories,
            ));
        }else {
            /*$oldCategory = $obj->findById($id);
            if (
            ($oldCategory->name == $_POST['Name']) &&
            ($oldCategory->nickname == $_POST['Alias']) &&
            ($oldCategory->sort == $_POST['Order']) &&
            ($oldCategory->parent_id == $_POST['ParentID'])

            ) {
                $this->redirect('修改成功', '?p=backend&c=Category&a=index');
                die;
            }*/
            $flag = CategoryModel::getModel()->updateById($id, array(
                'sort' => $_POST['Order'],
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'parent_id' => $_POST['ParentID'],
            ));
            if($flag === 1 || $flag === 0) {
                $this->redirect('修改成功', '?p=backend&c=Category&a=index');
            }else {
                $this->redirect('修改失败,请稍后再试...', '?p=backend&c=Category&a=update');
            }
        }
    }
}