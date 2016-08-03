<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller {
  /**
   * 添加商品
   * 显示和处理表单
   */
  public function addGoods(){
    //判断用户是否提交了表单
    if (IS_POST) {
      //生成商品模型
      $model = D('goods');
      /**
       * 接受表单数据并保存到模型中
       * @var 要接受的数据,默认是$_POST
       * @var 表单的类型.当前是添加商品表单还是修改表单,1:添加 2:修改
       * $_POST:表单中原始的数据,I('POST')是过滤以后的数据
       */
      if($model->create(I('post.'),1)){
        if ($model->add()) {
          //显示成功信息,等待3秒后跳转
          $this->success('操作成功!',U('goodsList'),3);
          exit;
        }
      }
      //处理失败的场景
      $error = $model->getError(); // 注意,从模型中取出信息,由控制器来输出信息
      //显示错误信息
      $this->error($error);
    }
    //显示表单
    $this->display();
  }
  /**
   * 商品列表页
   */
   public function goodsList(){
     echo '商品列表页';
   }
}
