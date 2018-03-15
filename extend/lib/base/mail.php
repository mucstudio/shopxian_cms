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
 */   namespace lib\base;      class mail {            private $_userName;            private $_password;            protected $_sendServer;            protected $_port=25;            protected $_from;            protected $_to;            protected $_cc;            protected $_bcc;            protected $_subject;            protected $_body;            protected $_attachment;            protected $_socket;            protected $_errorMessage;            public function setServer($server, $username="", $password="", $port=25) {          $this->_sendServer = $server;          $this->_port = $port;          if(!empty($username)) {              $this->_userName = base64_encode($username);          }          if(!empty($password)) {              $this->_password = base64_encode($password);          }          return true;      }            public function setFrom($from) {          $this->_from = $from;          return true;      }            public function setReceiver($to) {          if(isset($this->_to)) {              if(is_string($this->_to)) {                  $this->_to = array($this->_to);                  $this->_to[] = $to;                  return true;              }              elseif(is_array($this->_to)) {                  $this->_to[] = $to;                  return true;              }              else {                  return false;              }          }          else {              $this->_to = $to;              return true;          }      }            public function setCc($cc) {          if(isset($this->_cc)) {              if(is_string($this->_cc)) {                  $this->_cc = array($this->_cc);                  $this->_cc[] = $cc;                  return true;              }              elseif(is_array($this->_cc)) {                  $this->_cc[] = $cc;                  return true;              }              else {                  return false;              }          }          else {              $this->_cc = $cc;              return true;          }      }            public function setBcc($bcc) {          if(isset($this->_bcc)) {              if(is_string($this->_bcc)) {                  $this->_bcc = array($this->_bcc);                  $this->_bcc[] = $bcc;                  return true;              }              elseif(is_array($this->_bcc)) {                  $this->_bcc[] = $bcc;                  return true;              }              else {                  return false;              }          }          else {              $this->_bcc = $bcc;              return true;          }      }            public function setMailInfo($subject, $body, $attachment="") {          $this->_subject = $subject;          $this->_body = base64_encode($body);          if(!empty($attachment)) {              $this->_attachment = $attachment;          }          return true;      }            public function sendMail() {          $command = $this->getCommand();          $this->socket();          foreach ($command as $value) {              if($this->sendCommand($value[0], $value[1])) {                  continue;              }              else{                  return false;              }          }                   $this->close();           echo 'Mail OK!';          return true;      }            public function error(){          if(!isset($this->_errorMessage)) {              $this->_errorMessage = "";          }          return $this->_errorMessage;      }            protected function getCommand() {          $command = array(                  array("HELO sendmail\r\n", 250)              );          if(!empty($this->_userName)){              $command[] = array("AUTH LOGIN\r\n", 334);              $command[] = array($this->_userName . "\r\n", 334);              $command[] = array($this->_password . "\r\n", 235);          }          $command[] = array("MAIL FROM:<" . $this->_from . ">\r\n", 250);          $separator = "----=_Part_" . md5($this->_from . time()) . uniqid();                   $header = "FROM: test<" . $this->_from . ">\r\n";                   if(is_array($this->_to)) {              $count = count($this->_to);              for($i=0; $i<$count; $i++){                  $command[] = array("RCPT TO: <" . $this->_to[$i] . ">\r\n", 250);                  if($i == 0){                      $header .= "TO: <" . $this->_to[$i] .">";                  }                  elseif($i + 1 == $count){                      $header .= ",<" . $this->_to[$i] .">\r\n";                  }                  else{                      $header .= ",<" . $this->_to[$i] .">";                  }              }          }          else{              $command[] = array("RCPT TO: <" . $this->_to . ">\r\n", 250);              $header .= "TO: <" . $this->_to . ">\r\n";          }                   if(isset($this->_cc)) {              if(is_array($this->_cc)) {                  $count = count($this->_cc);                  for($i=0; $i<$count; $i++){                      $command[] = array("RCPT TO: <" . $this->_cc[$i] . ">\r\n", 250);                      if($i == 0){                      $header .= "CC: <" . $this->_cc[$i] .">";                      }                      elseif($i + 1 == $count){                          $header .= ",<" . $this->_cc[$i] .">\r\n";                      }                      else{                          $header .= ",<" . $this->_cc[$i] .">";                      }                  }              }              else{                  $command[] = array("RCPT TO: <" . $this->_cc . ">\r\n", 250);                  $header .= "CC: <" . $this->_cc . ">\r\n";              }          }                   if(isset($this->_bcc)) {              if(is_array($this->_bcc)) {                  $count = count($this->_bcc);                  for($i=0; $i<$count; $i++){                      $command[] = array("RCPT TO: <" . $this->_bcc[$i] . ">\r\n", 250);                      if($i == 0){                      $header .= "BCC: <" . $this->_bcc[$i] .">";                      }                      elseif($i + 1 == $count){                          $header .= ",<" . $this->_bcc[$i] .">\r\n";                      }                      else{                          $header .= ",<" . $this->_bcc[$i] .">";                      }                  }              }              else{                  $command[] = array("RCPT TO: <" . $this->_bcc . ">\r\n", 250);                  $header .= "BCC: <" . $this->_bcc . ">\r\n";              }          }          $header .= "Subject: " . $this->_subject ."\r\n";          if(isset($this->_attachment)) {                           $header .= "Content-Type: multipart/mixed;\r\n";          }          elseif(false){                           $header .= "Content-Type: multipart/related;\r\n";          }          else{                           $header .= "Content-Type: multipart/alternative;\r\n";          }                   $header .= "\t" . 'boundary="' . $separator . '"';          $header .= "\r\nMIME-Version: 1.0\r\n";          $header .= "\r\n--" . $separator . "\r\n";          $header .= "Content-Type:text/html; charset=utf-8\r\n";          $header .= "Content-Transfer-Encoding: base64\r\n\r\n";          $header .= $this->_body . "\r\n";          $header .= "--" . $separator . "\r\n";                   if(isset($this->_attachment)){              $header .= "\r\n--" . $separator . "\r\n";              $header .= "Content-Type: " . $this->getMIMEType() . '; name="' . basename($this->_attachment) . '"' . "\r\n";              $header .= "Content-Transfer-Encoding: base64\r\n";              $header .= 'Content-Disposition: attachment; filename="' . basename($this->_attachment) . '"' . "\r\n";              $header .= "\r\n";              $header .= $this->readFile();              $header .= "\r\n--" . $separator . "\r\n";          }          $header .= "\r\n.\r\n";          $command[] = array("DATA\r\n", 354);          $command[] = array($header, 250);          $command[] = array("QUIT\r\n", 221);          return $command;      }            protected function sendCommand($command, $code) {          echo 'Send command:' . $command . ',expected code:' . $code . '<br />';                   try{              if(socket_write($this->_socket, $command, strlen($command))){                                   if(empty($code))  {                      return true;                  }                                   $data = trim(socket_read($this->_socket, 1024));                  echo 'response:' . $data . '<br /><br />';                  if($data) {                      $pattern = "/^".$code."/";                      if(preg_match($pattern, $data)) {                          return true;                      }                      else{                          $this->_errorMessage = "Error:" . $data . "|**| command:";                          return false;                      }                  }                  else{                      $this->_errorMessage = "Error:" . socket_strerror(socket_last_error());                      return false;                  }              }              else{                  $this->_errorMessage = "Error:" . socket_strerror(socket_last_error());                  return false;              }          }catch(Exception $e) {              $this->_errorMessage = "Error:" . $e->getMessage();          }      }            protected function readFile() {          if(isset($this->_attachment) && file_exists($this->_attachment)) {              $file = file_get_contents($this->_attachment);              return base64_encode($file);          }          else {              return false;          }      }            protected function getMIMEType() {          if(isset($this->_attachment) && file_exists($this->_attachment)) {              $mime = mime_content_type($this->_attachment);              if(! preg_match("/gif|jpg|png|jpeg/", $mime)){                  $mime = "application/octet-stream";              }              return $mime;          }          else {              return false;          }      }            private function socket() {          if(!function_exists("socket_create")) {              $this->_errorMessage = "Extension sockets must be enabled";              return false;          }                   $this->_socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));          if(!$this->_socket) {              $this->_errorMessage = socket_strerror(socket_last_error());              return false;          }          socket_set_block($this->_socket);                  if(!socket_connect($this->_socket, $this->_sendServer, $this->_port)) {              $this->_errorMessage = socket_strerror(socket_last_error());              return false;          }          socket_read($this->_socket, 1024);          return true;      }            private function close() {          if(isset($this->_socket) && is_object($this->_socket)) {              $this->_socket->close();              return true;          }          $this->_errorMessage = "No resource can to be close";          return false;      }   }