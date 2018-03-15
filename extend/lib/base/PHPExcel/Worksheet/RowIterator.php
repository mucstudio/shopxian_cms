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
 */       class PHPExcel_Worksheet_RowIterator implements Iterator  {            private $subject;              private $position = 1;              private $startRow = 1;                private $endRow = 1;                public function __construct(PHPExcel_Worksheet $subject, $startRow = 1, $endRow = null)      {                   $this->subject = $subject;          $this->resetEnd($endRow);          $this->resetStart($startRow);      }              public function __destruct()      {          unset($this->subject);      }              public function resetStart($startRow = 1)      {          if ($startRow > $this->subject->getHighestRow()) {              throw new PHPExcel_Exception("Start row ({$startRow}) is beyond highest row ({$this->subject->getHighestRow()})");          }            $this->startRow = $startRow;          if ($this->endRow < $this->startRow) {              $this->endRow = $this->startRow;          }          $this->seek($startRow);            return $this;      }              public function resetEnd($endRow = null)      {          $this->endRow = ($endRow) ? $endRow : $this->subject->getHighestRow();            return $this;      }              public function seek($row = 1)      {          if (($row < $this->startRow) || ($row > $this->endRow)) {              throw new PHPExcel_Exception("Row $row is out of range ({$this->startRow} - {$this->endRow})");          }          $this->position = $row;            return $this;      }              public function rewind()      {          $this->position = $this->startRow;      }              public function current()      {          return new PHPExcel_Worksheet_Row($this->subject, $this->position);      }              public function key()      {          return $this->position;      }              public function next()      {          ++$this->position;      }              public function prev()      {          if ($this->position <= $this->startRow) {              throw new PHPExcel_Exception("Row is already at the beginning of range ({$this->startRow} - {$this->endRow})");          }            --$this->position;      }              public function valid()      {          return $this->position <= $this->endRow;      }  }  