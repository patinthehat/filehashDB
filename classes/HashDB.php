<?php

class HashDB {
  
  protected $filename;
  protected $data;
  
  protected function write($data) {
    if (strlen($this->filename) > 0) {
      file_put_contents($this->filename, $data);
      return TRUE;
    }
    return FALSE;
  }
  
  protected function init() {
    if (!file_exists($this->filename))
      $this->write("[db]\n");
  }
  
  public function __construct($filename) {
    $this->filename = $filename;
  }
    
  public function load() {
    $this->init();
    $this->data = parse_ini_file($this->filename); 
  }
  
  public function save($sorted = TRUE) {
    $output = "[db]\n";
    if ($sorted)
      ksort($this->data);
    
    foreach($this->data as $n=>$hash) {
      if ($hash !== 0)
        $output .= "$n=$hash\n";
    }
    
    $this->write($output);
  }
  
  public function getDatabaseFilename() {
    return $this->filename;  
  }
  
  public function getHash($filename) {
    if (!isset($this->data[$filename]))
      return FALSE;
    return $this->data[$filename];    
  }
  
  public function compareHash(FileHash $fh) {
    echo "oldhash fn = ".$fh->getFilename().PHP_EOL;
    $oldhash = $this->getHash($fh->getFilename());
    echo $oldhash . PHP_EOL;
    echo "newhash = ".$fh->getHash().PHP_EOL;
    if ($oldhash === $fh->getHash()) 
      return TRUE;
    return FALSE;    
  }
  
  public function setHash(FileHash $fh) {
    $fn = $fh->getFilename();
    $hash = $fh->getHash();
    $this->data[$fn] = $hash;
  }
  
  public function removeFile($filename) {
    if (isset($this->data[$filename])) {
      unset($this->data[$filename]);
      return TRUE;
    }
    return FALSE;
  }
  
  public function dump() {
    print_r($this->data);    
  }
}