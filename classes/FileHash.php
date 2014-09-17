<?php

abstract class FileHash {
  protected $filename;
  
    function __construct($filename) {
      $this->filename = realpath($filename);    
    }
    
    function getFilename() {
      return $this->filename;
    }
    
    abstract function getHash();
}