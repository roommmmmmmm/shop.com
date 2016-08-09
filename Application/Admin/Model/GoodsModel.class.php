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
  protected function _before_insert(&$data,$option){
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
        // var_dump($info);
        // exit;
        /**
         * 上传成功后生成缩略图
         */
         //找到原图地址
         $logoPath = $info['logo']['savepath'].$info['logo']['savename'];
         // 拼出缩略图的名字和路径
         $mbiglogo = $info['logo']['savepath'].'mbig_'.$info['logo']['savename'];
         $biglogo = $info['logo']['savepath'].'big_'.$info['logo']['savename'];
         $midlogo = $info['logo']['savepath'].'mid_'.$info['logo']['savename'];
         $smlogo = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];
         $image = new \Think\Image();
         //打开要处理的图片
         $image->open('./Public/Uploads/'.$logoPath);
         //生成缩略图
         $image->thumb(700,700)->save('./Public/Uploads/'.$mbiglogo);
         $image->thumb(350,350)->save('./Public/Uploads/'.$biglogo);
         $image->thumb(130,130)->save('./Public/Uploads/'.$midlogo);
         $image->thumb(50,50)->save('./Public/Uploads/'.$smlogo);
         $data['logo']=$logoPath;
         $data['sm_logo']=$smlogo;
         $data['mid_logo']=$midlogo;
         $data['big_logo']=$biglogo;
         $data['mbig_logo']=$mbiglogo;
        return true;
      }
    }
    //获取当前时间并添加到数据库的数据中
    $data['addtime'] = date('Y-m-d H:i:s',time());
  }
  /**
   * 实现翻页/搜索/排序
   */
  public function search($perpage = 20){
    /**
     * 翻页
     */
     //取出总记录数
     $count = $this->count();
     //生成翻页类的对象
     $Page = new \Think\Page($count,$perpage);
     //设置样式
     $Page->setConfig('next','下一页');
     $Page->setConfig('prev','上一页');
      //生成html字符串
     $pagestr = $Page->show();
    /**
     * 取数据
     */
    $data = $this->limit($Page->firstRow.','.$Page->listRows)->select();
    return array(
      'data'=>$data,
      'page'=>$pagestr
    );
  }
}
