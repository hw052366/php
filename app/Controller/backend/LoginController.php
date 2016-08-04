<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/22
 * Time: 17:13
 */

namespace app\Controller\backend;

use app\Model\UserModel;
use vendor\Captcha;

class LoginController extends \core\Controller
{
    public function login()
    {
        if (empty($_POST)) {
            $this->loadHtml('login/login');
        } else {
            if(strtolower($_POST['edtCaptcha'])!=$_SESSION['trueCaptcha'] ) {
                $this->redirect('验证码错误', '?p=backend&c=Login&a=login');
                die();
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
                    $this->redirect('登录成功', '?p=backend&a=frame&c=Frame');
                } else {
                    $_SESSION['loginSuccess'] = false;
                    $this->redirect('登录失败', '?p=backend&a=login&c=Login');
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
}