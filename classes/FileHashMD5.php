<?php

class FileHashSHA1 extends FileHash {
  
  function getHash() {
    if (!file_exists($this->filename))
      return 0;
    
    return md5_file($this->filename);
  } 
}