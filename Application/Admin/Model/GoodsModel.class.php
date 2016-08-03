<?php
namespace Admin\Model;
use Think\Model;
/**
 *
 */
class GoodsModel extends Model
{
  //定义验证规则
  protected $_validate = array(
    array('goods_name','require','商品名称不能为空!',1),
    array('market_price','currency','市场价格必须是货币类型!',1),
    array('shop_price','currency','本店价格必须是货币类型!',1),
  );
}
