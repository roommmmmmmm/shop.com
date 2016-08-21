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
  brand_id MEDIUMINT UNSIGNED NOT NULL COMMENT '品牌id',
  KEY shop_price(shop_price),
  KEY addtime(addtime),
  KEY is_on_sale(is_on_sale),
  key brand_id(brand_id)
)engine=InnoDB default charset=utf8 comment '商品';
alter table xz_goods add index brand_id(brand_id);
DROP TABLE if exists xz_brand;
CREATE TABLE xz_brand(
  id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Id',
  brand_name VARCHAR(30) NOT NULL COMMENT '品牌名称',
  site_url VARCHAR(50) DEFAULT '' COMMENT '官方网站'
)engine=InnoDB default charset=utf8 comment '品牌';
DROP TABLE if exists xz_member_level;
CREATE TABLE xz_member_level(
  level_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Id',
  level_name VARCHAR(30) NOT NULL COMMENT '级别名称',
  lower_limit MEDIUMINT UNSIGNED NOT NULL DEFAULT '' COMMENT '积分下限'
  upper_limit MEDIUMINT UNSIGNED NOT NULL DEFAULT '' COMMENT '积分上限'
)engine=InnoDB default charset=utf8 comment '会员级别';
DROP TABLE if exists xz_member_price;
CREATE TABLE xz_member_price(
  price DECIMAL(10,2) NOT NULL COMMENT '会员价格',
  level_id MEDIUMINT UNSIGNED NOT NULL COMMENT '级别 '
)engine=InnoDB default charset=utf8 comment '会员价格';
