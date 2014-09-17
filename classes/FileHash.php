<?php

abstract class FileHash {
  protected $filename;
  
    function __construct($filename) {
      $this->filename = realpath($filename);    
    }
    
    function getFilename() {
      return $this->filename;
    }
    
    /**
     * Returns the hash of the specified file.  Must be implemented in child classes. 
     */
    abstract function getHash();
}