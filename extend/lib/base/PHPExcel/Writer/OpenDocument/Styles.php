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
 */       class PHPExcel_Writer_OpenDocument_Styles extends PHPExcel_Writer_OpenDocument_WriterPart  {            public function write(PHPExcel $pPHPExcel = null)      {          if (!$pPHPExcel) {              $pPHPExcel = $this->getParentWriter()->getPHPExcel();          }            $objWriter = null;          if ($this->getParentWriter()->getUseDiskCaching()) {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());          } else {              $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);          }                     $objWriter->startDocument('1.0', 'UTF-8');                     $objWriter->startElement('office:document-styles');              $objWriter->writeAttribute('xmlns:office', 'urn:oasis:names:tc:opendocument:xmlns:office:1.0');              $objWriter->writeAttribute('xmlns:style', 'urn:oasis:names:tc:opendocument:xmlns:style:1.0');              $objWriter->writeAttribute('xmlns:text', 'urn:oasis:names:tc:opendocument:xmlns:text:1.0');              $objWriter->writeAttribute('xmlns:table', 'urn:oasis:names:tc:opendocument:xmlns:table:1.0');              $objWriter->writeAttribute('xmlns:draw', 'urn:oasis:names:tc:opendocument:xmlns:drawing:1.0');              $objWriter->writeAttribute('xmlns:fo', 'urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0');              $objWriter->writeAttribute('xmlns:xlink', 'http:             $objWriter->writeAttribute('xmlns:dc', 'http:             $objWriter->writeAttribute('xmlns:meta', 'urn:oasis:names:tc:opendocument:xmlns:meta:1.0');              $objWriter->writeAttribute('xmlns:number', 'urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0');              $objWriter->writeAttribute('xmlns:presentation', 'urn:oasis:names:tc:opendocument:xmlns:presentation:1.0');              $objWriter->writeAttribute('xmlns:svg', 'urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0');              $objWriter->writeAttribute('xmlns:chart', 'urn:oasis:names:tc:opendocument:xmlns:chart:1.0');              $objWriter->writeAttribute('xmlns:dr3d', 'urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0');              $objWriter->writeAttribute('xmlns:math', 'http:             $objWriter->writeAttribute('xmlns:form', 'urn:oasis:names:tc:opendocument:xmlns:form:1.0');              $objWriter->writeAttribute('xmlns:script', 'urn:oasis:names:tc:opendocument:xmlns:script:1.0');              $objWriter->writeAttribute('xmlns:ooo', 'http:             $objWriter->writeAttribute('xmlns:ooow', 'http:             $objWriter->writeAttribute('xmlns:oooc', 'http:             $objWriter->writeAttribute('xmlns:dom', 'http:             $objWriter->writeAttribute('xmlns:rpt', 'http:             $objWriter->writeAttribute('xmlns:of', 'urn:oasis:names:tc:opendocument:xmlns:of:1.2');              $objWriter->writeAttribute('xmlns:xhtml', 'http:             $objWriter->writeAttribute('xmlns:grddl', 'http:             $objWriter->writeAttribute('xmlns:tableooo', 'http:             $objWriter->writeAttribute('xmlns:css3t', 'http:             $objWriter->writeAttribute('office:version', '1.2');                $objWriter->writeElement('office:font-face-decls');              $objWriter->writeElement('office:styles');              $objWriter->writeElement('office:automatic-styles');              $objWriter->writeElement('office:master-styles');          $objWriter->endElement();            return $objWriter->getData();      }  }  