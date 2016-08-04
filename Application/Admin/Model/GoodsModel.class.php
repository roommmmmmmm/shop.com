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
    //获取当前时间并添加到数据库的数据中
    $data['addtime'] = date('Y-m-d H:i:s',time());
  }
}
