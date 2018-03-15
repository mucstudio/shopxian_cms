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
 */       class PHPExcel_Writer_Excel5 extends PHPExcel_Writer_Abstract implements PHPExcel_Writer_IWriter  {            private $phpExcel;              private $strTotal = 0;              private $strUnique = 0;              private $strTable = array();              private $colors;              private $parser;              private $IDCLs;              private $summaryInformation;              private $documentSummaryInformation;              public function __construct(PHPExcel $phpExcel)      {          $this->phpExcel    = $phpExcel;            $this->parser        = new PHPExcel_Writer_Excel5_Parser();      }              public function save($pFilename = null)      {                     $this->phpExcel->garbageCollect();            $saveDebugLog = PHPExcel_Calculation::getInstance($this->phpExcel)->getDebugLog()->getWriteDebugLog();          PHPExcel_Calculation::getInstance($this->phpExcel)->getDebugLog()->setWriteDebugLog(false);          $saveDateReturnType = PHPExcel_Calculation_Functions::getReturnDateType();          PHPExcel_Calculation_Functions::setReturnDateType(PHPExcel_Calculation_Functions::RETURNDATE_EXCEL);                     $this->colors = array();                     $this->writerWorkbook = new PHPExcel_Writer_Excel5_Workbook($this->phpExcel, $this->strTotal, $this->strUnique, $this->strTable, $this->colors, $this->parser);                     $countSheets = $this->phpExcel->getSheetCount();          for ($i = 0; $i < $countSheets; ++$i) {              $this->writerWorksheets[$i] = new PHPExcel_Writer_Excel5_Worksheet($this->strTotal, $this->strUnique, $this->strTable, $this->colors, $this->parser, $this->preCalculateFormulas, $this->phpExcel->getSheet($i));          }                     $this->buildWorksheetEschers();          $this->buildWorkbookEscher();                              $cellXfCollection = $this->phpExcel->getCellXfCollection();          for ($i = 0; $i < 15; ++$i) {              $this->writerWorkbook->addXfWriter($cellXfCollection[0], true);          }                     foreach ($this->phpExcel->getCellXfCollection() as $style) {              $this->writerWorkbook->addXfWriter($style, false);          }                     for ($i = 0; $i < $countSheets; ++$i) {              foreach ($this->writerWorksheets[$i]->phpSheet->getCellCollection() as $cellID) {                  $cell = $this->writerWorksheets[$i]->phpSheet->getCell($cellID);                  $cVal = $cell->getValue();                  if ($cVal instanceof PHPExcel_RichText) {                      $elements = $cVal->getRichTextElements();                      foreach ($elements as $element) {                          if ($element instanceof PHPExcel_RichText_Run) {                              $font = $element->getFont();                              $this->writerWorksheets[$i]->fontHashIndex[$font->getHashCode()] = $this->writerWorkbook->addFont($font);                          }                      }                  }              }          }                     $workbookStreamName = 'Workbook';          $OLE = new PHPExcel_Shared_OLE_PPS_File(PHPExcel_Shared_OLE::Asc2Ucs($workbookStreamName));                              $worksheetSizes = array();          for ($i = 0; $i < $countSheets; ++$i) {              $this->writerWorksheets[$i]->close();              $worksheetSizes[] = $this->writerWorksheets[$i]->_datasize;          }                     $OLE->append($this->writerWorkbook->writeWorkbook($worksheetSizes));                     for ($i = 0; $i < $countSheets; ++$i) {              $OLE->append($this->writerWorksheets[$i]->getData());          }            $this->documentSummaryInformation = $this->writeDocumentSummaryInformation();                   if (isset($this->documentSummaryInformation) && !empty($this->documentSummaryInformation)) {              $OLE_DocumentSummaryInformation = new PHPExcel_Shared_OLE_PPS_File(PHPExcel_Shared_OLE::Asc2Ucs(chr(5) . 'DocumentSummaryInformation'));              $OLE_DocumentSummaryInformation->append($this->documentSummaryInformation);          }            $this->summaryInformation = $this->writeSummaryInformation();                   if (isset($this->summaryInformation) && !empty($this->summaryInformation)) {              $OLE_SummaryInformation = new PHPExcel_Shared_OLE_PPS_File(PHPExcel_Shared_OLE::Asc2Ucs(chr(5) . 'SummaryInformation'));              $OLE_SummaryInformation->append($this->summaryInformation);          }                     $arrRootData = array($OLE);                   if (isset($OLE_SummaryInformation)) {              $arrRootData[] = $OLE_SummaryInformation;          }                   if (isset($OLE_DocumentSummaryInformation)) {              $arrRootData[] = $OLE_DocumentSummaryInformation;          }            $root = new PHPExcel_Shared_OLE_PPS_Root(time(), time(), $arrRootData);                   $res = $root->save($pFilename);            PHPExcel_Calculation_Functions::setReturnDateType($saveDateReturnType);          PHPExcel_Calculation::getInstance($this->phpExcel)->getDebugLog()->setWriteDebugLog($saveDebugLog);      }              public function setTempDir($pValue = '')      {          return $this;      }              private function buildWorksheetEschers()      {                   $blipIndex = 0;          $lastReducedSpId = 0;          $lastSpId = 0;            foreach ($this->phpExcel->getAllsheets() as $sheet) {                           $sheetIndex = $sheet->getParent()->getIndex($sheet);                $escher = null;                             $filterRange = $sheet->getAutoFilter()->getRange();              if (count($sheet->getDrawingCollection()) == 0 && empty($filterRange)) {                  continue;              }                             $escher = new PHPExcel_Shared_Escher();                             $dgContainer = new PHPExcel_Shared_Escher_DgContainer();                             $dgId = $sheet->getParent()->getIndex($sheet) + 1;              $dgContainer->setDgId($dgId);              $escher->setDgContainer($dgContainer);                             $spgrContainer = new PHPExcel_Shared_Escher_DgContainer_SpgrContainer();              $dgContainer->setSpgrContainer($spgrContainer);                             $spContainer = new PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer();              $spContainer->setSpgr(true);              $spContainer->setSpType(0);              $spContainer->setSpId(($sheet->getParent()->getIndex($sheet) + 1) << 10);              $spgrContainer->addChild($spContainer);                               $countShapes[$sheetIndex] = 0;                foreach ($sheet->getDrawingCollection() as $drawing) {                  ++$blipIndex;                    ++$countShapes[$sheetIndex];                                     $spContainer = new PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer();                                     $spContainer->setSpType(0x004B);                                   $spContainer->setSpFlag(0x02);                                     $reducedSpId = $countShapes[$sheetIndex];                  $spId = $reducedSpId                      | ($sheet->getParent()->getIndex($sheet) + 1) << 10;                  $spContainer->setSpId($spId);                                     $lastReducedSpId = $reducedSpId;                                     $lastSpId = $spId;                                     $spContainer->setOPT(0x4104, $blipIndex);                                     $coordinates = $drawing->getCoordinates();                  $offsetX = $drawing->getOffsetX();                  $offsetY = $drawing->getOffsetY();                  $width = $drawing->getWidth();                  $height = $drawing->getHeight();                    $twoAnchor = PHPExcel_Shared_Excel5::oneAnchor2twoAnchor($sheet, $coordinates, $offsetX, $offsetY, $width, $height);                    $spContainer->setStartCoordinates($twoAnchor['startCoordinates']);                  $spContainer->setStartOffsetX($twoAnchor['startOffsetX']);                  $spContainer->setStartOffsetY($twoAnchor['startOffsetY']);                  $spContainer->setEndCoordinates($twoAnchor['endCoordinates']);                  $spContainer->setEndOffsetX($twoAnchor['endOffsetX']);                  $spContainer->setEndOffsetY($twoAnchor['endOffsetY']);                    $spgrContainer->addChild($spContainer);              }                             if (!empty($filterRange)) {                  $rangeBounds = PHPExcel_Cell::rangeBoundaries($filterRange);                  $iNumColStart = $rangeBounds[0][0];                  $iNumColEnd = $rangeBounds[1][0];                    $iInc = $iNumColStart;                  while ($iInc <= $iNumColEnd) {                      ++$countShapes[$sheetIndex];                                             $oDrawing  = new PHPExcel_Worksheet_BaseDrawing();                                           $cDrawing   = PHPExcel_Cell::stringFromColumnIndex($iInc - 1) . $rangeBounds[0][1];                      $oDrawing->setCoordinates($cDrawing);                      $oDrawing->setWorksheet($sheet);                                             $spContainer = new PHPExcel_Shared_Escher_DgContainer_SpgrContainer_SpContainer();                                           $spContainer->setSpType(0x00C9);                                           $spContainer->setSpFlag(0x01);                                             $reducedSpId = $countShapes[$sheetIndex];                      $spId = $reducedSpId                          | ($sheet->getParent()->getIndex($sheet) + 1) << 10;                      $spContainer->setSpId($spId);                                             $lastReducedSpId = $reducedSpId;                                             $lastSpId = $spId;                        $spContainer->setOPT(0x007F, 0x01040104);                      $spContainer->setOPT(0x00BF, 0x00080008);                      $spContainer->setOPT(0x01BF, 0x00010000);                      $spContainer->setOPT(0x01FF, 0x00080000);                      $spContainer->setOPT(0x03BF, 0x000A0000);                                             $endCoordinates = PHPExcel_Cell::stringFromColumnIndex(PHPExcel_Cell::stringFromColumnIndex($iInc - 1));                      $endCoordinates .= $rangeBounds[0][1] + 1;                        $spContainer->setStartCoordinates($cDrawing);                      $spContainer->setStartOffsetX(0);                      $spContainer->setStartOffsetY(0);                      $spContainer->setEndCoordinates($endCoordinates);                      $spContainer->setEndOffsetX(0);                      $spContainer->setEndOffsetY(0);                        $spgrContainer->addChild($spContainer);                      $iInc++;                  }              }                             $this->IDCLs[$dgId] = $lastReducedSpId;                             $dgContainer->setLastSpId($lastSpId);                             $this->writerWorksheets[$sheetIndex]->setEscher($escher);          }      }              private function buildWorkbookEscher()      {          $escher = null;                     $found = false;          foreach ($this->phpExcel->getAllSheets() as $sheet) {              if (count($sheet->getDrawingCollection()) > 0) {                  $found = true;                  break;              }          }                     if (!$found) {              return;          }                     $escher = new PHPExcel_Shared_Escher();                     $dggContainer = new PHPExcel_Shared_Escher_DggContainer();          $escher->setDggContainer($dggContainer);                     $dggContainer->setIDCLs($this->IDCLs);                     $spIdMax = 0;          $totalCountShapes = 0;          $countDrawings = 0;            foreach ($this->phpExcel->getAllsheets() as $sheet) {              $sheetCountShapes = 0;                if (count($sheet->getDrawingCollection()) > 0) {                  ++$countDrawings;                    foreach ($sheet->getDrawingCollection() as $drawing) {                      ++$sheetCountShapes;                      ++$totalCountShapes;                        $spId = $sheetCountShapes | ($this->phpExcel->getIndex($sheet) + 1) << 10;                      $spIdMax = max($spId, $spIdMax);                  }              }          }            $dggContainer->setSpIdMax($spIdMax + 1);          $dggContainer->setCDgSaved($countDrawings);          $dggContainer->setCSpSaved($totalCountShapes + $countDrawings);                     $bstoreContainer = new PHPExcel_Shared_Escher_DggContainer_BstoreContainer();          $dggContainer->setBstoreContainer($bstoreContainer);                     foreach ($this->phpExcel->getAllsheets() as $sheet) {              foreach ($sheet->getDrawingCollection() as $drawing) {                  if ($drawing instanceof PHPExcel_Worksheet_Drawing) {                      $filename = $drawing->getPath();                        list($imagesx, $imagesy, $imageFormat) = getimagesize($filename);                        switch ($imageFormat) {                          case 1:                              $blipType = PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE::BLIPTYPE_PNG;                              ob_start();                              imagepng(imagecreatefromgif($filename));                              $blipData = ob_get_contents();                              ob_end_clean();                              break;                          case 2:                              $blipType = PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE::BLIPTYPE_JPEG;                              $blipData = file_get_contents($filename);                              break;                          case 3:                              $blipType = PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE::BLIPTYPE_PNG;                              $blipData = file_get_contents($filename);                              break;                          case 6:                              $blipType = PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE::BLIPTYPE_PNG;                              ob_start();                              imagepng(PHPExcel_Shared_Drawing::imagecreatefrombmp($filename));                              $blipData = ob_get_contents();                              ob_end_clean();                              break;                          default:                              continue 2;                      }                        $blip = new PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE_Blip();                      $blip->setData($blipData);                        $BSE = new PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE();                      $BSE->setBlipType($blipType);                      $BSE->setBlip($blip);                        $bstoreContainer->addBSE($BSE);                  } elseif ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {                      switch ($drawing->getRenderingFunction()) {                          case PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG:                              $blipType = PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE::BLIPTYPE_JPEG;                              $renderingFunction = 'imagejpeg';                              break;                          case PHPExcel_Worksheet_MemoryDrawing::RENDERING_GIF:                          case PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG:                          case PHPExcel_Worksheet_MemoryDrawing::RENDERING_DEFAULT:                              $blipType = PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE::BLIPTYPE_PNG;                              $renderingFunction = 'imagepng';                              break;                      }                        ob_start();                      call_user_func($renderingFunction, $drawing->getImageResource());                      $blipData = ob_get_contents();                      ob_end_clean();                        $blip = new PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE_Blip();                      $blip->setData($blipData);                        $BSE = new PHPExcel_Shared_Escher_DggContainer_BstoreContainer_BSE();                      $BSE->setBlipType($blipType);                      $BSE->setBlip($blip);                        $bstoreContainer->addBSE($BSE);                  }              }          }                     $this->writerWorkbook->setEscher($escher);      }              private function writeDocumentSummaryInformation()      {                   $data = pack('v', 0xFFFE);                   $data .= pack('v', 0x0000);                   $data .= pack('v', 0x0106);                   $data .= pack('v', 0x0002);                   $data .= pack('VVVV', 0x00, 0x00, 0x00, 0x00);                   $data .= pack('V', 0x0001);                     $data .= pack('vvvvvvvv', 0xD502, 0xD5CD, 0x2E9C, 0x101B, 0x9793, 0x0008, 0x2C2B, 0xAEF9);                   $data .= pack('V', 0x30);                     $dataSection = array();          $dataSection_NumProps = 0;          $dataSection_Summary = '';          $dataSection_Content = '';                     $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x01),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x02),                                 'data'    => array('data' => 1252));          $dataSection_NumProps++;                     if ($this->phpExcel->getProperties()->getCategory()) {              $dataProp = $this->phpExcel->getProperties()->getCategory();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x02),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x1E),                                     'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));              $dataSection_NumProps++;          }                   $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x17),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x03),                                 'data'    => array('pack' => 'V', 'data' => 0x000C0000));          $dataSection_NumProps++;                   $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x0B),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x0B),                                 'data'    => array('data' => false));          $dataSection_NumProps++;                   $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x10),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x0B),                                 'data'    => array('data' => false));          $dataSection_NumProps++;                   $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x13),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x0B),                                 'data'    => array('data' => false));          $dataSection_NumProps++;                   $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x16),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x0B),                                 'data'    => array('data' => false));          $dataSection_NumProps++;                                                $dataProp = pack('v', 0x0001);          $dataProp .= pack('v', 0x0000);                                $dataProp .= pack('v', 0x000A);            $dataProp .= pack('v', 0x0000);                       $dataProp .= 'Worksheet'.chr(0);            $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x0D),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x101E),                                 'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));          $dataSection_NumProps++;                                           $dataProp = pack('v', 0x0002);            $dataProp .= pack('v', 0x0000);                                                       $dataProp .= pack('v', 0x001E);                               $dataProp .= pack('v', 0x0000);                                                  $dataProp .= pack('v', 0x0013);                  $dataProp .= pack('v', 0x0000);                                   $dataProp .= 'Feuilles de calcul';                                            $dataProp .= pack('v', 0x0300);                               $dataProp .= pack('v', 0x0000);                               $dataProp .= pack('v', 0x0100);                $dataProp .= pack('v', 0x0000);                $dataProp .= pack('v', 0x0000);                $dataProp .= pack('v', 0x0000);            $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x0C),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x100C),                                 'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));          $dataSection_NumProps++;                                       $dataSection_Content_Offset = 8 + $dataSection_NumProps * 8;          foreach ($dataSection as $dataProp) {                           $dataSection_Summary .= pack($dataProp['summary']['pack'], $dataProp['summary']['data']);                           $dataSection_Summary .= pack($dataProp['offset']['pack'], $dataSection_Content_Offset);                           $dataSection_Content .= pack($dataProp['type']['pack'], $dataProp['type']['data']);                           if ($dataProp['type']['data'] == 0x02) {                  $dataSection_Content .= pack('V', $dataProp['data']['data']);                    $dataSection_Content_Offset += 4 + 4;              } elseif ($dataProp['type']['data'] == 0x03) {                  $dataSection_Content .= pack('V', $dataProp['data']['data']);                    $dataSection_Content_Offset += 4 + 4;              } elseif ($dataProp['type']['data'] == 0x0B) {                  if ($dataProp['data']['data'] == false) {                      $dataSection_Content .= pack('V', 0x0000);                  } else {                      $dataSection_Content .= pack('V', 0x0001);                  }                  $dataSection_Content_Offset += 4 + 4;              } elseif ($dataProp['type']['data'] == 0x1E) {                                   $dataProp['data']['data'] .= chr(0);                  $dataProp['data']['length'] += 1;                                   $dataProp['data']['length'] = $dataProp['data']['length'] + ((4 - $dataProp['data']['length'] % 4)==4 ? 0 : (4 - $dataProp['data']['length'] % 4));                  $dataProp['data']['data'] = str_pad($dataProp['data']['data'], $dataProp['data']['length'], chr(0), STR_PAD_RIGHT);                    $dataSection_Content .= pack('V', $dataProp['data']['length']);                  $dataSection_Content .= $dataProp['data']['data'];                    $dataSection_Content_Offset += 4 + 4 + strlen($dataProp['data']['data']);              } elseif ($dataProp['type']['data'] == 0x40) {                  $dataSection_Content .= $dataProp['data']['data'];                    $dataSection_Content_Offset += 4 + 8;              } else {                                   $dataSection_Content .= $dataProp['data']['data'];                    $dataSection_Content_Offset += 4 + $dataProp['data']['length'];              }          }                                                $data .= pack('V', $dataSection_Content_Offset);                   $data .= pack('V', $dataSection_NumProps);                   $data .= $dataSection_Summary;                   $data .= $dataSection_Content;            return $data;      }              private function writeSummaryInformation()      {                   $data = pack('v', 0xFFFE);                   $data .= pack('v', 0x0000);                   $data .= pack('v', 0x0106);                   $data .= pack('v', 0x0002);                   $data .= pack('VVVV', 0x00, 0x00, 0x00, 0x00);                   $data .= pack('V', 0x0001);                     $data .= pack('vvvvvvvv', 0x85E0, 0xF29F, 0x4FF9, 0x1068, 0x91AB, 0x0008, 0x272B, 0xD9B3);                   $data .= pack('V', 0x30);                     $dataSection = array();          $dataSection_NumProps = 0;          $dataSection_Summary = '';          $dataSection_Content = '';                     $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x01),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x02),                                 'data'    => array('data' => 1252));          $dataSection_NumProps++;                     if ($this->phpExcel->getProperties()->getTitle()) {              $dataProp = $this->phpExcel->getProperties()->getTitle();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x02),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x1E),                                     'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));              $dataSection_NumProps++;          }                   if ($this->phpExcel->getProperties()->getSubject()) {              $dataProp = $this->phpExcel->getProperties()->getSubject();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x03),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x1E),                                     'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));              $dataSection_NumProps++;          }                   if ($this->phpExcel->getProperties()->getCreator()) {              $dataProp = $this->phpExcel->getProperties()->getCreator();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x04),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x1E),                                     'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));              $dataSection_NumProps++;          }                   if ($this->phpExcel->getProperties()->getKeywords()) {              $dataProp = $this->phpExcel->getProperties()->getKeywords();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x05),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x1E),                                     'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));              $dataSection_NumProps++;          }                   if ($this->phpExcel->getProperties()->getDescription()) {              $dataProp = $this->phpExcel->getProperties()->getDescription();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x06),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x1E),                                     'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));              $dataSection_NumProps++;          }                   if ($this->phpExcel->getProperties()->getLastModifiedBy()) {              $dataProp = $this->phpExcel->getProperties()->getLastModifiedBy();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x08),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x1E),                                     'data'    => array('data' => $dataProp, 'length' => strlen($dataProp)));              $dataSection_NumProps++;          }                   if ($this->phpExcel->getProperties()->getCreated()) {              $dataProp = $this->phpExcel->getProperties()->getCreated();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x0C),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x40),                                     'data'    => array('data' => PHPExcel_Shared_OLE::LocalDate2OLE($dataProp)));              $dataSection_NumProps++;          }                   if ($this->phpExcel->getProperties()->getModified()) {              $dataProp = $this->phpExcel->getProperties()->getModified();              $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x0D),                                     'offset' => array('pack' => 'V'),                                     'type'     => array('pack' => 'V', 'data' => 0x40),                                     'data'    => array('data' => PHPExcel_Shared_OLE::LocalDate2OLE($dataProp)));              $dataSection_NumProps++;          }                   $dataSection[] = array('summary'=> array('pack' => 'V', 'data' => 0x13),                                 'offset' => array('pack' => 'V'),                                 'type'     => array('pack' => 'V', 'data' => 0x03),                                 'data'    => array('data' => 0x00));          $dataSection_NumProps++;                                         $dataSection_Content_Offset = 8 + $dataSection_NumProps * 8;          foreach ($dataSection as $dataProp) {                           $dataSection_Summary .= pack($dataProp['summary']['pack'], $dataProp['summary']['data']);                           $dataSection_Summary .= pack($dataProp['offset']['pack'], $dataSection_Content_Offset);                           $dataSection_Content .= pack($dataProp['type']['pack'], $dataProp['type']['data']);                           if ($dataProp['type']['data'] == 0x02) {                  $dataSection_Content .= pack('V', $dataProp['data']['data']);                    $dataSection_Content_Offset += 4 + 4;              } elseif ($dataProp['type']['data'] == 0x03) {                  $dataSection_Content .= pack('V', $dataProp['data']['data']);                    $dataSection_Content_Offset += 4 + 4;              } elseif ($dataProp['type']['data'] == 0x1E) {                                   $dataProp['data']['data'] .= chr(0);                  $dataProp['data']['length'] += 1;                                   $dataProp['data']['length'] = $dataProp['data']['length'] + ((4 - $dataProp['data']['length'] % 4)==4 ? 0 : (4 - $dataProp['data']['length'] % 4));                  $dataProp['data']['data'] = str_pad($dataProp['data']['data'], $dataProp['data']['length'], chr(0), STR_PAD_RIGHT);                    $dataSection_Content .= pack('V', $dataProp['data']['length']);                  $dataSection_Content .= $dataProp['data']['data'];                    $dataSection_Content_Offset += 4 + 4 + strlen($dataProp['data']['data']);              } elseif ($dataProp['type']['data'] == 0x40) {                  $dataSection_Content .= $dataProp['data']['data'];                    $dataSection_Content_Offset += 4 + 8;              } else {                               }          }                                                $data .= pack('V', $dataSection_Content_Offset);                   $data .= pack('V', $dataSection_NumProps);                   $data .= $dataSection_Summary;                   $data .= $dataSection_Content;            return $data;      }  }  