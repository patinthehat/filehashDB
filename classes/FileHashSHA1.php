<?php

class FileHashSHA1 extends FileHash {
  
  function getHash() {
    if (!file_exists($this->filename))
      return 0;
    
    return sha1_file($this->filename);
  } 
}