<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/16
 * Time: 18:15
 */
namespace core;
use vendor\Smarty;
class Controller
{
    protected $s;
    public function __construct()
    {
        $this->createSmartyObject();
    }

    protected function createSmartyObject ()
    {
        $s = new Smarty ();
        $s->left_delimiter = "<{";
        $s->right_delimiter = "}>";
        $s->setTemplateDir(VIEW_PATH);
        $s->setCompileDir(sys_get_temp_dir().'./templates_c');
        //$s->setCacheDir();
        $s->setConfigDir('./app/config');
        $this->s=$s;
    }

    protected function redirect($message, $url, $time=2,$type=1)
    {
        if($type==2) {
            echo "$message";
            header("refresh:$time;url='{$url}'");
        }else {
             require VIEW_PATH.'/tip.html';
        }
    }
    protected function loadHtml($htmlName, $data=array())
    {
        foreach($data as $variableName => $variableValue) {
        $$variableName = $variableValue;
        }
        require VIEW_PATH."/" .PLATFORM. "/{$htmlName}.html";
    }
    protected function denyAccess ()
    {
        if(isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess'] == true) {

        }else {
            $this->redirect('禁止访问','?p=backend&a=login&c=Login');
            die;
        }
    }
}