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

 * 时间: 2018-03-15 19:07:22
 */   return [      'Stru'=>[          'id'=>[              'type'=>'int',              'length'=>'11',              'default'=>null,              'unsigned'=>'true',              'not_null'=>'true',              'auto_increment'=>'true',              'comment'=>'广告id',              'zerofill'=>'true',              'auto_increment'=>true,              'label'=>'广告id',              'in_list' => true,              'width'=>'100',              'input_type'=>'hidden',          ],          'title'=>[              'type'=>'varchar',              'length'=>'100',             'not_null'=>'true',              'comment'=>'广告名称',              'label'=>'广告名称',              'in_list' => true,              'is_row_search'=>true,              'is_more_search'=>true,              'width'=>'400',              'input_type'=>'text',          ],          'cat_id'=>[              'type'=>'int',              'length'=>'11',             'comment'=>'广告投放范围',              'label'=>'广告投放范围',              'not_null'=>'true',              'in_list' => true,              'width'=>'100',              'value'=>[                  '-1'=>'请选择',                  '0'=>'所有栏目',              ],              'input_type'=>'select',          ],          'timeset'=>[              'type'=>'enum',              'length'=>'2',              'default'=>'0',              'not_null'=>'true',              'comment'=>'时间限制',              'value'=>array(                  0=>'永不过期',                  1=>'在设内时间内有效',              ),              'label'=>'时间限制',              'in_list' => true,              'input_description'=>'时间限制为：在设内时间内有效,投放时间才有效',              'width'=>'150',              'input_type'=>'radio',          ],          'starttime'=>[              'type'=>'int',              'length'=>'11',             'unsigned'=>'true',              'comment'=>'投放开始时间',              'label'=>'投放开始时间',              'in_list' => true,              'input_type'=>'datetime',          ],          'endtime'=>[              'type'=>'int',              'length'=>'11',             'unsigned'=>'true',              'comment'=>'投放结束时间',              'label'=>'投放结束时间',              'in_list' => true,              'input_type'=>'datetime',          ],          'ad_type'=>[              'type'=>'enum',              'length'=>'5',              'default'=>'code',              'not_null'=>'true',              'comment'=>'广告类型',              'value'=>array(                  'code'=>'代码',                  'text'=>'文字',                  'aimg'=>'单图',                  'imgs'=>'幻灯片',              ),              'label'=>'广告类型',              'in_list' => true,              'width'=>'100',              'input_type'=>'hidden',          ],          'ad_body'=>[              'type'=>'text',              'length'=>'5000',             'comment'=>'广告内容',              'label'=>'广告内容',              'in_list' => false,              'tag_val'=>'',              'input_type'=>'taglib',          ],          'ad_height'=>[               'type'=>'int',              'default'=>'25',              'length'=>'3',             'not_null'=>'true',              'comment'=>'广告高度',              'label'=>'广告高度(px)',              'in_list' => true,              'input_type'=>'number',          ],          'rank'=>[              'type'=>'int',              'length'=>'10',             'unsigned'=>'true',              'not_null'=>'true',              'comment'=>'排序值',              'label'=>'排序值(越小越靠前)',              'in_list' => true,              'width'=>'100',              'input_type'=>'number',          ],          'add_time'=>[              'type'=>'int',              'length'=>'10',             'unsigned'=>'true',              'not_null'=>'true',              'comment'=>'发布时间',              'label'=>'发布时间',              'in_list' => true,              'width'=>'180',              'fun'=>'dateof',              'input_type'=>'hidden',          ],          'user_id'=>[              'type'=>'int',              'length'=>'11',             'unsigned'=>'true',              'not_null'=>'true',              'comment'=>'发布人id',              'label'=>'发布人id',              'in_list' => false,              'width'=>'100',              'input_type'=>'hidden',          ],      ],      'Charset'=>'utf8',      'Collate'=>'utf8_unicode_ci',      'Engine'=>'MyISAM',      'Annotation'=>'',      'primary'=>[              'id',      ],      'index'=>[          'cat_id'=>[              'index_type'=>'Normal',              'index_way'=>'BTREE',              'columns'=>[                  'cat_id',              ],          ],      ]  ];  