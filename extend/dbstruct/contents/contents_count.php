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

 * 时间: 2018-03-17 23:28:45
 */   return [      'Stru'=>[          'id'=>[              'type'=>'int',              'length'=>'11',              'default'=>null,              'comment'=>'文章id',              'label'=>'文章id',              'in_list' => true,              'input_type'=>'hidden',          ],          'cat_id'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'分类id',              'default'=>'0',              'label'=>'分类id',              'in_list' => true,              'input_type'=>'hidden',          ],          'permission'=>[              'type'=>'enum',              'length'=>'2',              'default'=>'1',              'not_null'=>'true',              'comment'=>'阅读权限',              'value'=>array(                  0=>'待审核',                  1=>'开放浏览',              ),              'label'=>'阅读权限',              'in_list' => true,              'width'=>'100',              'input_type'=>'radio',          ],          'click'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'浏览次数',              'default'=>'0',              'label'=>'浏览次数',              'in_list' => true,              'input_type'=>'hidden',          ],          'comment'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'评论次数',              'default'=>'0',              'label'=>'评论次数',              'in_list' => true,              'input_type'=>'hidden',          ],          'praise'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'赞次数',              'default'=>'0',              'label'=>'赞次数',              'in_list' => true,              'input_type'=>'hidden',          ],          'trample'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'踩次数',              'default'=>'0',              'label'=>'踩次数',              'in_list' => true,              'input_type'=>'hidden',          ],          'high_opinion'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'好评',              'default'=>'0',              'label'=>'好评',              'in_list' => true,              'input_type'=>'hidden',          ],          'middle_opinion'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'中评',              'default'=>'0',              'label'=>'中评',              'in_list' => true,              'input_type'=>'hidden',          ],          'low_opinion'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'差评',              'default'=>'0',              'label'=>'差评',              'in_list' => true,              'input_type'=>'hidden',          ],      ],      'Charset'=>'utf8',      'Collate'=>'utf8_unicode_ci',      'Engine'=>'MyISAM',      'Annotation'=>'',      'primary'=>[              'id',      ]  ];  