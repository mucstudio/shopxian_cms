<?php 

/**
 * 秀仙系统 shopxian_release/3.0.0
 * ============================================================================
 * * 版权所有 2017-2018 上海秀仙网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.shopxian.com；
 * ----------------------------------------------------------------------------
 * 本软件只能免费使用  不允许对程序代码以任何形式任何目的再发布或者出售。
 * ============================================================================
 * 作者: 张启全 

 * 时间: 2018-03-17 23:28:32
 */   namespace common\taglib;  use think\template\TagLib;  use think\Cache;      class Zhanshop extends Taglib {           protected $tags = [          'menu'    => array('attr'=>'limit'),         'widgets'       => ['attr' => 'name,type,val', 'close' => 0],      ];      public function tagMenu($tag, $content){          $parseStr = '<?php $a=appModel("system","SystemSiteMenu")->where(["enabled"=>"true"])->order("rank asc")->limit('.$tag['limit'].')->column("*");';          $parseStr .= 'foreach($a as $k=>$v){ ?>';          $parseStr .= '<?php '                  . 'echo  str_replace(array("[url]","[title]"),array($v["url"],$v["title"]),"'.$content.'");'                  . ' ?>';          $parseStr .= '<?php } ?>';          return $parseStr;      }      public function tagWidgets($tag, $content)      {          $parseStr='<?php ';          $parseStr.='if(isset($widgets)==false){';          $parseStr.='$widgets=new \lib\site\widgets();}';          $parseStr.='echo $widgets->getwidgets("'.$tag['name'].'","'.$tag['type'].'",\''.$tag['val'].'\');?>';          return $parseStr;      }  }  