<?php
namespace Admin\Model;
use Think\Model;
class MemberLevelModel extends Model 
{
	protected $insertFields = array('level_name','lower_limit','upper_limit');
	protected $updateFields = array('level_id','level_name','lower_limit','upper_limit');
	protected $_validate = array(
		array('level_name', 'require', '级别名称不能为空！', 1, 'regex', 3),
		array('level_name', '1,30', '级别名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('lower_limit', 'require', '积分下限不能为空！', 1, 'regex', 3),
		array('lower_limit', 'number', '积分下限必须是一个整数！', 1, 'regex', 3),
		array('upper_limit', 'require', '积分上限不能为空！', 1, 'regex', 3),
		array('upper_limit', 'number', '积分上限必须是一个整数！', 1, 'regex', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.level_id')->limit($page->firstRow.','.$page->listRows)->select();
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
		if(is_array($option['where']['level_id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
	}
	/************************************ 其他方法 ********************************************/
}