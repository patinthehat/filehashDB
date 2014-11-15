<?php

require_once('BaseHashDB.php');

class HashDBIni extends BaseHashDB {
  
    
  /**
   * Initializes the HashDB file.  Called by HashDB->load().
   */
  protected function init() {
    if (!file_exists($this->filename))
      $this->write("[db]\n");
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
  
  public function getHash($filename) {
    if (!isset($this->data[$filename]))
      return FALSE;
    return $this->data[$filename];
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
  
}