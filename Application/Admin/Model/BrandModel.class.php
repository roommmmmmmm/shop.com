<?php
namespace Admin\Model;
use Think\Model;
class BrandModel extends Model
{
	protected $insertFields = array('brand_name','site_url');
	protected $updateFields = array('id','brand_name','site_url');
	protected $_validate = array(
		array('brand_name', 'require', '品牌名称不能为空！', 1, 'regex', 3),
		array('brand_name', '1,30', '品牌名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('site_url', '1,50', '官方网站的值最长不能超过 50 个字符！', 2, 'length', 3),
	);
	public function search($pageSize = 20)
	{
		$where = array();
		if($brand_name = I('get.brand_name'))
			$where['brand_name'] = array('like', "%$brand_name%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
	}
	// 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
}
