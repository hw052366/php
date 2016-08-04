<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/22
 * Time: 17:13
 */

namespace app\Controller\frontend;

use app\Model\UserModel;
use vendor\Captcha;

class LoginController extends \core\Controller
{
    public function login()
    {
        if (empty($_POST)) {
            $this->s->display(PLATFORM.'/login/login.html');
        } else {

            if(strtolower($_POST['edtCaptcha'])!=$_SESSION['trueCaptcha'] ) {
                return $this->redirect('验证码错误', '?p=frontend&c=Login&a=login');

            }
                $name = addslashes($_POST['username']);
                $pass = $_POST['password'];
                $use = UserModel::getModel()->find("name = '{$name}' and pass = '{$pass}'");
                if ($use) {
                    $_SESSION['loginSuccess'] = true;
                    $_SESSION['uid'] = $use->id;
                    $_SESSION['user'] = array(
                        'id' => $use->id,
                        'name' => $use->name,
                        'nickname' => $use->nickname,
                        'email' => $use->email,
                        'mobile_number' => $use->mobile_number,
                        'current_time' =>time(),
                        'current_ip' => $_SERVER['REMOTE_ADDR'],
                    );
                    $this->redirect('登录成功', '?p=frontend&a=index&c=Article');
                } else {
                    $_SESSION['loginSuccess'] = false;
                    $this->redirect('登录失败', '?p=frontend&a=login&c=Login');
                }
        }
    }
    public function captcha()
    {
        $obj = new Captcha();
        $obj->generateCode();
        $_SESSION['trueCaptcha']=$obj->getCode();
    }
    public function logout ()
    {
        unset($_SESSION);
        session_destroy();
        $this->redirect('退出成功', '?p=backend&a=login&c=Login');
    }
    public function regist ()
    {
        if (empty($_POST)) {
            $this->s->display(PLATFORM . "/login/regist.html");
        } else {
            //var_dump($_POST);die;
            if (strtolower($_POST['edtCaptcha']) != $_SESSION['trueCaptcha']) {
                return $this->redirect('验证码错误', "?p=frontend&c=Login&a=regist");
            }
            if (MD5($_POST['redtPassWord']) != $_POST['password']) {
                return $this->redirect('俩次密码不同,请重输..', "?p=frontend&c=Login&a=regist");
            }
            if (UserModel::getModel()->add(array(
                // 'redtPassword' => $_POST['redtPassWord'],
                'pass' => $_POST['password'],
                'name' => $_POST['username'],
                'addate' => time(),
            ))
            ) {
                $this->redirect('注册成功,可以返回登录..', "?p=frontend&c=Login&a=login");
            } else {
                $this->redirect('注册失败,请重试..', "?p=frontend&c=Login&a=regist");
            }
        }

    }
}