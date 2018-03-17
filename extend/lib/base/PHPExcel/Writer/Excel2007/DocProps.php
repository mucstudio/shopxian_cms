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
 */       class PHPExcel_Writer_Excel2007_DocProps extends PHPExcel_Writer_Excel2007_WriterPart  {            public function writeDocPropsApp(PHPExcel $pPHPExcel = null)      {                   $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('Properties');          $objWriter->writeAttribute('xmlns', 'http:         $objWriter->writeAttribute('xmlns:vt', 'http:                    $objWriter->writeElement('Application', 'Microsoft Excel');                     $objWriter->writeElement('DocSecurity', '0');                     $objWriter->writeElement('ScaleCrop', 'false');                     $objWriter->startElement('HeadingPairs');                     $objWriter->startElement('vt:vector');          $objWriter->writeAttribute('size', '2');          $objWriter->writeAttribute('baseType', 'variant');                     $objWriter->startElement('vt:variant');          $objWriter->writeElement('vt:lpstr', 'Worksheets');          $objWriter->endElement();                     $objWriter->startElement('vt:variant');          $objWriter->writeElement('vt:i4', $pPHPExcel->getSheetCount());          $objWriter->endElement();            $objWriter->endElement();            $objWriter->endElement();                     $objWriter->startElement('TitlesOfParts');                     $objWriter->startElement('vt:vector');          $objWriter->writeAttribute('size', $pPHPExcel->getSheetCount());          $objWriter->writeAttribute('baseType', 'lpstr');            $sheetCount = $pPHPExcel->getSheetCount();          for ($i = 0; $i < $sheetCount; ++$i) {              $objWriter->writeElement('vt:lpstr', $pPHPExcel->getSheet($i)->getTitle());          }            $objWriter->endElement();            $objWriter->endElement();                     $objWriter->writeElement('Company', $pPHPExcel->getProperties()->getCompany());                     $objWriter->writeElement('Manager', $pPHPExcel->getProperties()->getManager());                     $objWriter->writeElement('LinksUpToDate', 'false');                     $objWriter->writeElement('SharedDoc', 'false');                     $objWriter->writeElement('HyperlinksChanged', 'false');                     $objWriter->writeElement('AppVersion', '12.0000');            $objWriter->endElement();                     return $objWriter->getData();      }              public function writeDocPropsCore(PHPExcel $pPHPExcel = null)      {                   $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('cp:coreProperties');          $objWriter->writeAttribute('xmlns:cp', 'http:         $objWriter->writeAttribute('xmlns:dc', 'http:         $objWriter->writeAttribute('xmlns:dcterms', 'http:         $objWriter->writeAttribute('xmlns:dcmitype', 'http:         $objWriter->writeAttribute('xmlns:xsi', 'http:                    $objWriter->writeElement('dc:creator', $pPHPExcel->getProperties()->getCreator());                     $objWriter->writeElement('cp:lastModifiedBy', $pPHPExcel->getProperties()->getLastModifiedBy());                     $objWriter->startElement('dcterms:created');          $objWriter->writeAttribute('xsi:type', 'dcterms:W3CDTF');          $objWriter->writeRawData(date(DATE_W3C, $pPHPExcel->getProperties()->getCreated()));          $objWriter->endElement();                     $objWriter->startElement('dcterms:modified');          $objWriter->writeAttribute('xsi:type', 'dcterms:W3CDTF');          $objWriter->writeRawData(date(DATE_W3C, $pPHPExcel->getProperties()->getModified()));          $objWriter->endElement();                     $objWriter->writeElement('dc:title', $pPHPExcel->getProperties()->getTitle());                     $objWriter->writeElement('dc:description', $pPHPExcel->getProperties()->getDescription());                     $objWriter->writeElement('dc:subject', $pPHPExcel->getProperties()->getSubject());                     $objWriter->writeElement('cp:keywords', $pPHPExcel->getProperties()->getKeywords());                     $objWriter->writeElement('cp:category', $pPHPExcel->getProperties()->getCategory());            $objWriter->endElement();                     return $objWriter->getData();      }              public function writeDocPropsCustom(PHPExcel $pPHPExcel = null)      {          $customPropertyList = $pPHPExcel->getProperties()->getCustomProperties();          if (empty($customPropertyList)) {              return;          }                     $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8', 'yes');                     $objWriter->startElement('Properties');          $objWriter->writeAttribute('xmlns', 'http:         $objWriter->writeAttribute('xmlns:vt', 'http:             foreach ($customPropertyList as $key => $customProperty) {              $propertyValue = $pPHPExcel->getProperties()->getCustomPropertyValue($customProperty);              $propertyType = $pPHPExcel->getProperties()->getCustomPropertyType($customProperty);                $objWriter->startElement('property');              $objWriter->writeAttribute('fmtid', '{D5CDD505-2E9C-101B-9397-08002B2CF9AE}');              $objWriter->writeAttribute('pid', $key+2);              $objWriter->writeAttribute('name', $customProperty);                switch ($propertyType) {                  case 'i':                      $objWriter->writeElement('vt:i4', $propertyValue);                      break;                  case 'f':                      $objWriter->writeElement('vt:r8', $propertyValue);                      break;                  case 'b':                      $objWriter->writeElement('vt:bool', ($propertyValue) ? 'true' : 'false');                      break;                  case 'd':                      $objWriter->startElement('vt:filetime');                      $objWriter->writeRawData(date(DATE_W3C, $propertyValue));                      $objWriter->endElement();                      break;                  default:                      $objWriter->writeElement('vt:lpwstr', $propertyValue);                      break;              }                $objWriter->endElement();          }              $objWriter->endElement();            return $objWriter->getData();      }  }  