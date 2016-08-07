create database tpshop;
use tpshop;
set names utf8;

DROP TABLE if exists xz_goods;
CREATE TABLE xz_goods(
  id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Id',
  goods_name VARCHAR(150) NOT NULL COMMENT '商品名称',
  market_price DECIMAL(10,2) NOT NULL COMMENT '市场价格',
  shop_price DECIMAL(10,2) NOT NULL COMMENT '本店价格',
  goods_desc TEXT COMMENT '商品描述',
  is_on_sale ENUM('是','否') NOT NULL DEFAULT '是' COMMENT '是否上架',
  is_delete ENUM('是','否') NOT NULL DEFAULT '否' COMMENT '是否放入回收站',
  addtime DATETIME NOT NULL DEFAULT NOW() COMMENT '添加时间',
  logo VARCHAR(150) NOT NULL DEFAULT '' COMMENT '原图',
  sm_logo VARCHAR(150) NOT NULL DEFAULT '' COMMENT '小图',
  mid_logo VARCHAR(150) NOT NULL DEFAULT '' COMMENT '中图',
  big_logo VARCHAR(150) NOT NULL DEFAULT '' COMMENT '大图',
  mbig_logo VARCHAR(150) NOT NULL DEFAULT '' COMMENT '放大图',
  KEY shop_price(shop_price),
  KEY addtime(addtime),
  KEY is_on_sale(is_on_sale)
)engine=InnoDB default charset=utf8 comment '商品';
