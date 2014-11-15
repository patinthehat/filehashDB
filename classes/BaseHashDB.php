<?php
  

abstract class BaseHashDB {
  protected $filename;
  protected $data;
  
  /**
   * Writes $data to the BaseHashDB filename.
   * Returns TRUE on successful write, FALSE on failure or bad filename.
   *
   * @param string $data
   * @return boolean
   */
  protected function write($data) {
    if (strlen($this->filename) > 0) {
      file_put_contents($this->filename, $data);
      return TRUE;
    }
    return FALSE;
  }
    
  public function __construct($filename) {
    $this->filename = $filename;
  }
  
  /**
   * Dumps the current database data to the console.  The data dumped is not what has been saved, but what is stored in memory.
   */
  public function dump() {
    print_r($this->data);
  }
    
  /**
   * Returns the database filename.
   */
  public function getDatabaseFilename() {
    return $this->filename;
  }
  
  /**
   * Compares the stored hash with the FileHash hash.
   * @param FileHash $fh
   * @return boolean Returns TRUE if the hashes match, FALSE if they are different.
   */
  public function compareHash(FileHash $fh) {
    $oldhash = $this->getHash($fh->getFilename());
    return ($oldhash == $fh->getHash());
  }
  
  public abstract function load();
  public abstract function save();
  public abstract function getHash($filename);
  public abstract function setHash(FileHash $fh);
  public abstract function removeFile($filename);
}