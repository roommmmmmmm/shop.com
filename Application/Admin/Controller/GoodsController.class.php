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
       * @param 要接受的数据,默认是$_POST
       * @param 表单的类型.当前是添加商品表单还是修改表单,1:添加 2:修改
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
    // //取出所有品牌
    // $brandmodel = D('brand');
    // $branddata = $brandmodel->select();
    // // var_dump($branddata);
    // // exit;
    // $this->assign('brandinfo',$branddata);
    //显示表单
    $this->display();
  }
  /**
   * 修改商品
   * 显示和处理表单
   */
  public function editGoods(){
    $id = I('get.id');//要修改的商品的ID
    //生成商品模型
    $model = D('goods');
    //判断用户是否提交了表单
    if (IS_POST) {
      if($model->create(I('post.'),2)){
        if (FALSE !== $model->save()) {
          //save()的返回值如果失败返回false,如果成功返回受影响的条数.如果前后修改信息一样,返回0,如果不用全等,就会导致逻辑错误
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
    //取出所有品牌
    $brandmodel = D('brand');
    $branddata = $brandmodel->select();
    $this->assign('brandinfo',$branddata);
    //显示表单
    $data = $model->find($id);
    // var_dump($data);
    $this->assign('data',$data);
    $this->display();
  }
  /**
   * 商品列表页
   */
   public function goodsList(){
     $model = D('goods');

     //返回数据和分页
     $data = $model->search(5);
     $this->assign($data);
     $this->assign(array(
       'page_name'=>'商品列表',
       'botton_name'=>'添加商品',
       'botton_link'=>U('Goods/addGoods')
     ));
    //  var_dump($data);
    //  exit;
     $this->display();
   }
   /**
    * 删除商品
    */
    public function deleteGoods(){
      $model = D('goods');
      if (FALSE !== $model->delete(I('get.id'))) {
        $this->success('删除成功!',U('goodsList'));
      }else {
        $this->error('删除失败 : '.$model->getError());
      }
    }
}
