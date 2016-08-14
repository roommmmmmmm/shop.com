<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function test(){
      $this->assign(
      array(
        'page_name'=>'添加商品',
        'botton_name'=>'商品列表',
        'botton_link'=>U('Goods/goodsList')
      )
    );
      $this->display();
    }
    public function index(){
      $this->display();
    }
    public function top(){
      $this->display();
    }
    public function menu(){
      $this->display();
    }
    public function main(){
      $this->display();
    }
}
