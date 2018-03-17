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
 */       class PHPExcel_Writer_Excel2007_Rels extends PHPExcel_Writer_Excel2007_WriterPart  {            public function writeRelationships(PHPExcel $pPHPExcel = null)      {                   $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('Relationships');          $objWriter->writeAttribute('xmlns', 'http:           $customPropertyList = $pPHPExcel->getProperties()->getCustomProperties();          if (!empty($customPropertyList)) {                           $this->writeRelationship(                  $objWriter,                  4,                  'http:                 'docProps/custom.xml'              );            }                     $this->writeRelationship(              $objWriter,              3,              'http:             'docProps/app.xml'          );                     $this->writeRelationship(              $objWriter,              2,              'http:             'docProps/core.xml'          );                     $this->writeRelationship(              $objWriter,              1,              'http:             'xl/workbook.xml'          );                   if ($pPHPExcel->hasRibbon()) {              $this->writeRelationShip(                  $objWriter,                  5,                  'http:                 $pPHPExcel->getRibbonXMLData('target')              );          }            $objWriter->endElement();            return $objWriter->getData();      }              public function writeWorkbookRelationships(PHPExcel $pPHPExcel = null)      {                   $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('Relationships');          $objWriter->writeAttribute('xmlns', 'http:                    $this->writeRelationship(              $objWriter,              1,              'http:             'styles.xml'          );                     $this->writeRelationship(              $objWriter,              2,              'http:             'theme/theme1.xml'          );                     $this->writeRelationship(              $objWriter,              3,              'http:             'sharedStrings.xml'          );                     $sheetCount = $pPHPExcel->getSheetCount();          for ($i = 0; $i < $sheetCount; ++$i) {              $this->writeRelationship(                  $objWriter,                  ($i + 1 + 3),                  'http:                 'worksheets/sheet' . ($i + 1) . '.xml'              );          }                            if ($pPHPExcel->hasMacros()) {              $this->writeRelationShip(                  $objWriter,                  ($i + 1 + 3),                  'http:                 'vbaProject.bin'              );              ++$i;         }            $objWriter->endElement();            return $objWriter->getData();      }              public function writeWorksheetRelationships(PHPExcel_Worksheet $pWorksheet = null, $pWorksheetId = 1, $includeCharts = false)      {                   $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('Relationships');          $objWriter->writeAttribute('xmlns', 'http:                    $d = 0;          if ($includeCharts) {              $charts = $pWorksheet->getChartCollection();          } else {              $charts = array();          }          if (($pWorksheet->getDrawingCollection()->count() > 0) ||              (count($charts) > 0)) {              $this->writeRelationship(                  $objWriter,                  ++$d,                  'http:                 '../drawings/drawing' . $pWorksheetId . '.xml'              );          }                                            $i = 1;          foreach ($pWorksheet->getHyperlinkCollection() as $hyperlink) {              if (!$hyperlink->isInternal()) {                  $this->writeRelationship(                      $objWriter,                      '_hyperlink_' . $i,                      'http:                     $hyperlink->getUrl(),                      'External'                  );                    ++$i;              }          }                     $i = 1;          if (count($pWorksheet->getComments()) > 0) {              $this->writeRelationship(                  $objWriter,                  '_comments_vml' . $i,                  'http:                 '../drawings/vmlDrawing' . $pWorksheetId . '.vml'              );                $this->writeRelationship(                  $objWriter,                  '_comments' . $i,                  'http:                 '../comments' . $pWorksheetId . '.xml'              );          }                     $i = 1;          if (count($pWorksheet->getHeaderFooter()->getImages()) > 0) {              $this->writeRelationship(                  $objWriter,                  '_headerfooter_vml' . $i,                  'http:                 '../drawings/vmlDrawingHF' . $pWorksheetId . '.vml'              );          }            $objWriter->endElement();            return $objWriter->getData();      }              public function writeDrawingRelationships(PHPExcel_Worksheet $pWorksheet = null, &$chartRef, $includeCharts = false)      {                   $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('Relationships');          $objWriter->writeAttribute('xmlns', 'http:                    $i = 1;          $iterator = $pWorksheet->getDrawingCollection()->getIterator();          while ($iterator->valid()) {              if ($iterator->current() instanceof PHPExcel_Worksheet_Drawing                  || $iterator->current() instanceof PHPExcel_Worksheet_MemoryDrawing) {                                   $this->writeRelationship(                      $objWriter,                      $i,                      'http:                     '../media/' . str_replace(' ', '', $iterator->current()->getIndexedFilename())                  );              }                $iterator->next();              ++$i;          }            if ($includeCharts) {                           $chartCount = $pWorksheet->getChartCount();              if ($chartCount > 0) {                  for ($c = 0; $c < $chartCount; ++$c) {                      $this->writeRelationship(                          $objWriter,                          $i++,                          'http:                         '../charts/chart' . ++$chartRef . '.xml'                      );                  }              }          }            $objWriter->endElement();            return $objWriter->getData();      }              public function writeHeaderFooterDrawingRelationships(PHPExcel_Worksheet $pWorksheet = null)      {                   $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('Relationships');          $objWriter->writeAttribute('xmlns', 'http:                    foreach ($pWorksheet->getHeaderFooter()->getImages() as $key => $value) {                           $this->writeRelationship(                  $objWriter,                  $key,                  'http:                 '../media/' . $value->getIndexedFilename()              );          }            $objWriter->endElement();            return $objWriter->getData();      }              private function writeRelationship(PHPExcel_Shared_XMLWriter $objWriter = null, $pId = 1, $pType = '', $pTarget = '', $pTargetMode = '')      {          if ($pType != '' && $pTarget != '') {                           $objWriter->startElement('Relationship');              $objWriter->writeAttribute('Id', 'rId' . $pId);              $objWriter->writeAttribute('Type', $pType);              $objWriter->writeAttribute('Target', $pTarget);                if ($pTargetMode != '') {                  $objWriter->writeAttribute('TargetMode', $pTargetMode);              }                $objWriter->endElement();          } else {              throw new PHPExcel_Writer_Exception("Invalid parameters passed.");          }      }  }  