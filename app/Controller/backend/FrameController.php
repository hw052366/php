<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/22
 * Time: 9:50
 */
namespace app\Controller\backend;
class FrameController extends \core\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->denyAccess();
    }
   public function frame()
   {
       $this -> loadHtml('frame/frame');
   }
    public function top()
    {
        $this -> loadHtml('frame/top');
    }
    public function menu ()
    {
        $this -> loadHtml('frame/menu');
    }
    public function content ()
    {
        $this -> loadHtml('frame/content');
    }
}