<?php

require_once('BaseHashDB.php');

class HashDBXml extends BaseHashDB {
  
  /**
   * Initializes the HashDB file.  Called by HashDB->load().
   */
  protected function init() {
    if (!file_exists($this->filename))
      $this->write("<?xml version='1.0'?>\n\n<db>\n</db>");
  }  
  
  public function load() {
    $this->init();
    //$this->data = new SimpleXMLElement(file_get_contents($this->filename));
    $this->data = simplexml_load_file($this->filename);
  }
  
  public function save($sorted = TRUE) {
    $this->write($this->data->asXML());
    return true;
    
    $output = "'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n\n<db>\n";
    //if ($sorted)
    //  ksort($this->data);
    
    foreach($this->data as $n=>$hash) {
      if ($hash !== 0)
        $output .= "<file>\n\t<name>$n</name>\n\t<hash>$hash</hash>\n</file>\n";
    }
    
    $output .= "\n</db>";
        
    $this->write($output);
    //$this->load();
  }
  
  public function getHash($filename) {

    foreach($this->data->file as $file) {
      print_r($file);
      if ($file->name == $filename) {
        echo "matched $filename\n";
        return $file->hash;
      }
    }
    return FALSE;
  }
  
  public function setHash(FileHash $fh) {
    $fn = $fh->getFilename();
    $hash = $fh->getHash();
    
    print_r($fn);
    
    foreach($this->data->file as $file) {
      if ($file->name == $fn) {
        $file->hash = $hash;
        return TRUE;
      }
    }
    
    $db = $this->data[0];
    $f = $db->addChild('file');
    $f->addChild('name', $fn);
    $f->addChild('hash', $hash);
  }
  
  public function removeFile($filename) {
      for($i=0; $i < $this->data->db->count; $i++) {
        if ($this->data->db->file[$i]->name == $filename) {
          unset($this->data->db->file[$i]);
          return TRUE;
      }
    }
    return FALSE;
  }
  
}