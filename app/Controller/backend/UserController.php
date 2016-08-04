<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/22
 * Time: 11:23
 */

namespace app\Controller\backend;
use app\Model\UserModel;

class UserController extends \core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->denyAccess();
    }
    public function index ()
    {
        $obj=UserModel::getModel();
        $users=$obj -> findAll();
        $data=array(
             'users' => $users
        );
        $this -> loadHtml('user/index', $data);
    }
    public function add ()
    {
        if(empty($_POST)) {
          $this->loadHtml('user/add');
        }else {
            if (empty($_POST['name'])) {
                return $this->redirect('用户名不能为空,添加失败..', '?p=backend&c=User&a=add');
            }
            $obj=UserModel::getModel();
            if($obj->add(array(
                'name'  => $_POST['name'],
                'pass'  => md5($_POST['pass']),
                'nickname'  => $_POST['nickname'],
                'email'  => str_replace('</script>', '', str_replace('<script>', '', $_POST['email'])),
                'mobile_number'  => $_POST['mobile_number'],
                'addate'   => time(),
            ))) {
                $this->redirect('添加成功', '?p=backend&c=User&a=index');
            }else {
                $this->redirect('添加失败', '?p=backend&c=User&a=add');
            }
        }
    }
    public function delete ()
    {
        $id=$_GET['id'];
        $obj=UserModel::getModel();
        if($obj->deleteById($id)) {
            $this->redirect('删除成功', '?p=backend&c=User&a=index');
        }else{
            $this->redirect('删除失败', '?p=backend&c=User&a=index');
        }
    }
    public function update ()
    {
        $id=$_GET['id'];
        $obj=UserModel::getModel();
        if(empty($_POST)) {
            $user=$obj->findById($id);
            $this->loadHtml('user/update',array('user' => $user));
        }else{
            $flag = $obj->updateById($id,array(
                'name'  => $_POST['name'],
                'nickname'  => $_POST['nickname'],
                'email'  => $_POST['email'],
                'mobile_number'  => $_POST['mobile_number'],
            ));
            if($flag === 1 || $flag === 0) {
                $this->redirect('修改成功', '?p=backend&c=User&a=index');
            }else {
                $this->redirect('修改失败', '?p=backend&c=User&a=update&id=$id');
            }
        }
    }
}