<?php
namespace Admin\Model;
use Think\Model;
/**
 *  商品模型类
 */
class GoodsModel extends Model
{
  //添加时cerate方法允许接受的字段
  protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc';
  //定义验证规则
  protected $_validate = array(
    array('goods_name','require','商品名称不能为空!',1),
    array('market_price','currency','市场价格必须是货币类型!',1),
    array('shop_price','currency','本店价格必须是货币类型!',1),
  );
  /**
   * 这个方法会在添加之前自动被调用(钩子函数)
   * @param $data array 表单中即将要查入到数据库中的数据(数组形式)
   * @param $option
   * 注意:在函数内部要修改外部的变量,需要按引用传递
   */
  protected function _before_insert(&$date,$option){
    // exit('sleep');
    /**
    * 处理用户上传图片
    */
    if (0 == $_FILES['logo']['error']) {
      $upload = new \Think\Upload();//实例化上传类
      $upload->maxSize = 1024 * 1024;//设置附件上传大小
      $upload->exts = array('jpg','gif','png','jpeg');//设置上传类型
      $upload->rootPath = './Public/Uploads/';//设置附件上传根目录
      $upload->savePath = 'Goods/';//设置附件上传(子)目录
      //上传文件
      $info = $upload->upload();
      if (!$info) {
        //获取失败原因保存到模型中
        $this->error = $upload->getError();
        return false;
      }else {
        $this->success('上传成功!');
      }
    }
    //获取当前时间并添加到数据库的数据中
    $data['addtime'] = date('Y-m-d H:i:s',time());
  }
}
