<?php
namespace Admin\Model;
use Think\Model;
/**
 *  商品模型类
 */
class GoodsModel extends Model
{
  //添加时create方法允许接受的字段
  protected $insertFields = 'brand_id,goods_name,market_price,shop_price,is_on_sale,goods_desc';
  //修改时调用create方法允许接受的字段
  protected $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id';//多了一个id字段
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
   * 修改商品信息前的钩子函数
   */
   protected function _before_update(&$data,$option){
     $id = I('post.id');
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
          //删除原来的图片
          $oldlogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
          //从硬盘上删除
          // var_dump($oldlogo);
          deleteImage($oldlogo);
          // exit;
          return true;
       }
     }
    //  $date['goods_desc'] = removeXss($_POST['goods_desc']);
   }
   /**
    * 删除商品前的钩子函数
    */
    protected function _before_delete($option){
      $id = $option['where']['id'];
      //删除原来的图片
      $oldlogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
      //从硬盘上删除
      deleteImage($oldlogo);
    }
  /**
   * 实现翻页/搜索/排序
   */
  public function search($perpage = 20){
    /**
     * 搜索功能
     */
     $where = array();
     $goods_name = I('get.goods_name'); // 名称搜索
     if ($goods_name) {
       $where['goods_name']=array("like","%$goods_name%");
     }
     // 按照商品价格搜索
     $fp = I('get.fp');
     $tp = I('get.tp');
     if ($fp && $tp) {
       $where['shop_price'] = array('between',array($fp,$tp));
     }elseif ($fp) {
       $where['shop_price'] = array('egt',$fp); // WHERE shop_price >= $fp
     }elseif ($tp) {
       $where['shop_price'] = array('elt',$fp); // WHERE shop_price <= $fp
     }
     // 搜索是否上架
     $is_on_sale = I('get.is_on_sale');
     if ($is_on_sale) {
      $where['is_on_sale']= array('eq',$is_on_sale);
     }
     // 按照商品添加时间搜索
     $fp = I('get.fa');
     $tp = I('get.ta');
     if ($fa && $ta) {
       $where['addtime'] = array('between',array($fa,$ta));
     }elseif ($fa) {
       $where['addtime'] = array('egt',$fa);
     }elseif ($ta) {
       $where['addtime'] = array('elt',$ta);
     }
     $brandid = I('get.brand_id');
     if ($brandid) {
       $where['brand_id'] = array('eq',$brandid);
     }
    /**
     * 翻页
     */
     //取出总记录数
     $count = $this->where($where)->count();
     //生成翻页类的对象
     $Page = new \Think\Page($count,$perpage);
     //设置样式
     $Page->setConfig('next','下一页');
     $Page->setConfig('prev','上一页');
      //生成html字符串
     $pagestr = $Page->show();
     //排序 (可能存在bug)
     $orderby = 'a.id'; //默认排序字段
     $deorderby = 'desc'; //默认排序方式
     $order = I('get.oderby');
     if ($order) {
       if ($order == 'id_asc') {
         $deorderby = 'asc';
       }elseif ($order == 'price_desc') {
         $deorderby = 'shop_price';
       }elseif ($order == 'price_asc') {
         $orderby = 'shop_price';
         $deorderby = 'asc';
       }
     }
    /**
     * 取数据
     */
     //连表查询 select a.*,b.brand_name from xz_goods as a ,xz_brand as b where a.brand_id=b.id\G
     //        select a.*,b.brand_name from xz_goods as a left join xz_brand as b on a.brand_id=b.id\G
    $data = $this->order("$orderby $deorderby") //排序
                 ->field('a.*,b.brand_name')
                 ->alias('a')    //起别名
                 ->join('LEFT JOIN __BRAND__ as b ON a.brand_id=b.id')    //连表查询
                 ->where($where)   //搜索
                 ->limit($Page->firstRow.','.$Page->listRows)    //分页
                 ->select();
    // var_dump($data);
    // exit;
    return array(
      'data'=>$data,
      'page'=>$pagestr
    );
  }
}
