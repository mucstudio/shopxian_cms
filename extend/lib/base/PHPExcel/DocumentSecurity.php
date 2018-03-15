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
 */       class PHPExcel_DocumentSecurity  {            private $lockRevision;              private $lockStructure;              private $lockWindows;              private $revisionsPassword;              private $workbookPassword;              public function __construct()      {                   $this->lockRevision      = false;          $this->lockStructure     = false;          $this->lockWindows       = false;          $this->revisionsPassword = '';          $this->workbookPassword  = '';      }              public function isSecurityEnabled()      {          return  $this->lockRevision ||                  $this->lockStructure ||                  $this->lockWindows;      }              public function getLockRevision()      {          return $this->lockRevision;      }              public function setLockRevision($pValue = false)      {          $this->lockRevision = $pValue;          return $this;      }              public function getLockStructure()      {          return $this->lockStructure;      }              public function setLockStructure($pValue = false)      {          $this->lockStructure = $pValue;          return $this;      }              public function getLockWindows()      {          return $this->lockWindows;      }              public function setLockWindows($pValue = false)      {          $this->lockWindows = $pValue;          return $this;      }              public function getRevisionsPassword()      {          return $this->revisionsPassword;      }              public function setRevisionsPassword($pValue = '', $pAlreadyHashed = false)      {          if (!$pAlreadyHashed) {              $pValue = PHPExcel_Shared_PasswordHasher::hashPassword($pValue);          }          $this->revisionsPassword = $pValue;          return $this;      }              public function getWorkbookPassword()      {          return $this->workbookPassword;      }              public function setWorkbookPassword($pValue = '', $pAlreadyHashed = false)      {          if (!$pAlreadyHashed) {              $pValue = PHPExcel_Shared_PasswordHasher::hashPassword($pValue);          }          $this->workbookPassword = $pValue;          return $this;      }              public function __clone()      {          $vars = get_object_vars($this);          foreach ($vars as $key => $value) {              if (is_object($value)) {                  $this->$key = clone $value;              } else {                  $this->$key = $value;              }          }      }  }  