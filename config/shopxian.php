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

 * 时间: 2018-03-15 19:07:10
 */   return [      'app_name'  => '秀仙 shopxian3.0',      'base_app'=>[          'base',          'desktop',          'system',          'files',          'contents'      ],      'imgcompress'=>[               'level1'=>['width'=>'30','height'=>'30',],               'level2'=>['width'=>'40','height'=>'40',],               'level3'=>['width'=>'80','height'=>'80',],               'level4'=>['width'=>'160','height'=>'160',],               'level5'=>['width'=>'250','height'=>'250',],               'level6'=>['width'=>'320','height'=>'320',],               'level7'=>['width'=>'420','height'=>'420',],               'level8'=>['width'=>'550','height'=>'550',],      ],      'applog_level'=>'3',      'desktop_main_nav'=>[          'Cms前台首页'=> url('contents/Index/index'),      ],  ];